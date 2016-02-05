<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkweb/layout_config.php
*
* ArkDB Body Layout Configuration
* A class containing the configuration for an Ark Page Body Layout
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
* @link       http://ark.lparchaeology.com/code/php/arkweb/layout_config.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\Web;
use LPArchaeology\ARK;

class LayoutConfig
{
    private $_id = '';
    private $_valid = FALSE;
    private $_type = '';
    private $_markup = '';
    private $_options = array();
    private $_columns = array();

    // {{{ __construct()
    function __construct($layout_id = NULL)
    {
        if ($layout_id == NULL) {
            return;
        }
        $this->_id = $layout_id;
        global $ado;
        $element = $ado->elementConfig($layout_id);
        if (count($element) && $element['element_type'] == 'layout') {
            $this->_valid = TRUE;
            $this->_markup = $element['markup'];
            $options = ARK\DB\Option::elementOptions($this->_id);
            foreach ($options as $option) {
                switch ($option->id()) {
                    case 'op_display_type':
                        $this->_type = $option->value();
                        break;
                    default:
                        $this->_options[] = $option;
                        break;
                }
            }
            $this->_columns = ColumnConfig::elementColumns($this->_id);
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
    // {{{ type()
    function type()
    {
        return $this->_type;
    }
    // }}}
    // {{{ markup()
    function markup()
    {
        return $this->_markup;
    }
    // }}}
    // {{{ options()
    function options()
    {
        return $this->_options;
    }
    // }}}
    // {{{ columns()
    function columns()
    {
        return $this->_columns;
    }
    // }}}
    // {{{ config()
    function config()
    {
        if (!$this->isValid()) {
            return array();
        }
        $config['mkname'] = $this->markup();
        $config['op_display_type'] = $this->type();
        foreach ($this->options() as $option) {
            if ($option->isValid()) {
                $config[$option->id()] = $option->value();
            }
        }
        foreach ($this->columns() as $column) {
            if ($column->isValid()) {
                $config['columns'][] = $column->config();
            }
        }
        return $config;
    }
    // }}}
    // {{{ pageLayout()
    static function pageLayout($page_id, $module_id, $layout_role)
    {
        global $ado;
        $conf = $ado->pageLayout($page_id, $module_id, $layout_role, __METHOD__);
        if (count($conf)) {
            return new LayoutConfig($conf['layout_id']);
        }
        return new LayoutConfig();
    }
    // }}}
}

?>
