<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Option.php
*
* ARK View Option
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Option.php
* @since      2.0
*
*/

namespace ARK\View;

use ARK\Database\Database;

class Option
{
    private $_type = '';
    private $_key = '';
    private $_value = null;
    private $_valid = false;

    private function __construct($key = null, $value = null)
    {
        if (!$key || !$value) {
            return;
        }
        $this->_key = $key;
        $this->setValue($value);
        $this->_valid = true;
    }

    private function _loadConfig($db, $config)
    {
        if (!isset($config['type']) || !isset($config['opt']) || !isset($config['value'])) {
            return;
        }
        $this->_key = $config['opt'];
        if ($config['type'] == 'field') {
            $this->setValue(new Field($db, $config['value']));
        } else {
            $this->setValue(unserialize($config['value']));
        }
        $this->_valid = true;
    }

    function isValid()
    {
        return $this->_valid;
    }

    function type()
    {
        return $this->_type;
    }

    function key()
    {
        return $this->_key;
    }

    function value()
    {
        return $this->_value;
    }

    function setValue($value)
    {
        $this->_value = $value;
        $this->_type = gettype($value);
        if ($this->_type == 'object') {
            $this->_type = get_class($value);
        }
    }

    static function fetchOption(Database $db, $element, $option)
    {
        $option = new Option();
        $config =  $db->getOption($element, $option);
        $option->_loadConfig($db, $config);
        return $option;
    }

    static function fetchOptions(Database $db, $element)
    {
        $options = array();
        $rows =  $db->getOptions($element);
        foreach ($rows as $config) {
            $option = new Option();
            $option->_loadConfig($db, $config);
            if ($option->isValid()) {
                $options[$option->key()] = $option;
            }
        }
        return $options;
    }

    static function fetchOptionsArray(Database $db, $element)
    {
        $optionsArray = array();
        $options = Option::fetchOptions($db, $element);
        foreach ($options as $option) {
            $optionsArray[$option->key()] = $option->value();
        }
        return $optionsArray;
    }
}