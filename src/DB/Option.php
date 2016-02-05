<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkdb/option.php
*
* ArkDB Configuration Option
* A class containing an Ark Config Option
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
* @link       http://ark.lparchaeology.com/code/php/arkdb/option.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\DB;

class Option
{
    private $_id = '';
    private $_valid = FALSE;
    private $_type = '';
    private $_value = FALSE;

    // {{{ __construct()
    function __construct($element_id = NULL, $option_id = NULL)
    {
        if ($element_id == NULL or $option_id == NULL) {
            return;
        }
        global $ado;
        $config = $ado->elementOption($element_id, $option_id);
        $this->_loadConfig($config);
    }
    // }}}
    // {{{ _loadConfig()
    private function _loadConfig($config)
    {
        //if (!count($config) or (!array_key_exists('value', $config) and $config['type'] != 'smart')) {
        //    return;
        //}
        $this->_id = $config['option_id'];
        $this->_valid = TRUE;
        $this->_type = $config['type'];
        $this->_value = $config['value'];
        switch ($this->_type) {
            case 'field':
                $this->_value = new FieldConfig($config['value']);
                break;
            //case 'smart':
            //    if (array_key_exists('value', $config)) {
            //        $this->_value = $config['value'];
            //    } else {
            //        $this->_value = NULL;
            //    }
            //    break;
            default:
                $this->_value = unserialize($config['value']);
                break;
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
    // {{{ value()
    function value()
    {
        return $this->_value;
    }
    // }}}
    // {{{ config()
    function config()
    {
        $config[$this->_id] = $this->_value;
        return $config;
    }
    // }}}
    // {{{ elementOptions()
    static function elementOptions($element_id)
    {
        global $ado;
        $options = array();
        $rows = $ado->elementOptions($element_id, __METHOD__);
        foreach ($rows as $row) {
            $option = new Option();
            $option->_loadConfig($row);
            if ($option->isValid()) {
                $options[] = $option;
            }
        }
        return $options;
    }
    // }}}
    // {{{ elementOptionsArray()
    static function elementOptionsArray($element_id)
    {
        $optionsArray = array();
        $options = Option::elementOptions($element_id);
        foreach ($options as $option) {
            $optionsArray[$option->id()] = $option->value();
        }
        return $optionsArray;
    }
    // }}}
}

?>
