<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Option.php
*
* ARK Schema Option
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Option.php
* @since      2.0
*
*/

namespace ARK\Schema;

use ARK\Database\Database;

class Option
{
    private $_type = '';
    private $_key = '';
    private $_value = null;
    private $_valid = false;

    private function __construct($type = null, $key = null, $value = null)
    {
        $config = array('type' => $type, 'option_id' => $key, 'value' => $value);
        $this->_loadConfig(null, $config);
    }

    private function _loadConfig($db, $config)
    {
        if (!isset($config['type']) || !isset($config['option_id']) || !isset($config['value'])) {
            return;
        }
        $this->_type = $config['type'];
        $this->_key = $config['option_id'];
        switch ($this->_type) {
            case 'field':
                $this->_value = new Field($db, $config['value']);
                break;
            default:
                $this->_value = unserialize($config['value']);
                break;
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

    static function fetchOption(Database $db, $element_id, $option_id)
    {
        $option = new Option();
        try {
            $config =  $db->getOptions($element_id, $option_id);
            $option->_loadConfig($db, $config);
        } catch (DBALException $e) {
            return $option;
        }
        return $option;
    }

    static function fetchOptions(Database $db, $element_id)
    {
        $options = array();
        try {
            $rows =  $db->getOptions($element_id);
            foreach ($rows as $config) {
                $option = new Option();
                $option->_loadConfig($db, $config);
                if ($option->isValid()) {
                    $options[$option->key()] = $option;
                }
            }
        } catch (DBALException $e) {
            return array();
        }
        return $options;
    }

    static function fetchOptionsArray(Database $db, $element_id)
    {
        $optionsArray = array();
        $options = Option::fetchOptions($db, $element_id);
        foreach ($options as $option) {
            $optionsArray[$option->key()] = $option->value();
        }
        return $optionsArray;
    }
}
