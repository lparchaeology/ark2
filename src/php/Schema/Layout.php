<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Layout.php
*
* ARK Schema Layout
*
* PHP version 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Heritage LLP.
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Layout.php
* @since      2.0
*
*/

namespace ARK\Schema;

use ARK\Database\Database;

class Layout extends Group
{
    protected $_template = '';

    function __construct(Database $db = null, $layout_id = null, $mod = null, $modtype = null)
    {
        if ($db == null || $layout_id == null) {
            return;
        }
        parent::__construct($db, $layout_id);
    }

    private function _loadConfig($config)
    {
        if (!isset($config['template'])) {
            return;
        }
        $this->_template = $config['template'];
        $this->_valid = true;
    }

    function template()
    {
        if (isset($this->_options['template'])) {
            return $this->_options['template'];
        } else {
            return $this->_template;
        }
    }

    static function fetchLayout(Database $db, $layout_id)
    {
        try {
            $config =  $db->config()->fetchAssoc('SELECT * FROM ark_config_layout WHERE layout_id = ?', array($layout_id));
            $layout = new $config['class']($db, $layout_id);
            $layout->_loadConfig($config);
            return $layout;
        } catch (DBALException $e) {
            return new Layout();
        }
    }

}
