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

use ARK\AbstractObject;
use ARK\Database\Database;

class Property extends AbstractObject
{
    protected $format = '';
    private $dataclass = '';
    private $defaultValue = null;
    private $minValues = 0;
    private $maxValues = 1;
    private $uniqueValues = true;
    private $additionalValues = false;
    private $allowedValues = array();
    private $literal = true;
    private $sortable = false;
    private $searchable = false;
    private $input = '';

    protected function __construct(Database $db, string $id)
    {
        parent::__construct($db, $id);
    }

    protected function init(array $config)
    {
        parent::init($config);

        if (!isset($config['property'])) {
            return;
        }
        $this->id = $config['property'];
        $this->format = $config['format'];
        $this->dataclass = $config['dataclass'];
        $this->type = $config['type'];
        $this->minValues = $config['min_values'];
        $this->maxValues = $config['max_values'];
        $this->uniqueValues = (bool)$config['unique_values'];
        $this->additionalValues = (bool)$config['additional_values'];
        $this->literal = (bool)$config['literal'];
        $this->sortable = (bool)$config['sortable'];
        $this->searchable = (bool)$config['searchable'];
        $this->input = $config['input'];
        $this->keyword = ($config['keyword'] ? $config['keyword'] : $config['format_keyword']);

        if ($this->id == 'modtype') {
            $modtypes = $this->db->getModtypes($config['module'], $config['schema_id']);
            foreach ($modtypes as $modtype) {
                $this->allowedValues[$modtype['modtype']] = $modtype['keyword'];
            }
        } else {
            $allowedValues = $this->db->getAllowedValues($this->id);
            foreach ($allowedValues as $allowedValue) {
                $this->allowedValues[$allowedValue['value']] = $allowedValue['keyword'];
            }
        }

        $this->valid = true;
    }

    public function format()
    {
        return $this->format;
    }

    public function dataclass()
    {
        return $this->dataclass;
    }

    public function defaultValue()
    {
        return $this->defaultValue;
    }

    public function multipleValues()
    {
        return ($this->maxValues != 1);
    }

    public function minValues()
    {
        return $this->minValues;
    }

    public function maxValues()
    {
        return $this->maxValues;
    }

    public function uniqueValues()
    {
        return $this->uniqueValues;
    }

    public function additionalValues()
    {
        return $this->additionalValues;
    }

    public function hasAllowedValues()
    {
        return (count($this->allowedValues) > 0);
    }

    public function allowedValues()
    {
        return $this->allowedValues;
    }

    public function literal()
    {
        return $this->literal;
    }

    public function sortable()
    {
        return $this->sortable;
    }

    public function searchable()
    {
        return $this->searchable;
    }

    public function input()
    {
        return $this->input;
    }

    public function reference()
    {
        return "#/definitions/".$this->format;
    }

    public function definition(int $reference = Schema::ReferenceSchema)
    {
        $definition = array();
        if ($reference) {
            $definition['$ref'] = $this->reference();
        } else {
            $definition['type'] = $this->type();
        }
        return $definition;
    }

    public function attributes()
    {
        $attributes = array();
        if ($this->keyword) {
            $attributes['title'] = $this->keyword.'.title';
            $attributes['description'] = $this->keyword.'.description';
        }
        if ($this->defaultValue != null) {
            $attributes['default'] = $this->default;
        }
        if ($this->hasallowedValues()) {
            $attributes['allowedValues'] = array_keys($this->allowedValues());
        }
        return $attributes;
    }

    public function subschema(int $reference = Schema::ReferenceSchema)
    {
        $schema = $this->attributes();
        if (!$reference || $this->format() == 'object') {
            $schema = array_merge($schema, $this->definition($reference));
        } else {
            $schema['$ref'] = $this->reference();
        }

        if ($this->multipleValues()) {
            $array['type'] = 'array';
            $array['items'] = $schema;
            $array['additionalItems'] = $this->additionalValues;
            if ($this->minValues > 0) {
                $array['minItems'] = $this->minValues;
            }
            if ($this->maxValues > 1) {
                $array['maxItems'] = $this->maxValues;
            }
            $array['uniqueItems'] = $this->uniqueValues;
            return $array;
        }
        return $schema;
    }

    private static function createFromConfig(Database $db, string $id, array $config)
    {
        if (isset($config['type'])) {
            switch ($config['type']) {
                case 'object':
                    $property = new ObjectProperty($db, $id);
                    break;
                case 'array':
                    $property = new ArrayProperty($db, $id);
                    break;
                case 'string':
                    $property = new StringProperty($db, $id);
                    break;
                case 'number':
                    $property = new NumberProperty($db, $id);
                    break;
                default:
                    $property = new Property($db, $id);
                    break;
            }
        } else {
            $property = new Property($db, $id);
        }
        $property->init($config);
        return $property;
    }

    public static function get(Database $db, string $property)
    {
        $config = $db->getProperty($property);
        return Property::createFromConfig($db, $property, $config);
    }

    public static function getModtype(Database $db, string $schemaId, string $type, bool $enabled = true)
    {
        $config = $db->getProperty('modtype');
        $config['module'] = $type;
        $config['schema_id'] = $schemaId;
        return Property::createFromConfig($db, 'modtype', $config);
    }

    public static function getAllSchema(Database $db, string $schemaId, string $type, bool $enabled = true)
    {
        $properties = array();
        $configs = $db->getSchemaProperties($schemaId, $type);
        foreach ($configs as $config) {
            $config['schema_id'] = $schemaId;
            $property = Property::createFromConfig($db, $config['property'], $config);
            if ($property->isValid() && ($config['enabled'] || !$enabled)) {
                $element['property'] = $property;
                $element['modtype'] = $config['modtype'];
                $element['required'] = (bool)$config['required'];
                $element['enabled'] = (bool)$config['enabled'];
                $element['deprecated'] = (bool)$config['deprecated'];
                $properties[$property->id()] = $element;
            }
        }
        return $properties;
    }

    public static function getAllObject(Database $db, string $object)
    {
        $properties = array();
        $configs = $db->getObjectProperties($object);
        foreach ($configs as $config) {
            $config['schema_id'] = $schemaId;
            $property = Property::createFromConfig($db, $config['property'], $config);
            if ($property->isValid()) {
                $element['property'] = $property;
                $element['modtype'] = $object;
                $element['required'] = $config['required'];
                $element['graph_root'] = $config['graph_root'];
                $properties[$property->id()] = $element;
            }
        }
        return $properties;
    }
}
