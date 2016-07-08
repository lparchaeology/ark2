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

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class Option
{
    private $_type = '';
    private $_key = '';
    private $_value = null;
    private $_valid = false;

    // {{{ __construct()
    private function __construct($type = null, $key = null, $value = null)
    {
        $config = array('type' => $type, 'option_id' => $key, 'value' => $value);
        $this->_loadConfig(null, $config);
    }
    // }}}
    // {{{ _loadConfig()
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
            //case 'smart':
            //    if (array_key_exists('value', $config)) {
            //        $this->_value = $config['value'];
            //    } else {
            //        $this->_value = null;
            //    }
            //    break;
            default:
                $this->_value = unserialize($config['value']);
                break;
        }
        $this->_valid = true;
    }
    // }}}
    // {{{ key()
    function key()
    {
        return $this->_key;
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
        $config[$this->_key] = $this->_value;
        return $config;
    }
    // }}}
    // {{{ fetchOption()
    static function fetchOption(Connection $db, $element_id, $option_id)
    {
        $option = new Option();
        try {
            $config =  $db->fetchAssoc('SELECT * FROM cor_conf_option WHERE element_id = ? AND option_id = ?', array($element_id, $option_id));
            $option->_loadConfig($db, $config);
        } catch (DBALException $e) {
            return $option;
        }
        return $option;
    }
    // }}}
    // {{{ fetchOptions()
    static function fetchOptions(Connection $db, $element_id)
    {
        $options = array();
        try {
            $rows =  $db->fetchAll('SELECT * FROM cor_conf_option WHERE element_id = ?', array($element_id));
            foreach ($rows as $config) {
                $option = new Option();
                $option->_loadConfig($db, $config);
                if ($option->isValid()) {
                    $options[] = $option;
                }
            }
        } catch (DBALException $e) {
            return array();
        }
        return $options;
    }
    // }}}
    // {{{ fetchOptionsArray()
    static function fetchOptionsArray(Connection $db, $element_id)
    {
        $optionsArray = array();
        $options = Option::options($db, $element_id);
        foreach ($options as $option) {
            $optionsArray[$option->key()] = $option->value();
        }
        return $optionsArray;
    }
    // }}}
}
