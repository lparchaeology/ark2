<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkdb/module.php
*
* ArkDB Module Configuration
* A class containing the configuration for an Ark Module
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
* @category   base
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/php/arkdb/module.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\DB;

class ModuleConfig
{
    private $_id = '';
    private $_valid = FALSE;
    private $_name = '';
    private $_markup = '';
    private $_itemKey = '';
    private $_table = '';
    private $_typeTable = '';
    private $_description = '';
    private $_enabled = FALSE;

    // {{{ __construct()
    function __construct()
    {
    }
    // }}}
    // {{{ _loadConfig()
    private function _loadConfig($moduleId, $config)
    {
        $this->_id = $moduleId;
        $this->_valid = TRUE;
        $this->_name = $config['name'];
        $this->_markup = $config['markup'];
        $this->_itemKey = $config['itemkey'];
        $this->_table = $config['tbl'];
        $this->_typeTable = $config['type_lut_tbl'];
        $this->_enabled = $config['enabled'];
        $this->_description = $config['description'];
    }
    // }}}
    // {{{ id()
    function id()
    {
        return $this->_id;
    }
    // }}}
    // {{{ isValid()
    function isValid()
    {
        return $this->_valid;
    }
    // }}}
    // {{{ name()
    function name()
    {
        return $this->_name;
    }
    // }}}
    // {{{ markup()
    function markup()
    {
        return $this->_markup;
    }
    // }}}
    // {{{ itemKey()
    function itemKey()
    {
        return $this->_itemKey;
    }
    // }}}
    // {{{ table()
    function table()
    {
        return $this->_table;
    }
    // }}}
    // {{{ typeTable()
    function typeTable()
    {
        return $this->_typeTable;
    }
    // }}}
    // {{{ isEnabled()
    function isEnabled()
    {
        return $this->_enabled;
    }
    // }}}
    // {{{ description()
    function description()
    {
        return $this->_description;
    }
    // }}}
    // {{{ module()
    static function module($moduleId)
    {
        global $ado;
        $row = $ado->getRow('cor_conf_module', array('module_id'), array($moduleId), 'ModuleConfig::module()');
        $config = new ModuleConfig();
        $module->_loadConfig($pageId, $config);
        return $module;
    }
    // }}}
    // {{{ modules()
    static function modules()
    {
        global $ado;
        $rows = $ado->getRows('cor_conf_module', array('enabled'), array(TRUE), 'ModuleConfig::modules()');
        foreach ($rows as $config) {
            $module = new ModuleConfig();
            $module->_loadConfig($config['module_id'], $config);
            $modules[$config['module_id']] = clone $module;
        };
        return $modules;
    }
    // }}}
}
?>
