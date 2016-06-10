<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Database/Configuration.php
*
* Ark Database Configuration
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Database/Configuration.php
* @since      2.0
*/

namespace ARK\Database;

use Doctrine\DBAL\Connection;

class Configuration
{
    private $_settings = array();

    public function __construct($localFile, $globalFile='')
    {
        // Load the config for the current ARK instance if it exists
        if ($localFile && file_exists($localFile)) {
            $local = json_decode(file_get_contents($localFile), true);
            if (!is_array($local)) {
                $local = array();
            }
        } else {
            $local = array();
        }

        // Load the config for the global ARK install if it exists
        if ($globalFile && file_exists($globalFile)) {
            $global = json_decode(file_get_contents($globalFile), true);
            if (!is_array($global)) {
                $global = array();
            }
        } else {
            $global = array();
        }

        // Override any global config with any local config
        $this->_settings = array_replace($global, $local);
        if (isset($global['servers']) and isset($local['servers'])) {
            $this->_settings['servers'] = array_replace($global['servers'], $local['servers']);
        } else if (!isset($this->_settings['servers'])) {
            $this->_settings['servers'] = array('default' => array());
        }
        if (isset($global['databases']) and isset($local['databases'])) {
            $this->_settings['databases'] = array_replace($global['databases'], $local['databases']);
        } else if (!isset($this->_settings['databases'])) {
            $this->_settings['databases'] = array('default' => array());
        }
        if (isset($global['connections']) and isset($local['connections'])) {
            $this->_settings['connections'] = array_replace($global['connections'], $local['connections']);
        } else if (!isset($this->_settings['connections'])) {
            $this->_settings['connections'] = array('default' => array('server' => 'default', 'database' => 'default'));
        }
        if (isset($global['roles']) and isset($local['roles'])) {
            $this->_settings['roles'] = array_replace($global['roles'], $local['roles']);
        } else if (!isset($this->_settings['roles'])) {
            $this->_settings['roles'] = array('default' => 'default');
        }
    }

    public function roles()
    {
        $default = $this->_settings['roles']['default'];
        $roles[] = 'default';
        foreach ($this->_settings['roles'] as $role => $key) {
            if ($key != $default) {
                $roles[] = $role;
            }
        }
        return $roles;
    }

    public function hasRole($role)
    {
        return in_array($role, $this->roles());
    }

    public function server($role)
    {
        if (isset($this->_settings['roles'][$role])) {
            $key = $this->_settings['roles'][$role];
        } else {
            $key = 'default';
        }
        return $this->_settings['servers'][$key];
    }

    public function servers()
    {
        return $this->_settings['servers'];
    }

    public function connection($role)
    {
        if (!isset($this->_settings['connections'][$role])) {
            $role = 'default';
        }
        $server = $this->_settings['connections'][$role]['server'];
        $database = $this->_settings['connections'][$role]['database'];
        return $this->_connection($server, $database);
    }

    private function _connection($server, $database)
    {
        $server = $this->_settings['servers'][$server];
        $database = $this->_settings['databases'][$database];
        return array_replace($server, $database);
    }

    public function connections()
    {
        $conns = array();
        foreach ($this->_settings['connections'] as $role => $vals) {
            $conn = $this->_connection($vals['server'], $vals['database']);
            if (count($conn)) {
                $conns[$role] = $conn;
            }
        }
        return $conns;
    }

}
