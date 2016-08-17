<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Property.php
*
* ARK Schema Property
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Property.php
* @since      2.0
*
*/

namespace ARK\Schema;

use ARK\Database\Database;

class Property
{
    private $_id = '';
    private $_format = '';
    private $_type = '';
    private $_input = '';
    private $_minItems = 0;
    private $_maxItems = 1;
    private $_uniqueItems = true;
    private $_enum = array();
    private $_module = '';
    private $_dataclass = '';
    private $_keyword = '';
    private $_valid = false;

    private function _loadConfig($config)
    {
        $this->_id = $config['property'];
        $this->_format = $config['format'];
        $this->_type = $config['type'];
        $this->_input = $config['input'];
        $this->_minItems = $config['min_items'];
        $this->_maxItems = $config['max_items'];
        $this->_uniqueItems = (bool)$config['unique_items'];
        $this->_sortable = (bool)$config['sortable'];
        $this->_searchable = (bool)$config['searchable'];
        $this->_enum = $config['enum'];
        $this->_module = $config['module'];
        $this->_dataclass = $config['dataclass'];
        $this->_keyword = $config['keyword'];
        $this->_valid = true;
    }

    public function id()
    {
        return $this->_id;
    }

    public function type()
    {
        return $this->_type;
    }

    public function input()
    {
        return $this->_input;
    }

    public function isArray()
    {
        return ($this->_maxItems != 1);
    }

    public function minItems()
    {
        return $this->_minItems;
    }

    public function maxItems()
    {
        return $this->_maxItems;
    }

    public function uniqueItems()
    {
        return $this->_uniqueItems;
    }

    public function hasEnum()
    {
        return (count($this->_enum) > 0);
    }

    public function enum()
    {
        return $this->_enum;
    }

    public function module()
    {
        return $this->_module;
    }

    public function classtype()
    {
        return $this->_classtype;
    }

    public function keyword()
    {
        return $this->_keyword;
    }

    public function sortable()
    {
        return $this->optionValue('sortable', true);
    }

    public function sortOrder()
    {
        return $this->optionValue('sortOrder', 'asc');
    }

    public function searchable()
    {
        return $this->optionValue('searchable', true);
    }

    public function toSchema()
    {
        $schema = array('title' => $this->_title);
        return array($this->_id => $schema);
    }

    static public function property(Database $db, $propertyId)
    {
        $config = $db->getSchemaProperty($propertyId);
        $property = null;
        switch ($config['type']) {
            case 'object':
                $property = new ObjectProperty();
                break;
            case 'string':
                $property = new StringProperty();
                break;
            case 'number':
                $property = new NumberProperty();
                break;
            default:
                $property = new Property();
                break;
        }
        $property->_loadConfig($config);
        return $property;
    }

}
