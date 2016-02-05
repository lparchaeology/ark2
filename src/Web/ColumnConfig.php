<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkweb/column_config.php
*
* ArkDB Column Configuration
* A class containing the configuration for an Ark Column
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
* @link       http://ark.lparchaeology.com/code/php/arkweb/column_config.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\Web;
use LPArchaeology\ARK;

class ColumnConfig
{
    private $_id = '';
    private $_valid = FALSE;
    private $_enabled = FALSE;
    private $_key = '';
    private $_type = '';
    private $_alias = NULL;
    private $_options = array();
    private $_subforms = array();

    // {{{ __construct()
    function __construct($column_id = NULL)
    {
        if ($column_id == NULL) {
            $this->_alias = new \ArkDB\AliasConfig();
            return;
        }
        global $ado;
        $config = $ado->elementConfig($column_id, __METHOD__);
        $this->_loadConfig($config);
    }
    // }}}
    // {{{ _loadConfig()
    private function _loadConfig($config)
    {
        if (count($config)) {
            $this->_valid = TRUE;
            $this->_id = $config['element_id'];
            $options = ARK\DB\Option::elementOptions($this->_id);
            foreach ($options as $option) {
                switch ($option->id()) {
                    case 'col_id':
                        $this->_key = $option->value();
                        break;
                    case 'col_type':
                        $this->_type = $option->value();
                        break;
                    default:
                        $this->_options[] = $option;
                        break;
                }
            }
            $this->_alias = new ARK\DB\AliasConfig($this->_id);
            $this->_subforms = SubformConfig::elementSubforms($this->_id);
        }
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
    // {{{ key()
    function key()
    {
        return $this->_key;
    }
    // }}}
    // {{{ type()
    function type()
    {
        return $this->_type;
    }
    // }}}
    // {{{ alias()
    function alias()
    {
        return $this->_alias;
    }
    // }}}
    // {{{ options()
    function options()
    {
        return $this->_options;
    }
    // }}}
    // {{{ subforms()
    function subforms()
    {
        return $this->_subforms;
    }
    // }}}
    // {{{ config()
    function config()
    {
        if (!$this->isValid()) {
            return array();
        }
        $config['col_id'] = $this->key();
        $config['col_type'] = $this->type();
        $config['col_alias'] = $this->alias()->config();
        foreach ($this->options() as $option) {
            if ($option->isValid()) {
                $config[$option->id()] = $option->value();
            }
        }
        foreach ($this->subforms() as $subform) {
            if ($subform->isValid()) {
                $config['subforms'][] = $subform->config();
            }
        }
        return $config;
    }
    // }}}
    // {{{ elementColumns()
    static function elementColumns($element_id, $enabled = TRUE)
    {
        global $ado;
        $children = $ado->elementGroup($element_id, 'column', $enabled, __METHOD__);
        $columns = array();
        foreach ($children as $child) {
            $column = new ColumnConfig($child['child_id']);
            if ($column->isValid()) {
                $columns[] = $column;
            }
        }
        return $columns;
    }
    // }}}
}

?>
