<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/Property.php
*
* ARK Model Property
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/Property.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

class Property
{
    private $_id = '';
    protected $_format = '';
    private $_type = '';
    private $_default = null;
    private $_input = '';
    private $_minItems = 0;
    private $_maxItems = 1;
    private $_uniqueItems = true;
    private $_sortable = false;
    private $_searchable = false;
    private $_dataclass = '';
    private $_keyword = '';
    private $_enum = array();
    protected $_valid = false;

    protected function _loadConfig(Database $db, $config)
    {
        if (!isset($config['property'])) {
            return;
        }
        $this->_id = $config['property'];
        $this->_format = $config['format'];
        $this->_type = $config['type'];
        $this->_input = $config['input'];
        $this->_minItems = $config['min_items'];
        $this->_maxItems = $config['max_items'];
        $this->_uniqueItems = (bool)$config['unique_items'];
        $this->_sortable = (bool)$config['sortable'];
        $this->_searchable = (bool)$config['searchable'];
        $this->_dataclass = $config['dataclass'];
        $this->_keyword = ($config['keyword'] ? $config['keyword'] : $config['format_keyword']);

        if ($this->_dataclass == 'modtype') {
            $modtypes = $db->getModtypes($config['module'], $config['schema']);
            foreach ($modtypes as $modtype) {
                $this->_enum[] = $modtype['modtype'];
            }
        } else if ($this->_dataclass == 'module') {
            $this->_enum[] = $config['module'];
        } else {
            $this->_enum = $db->getEnums($this->_id);
        }

        $this->_valid = true;
    }

    public function id()
    {
        return $this->_id;
    }

    public function format()
    {
        return $this->_format;
    }

    public function type()
    {
        return $this->_type;
    }

    public function defaultValue()
    {
        return $this->_default;
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
        return $this-_sortable;
    }

    public function searchable()
    {
        return $this->_searchable;
    }

    public function reference()
    {
        return "#/definitions/".$this->_format;
    }

    public function definition($reference = Schema::ReferenceSchema)
    {
        $definition = array();
        if ($reference) {
            $definition['$ref'] = $this->reference();
        } else {
            $definition['type'] = $this->_type;
        }
        return $definition;
    }

    public function attributes()
    {
        $attributes = array();
        if ($this->_keyword) {
            $attributes['title'] = $this->_keyword.'.title';
            $attributes['description'] = $this->_keyword.'.description';
        }
        if ($this->_default != null) {
            $attributes['default'] = $this->_default;
        }
        if ($this->hasEnum()) {
            $attributes['enum'] = $this->_enum;
        }
        return $attributes;
    }

    public function subschema($reference = Schema::ReferenceSchema)
    {
        $schema = $this->attributes();
        if (!$reference || $this->format() == 'object') {
            $schema = array_merge($schema, $this->definition($reference));
        } else {
            $schema['$ref'] = $this->reference();
        }

        if ($this->isArray()) {
            $array['type'] = 'array';
            $array['items'] = $schema;
            $array['additionalItems'] = false;
            if ($this->_minItems > 0) {
                $array['minItems'] = $this->_minItems;
            }
            if ($this->_maxItems > 1) {
                $array['maxItems'] = $this->_maxItems;
            }
            $array['uniqueItems'] = $this->_uniqueItems;
            return $array;
        }
        return $schema;
    }

    static public function property(Database $db, $propertyId, $schema = null)
    {
        $config = $db->getProperty($propertyId);
        $config['schema'] = $schema;
        $property = null;
        switch ($config['type']) {
            case 'object':
                $property = new ObjectProperty();
                break;
            case 'array':
                $property = new ArrayProperty();
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
        $property->_loadConfig($db, $config);
        return $property;
    }

}
