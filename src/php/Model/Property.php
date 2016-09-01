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

class Property extends AbstractResource
{
    protected $format = '';
    private $default = null;
    private $input = '';
    private $minItems = 0;
    private $maxItems = 1;
    private $uniqueItems = true;
    private $sortable = false;
    private $searchable = false;
    private $dataclass = '';
    private $enum = array();

    protected function __construct(Database $db, $id)
    {
        parent::__construct($db, $id);
    }

    protected function loadConfig($config)
    {
        parent::loadConfig($config);

        if (!isset($config['property'])) {
            return;
        }
        $this->id = $config['property'];
        $this->format = $config['format'];
        $this->type = $config['type'];
        $this->input = $config['input'];
        $this->minItems = $config['min_items'];
        $this->maxItems = $config['max_items'];
        $this->uniqueItems = (bool)$config['unique_items'];
        $this->sortable = (bool)$config['sortable'];
        $this->searchable = (bool)$config['searchable'];
        $this->dataclass = $config['dataclass'];
        $this->keyword = ($config['keyword'] ? $config['keyword'] : $config['format_keyword']);

        if ($this->dataclass == 'modtype') {
            $modtypes = $this->db->getModtypes($config['module'], $config['schema_id']);
            foreach ($modtypes as $modtype) {
                $this->enum[] = $modtype['modtype'];
            }
        } else if ($this->dataclass == 'module') {
            $this->enum[] = $config['module'];
        } else {
            $enums = $this->db->getEnums($this->id);
            foreach ($enums as $enum) {
                $this->enum[] = $enum['value'];
            }
        }

        $this->valid = true;
    }

    public function format()
    {
        return $this->format;
    }

    public function defaultValue()
    {
        return $this->default;
    }

    public function input()
    {
        return $this->input;
    }

    public function isArray()
    {
        return ($this->maxItems != 1);
    }

    public function minItems()
    {
        return $this->minItems;
    }

    public function maxItems()
    {
        return $this->maxItems;
    }

    public function uniqueItems()
    {
        return $this->uniqueItems;
    }

    public function hasEnum()
    {
        return (count($this->enum) > 0);
    }

    public function enum()
    {
        return $this->enum;
    }

    public function classtype()
    {
        return $this->classtype;
    }

    public function sortable()
    {
        return $this-sortable;
    }

    public function searchable()
    {
        return $this->searchable;
    }

    public function reference()
    {
        return "#/definitions/".$this->format;
    }

    public function definition($reference = Schema::ReferenceSchema)
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
        if ($this->default != null) {
            $attributes['default'] = $this->default;
        }
        if ($this->hasEnum()) {
            $attributes['enum'] = $this->enum();
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
            if ($this->minItems > 0) {
                $array['minItems'] = $this->minItems;
            }
            if ($this->maxItems > 1) {
                $array['maxItems'] = $this->maxItems;
            }
            $array['uniqueItems'] = $this->uniqueItems;
            return $array;
        }
        return $schema;
    }

    protected function mode()
    {
        if ($this->maxItems == 1) {
            return Database::FetchFirst;
        }
        return Database::FetchAll;
    }

    protected function value($data, $field, $field2 = null)
    {
        if (!$data) {
            return null;
        }
        if ($this->maxItems == 1) {
            if ($field2) {
                return array($data[$field], $data[$field2]);
            }
            return $data[$field];
        }
        $values = null;
        foreach ($data as $row) {
            if ($field2) {
                $values[] = array($row[$field], $row[$field2]);
            } else {
                $values[] = $row[$field];
            }
        }
        return $values;
    }

    public function data(Item $item, $lang)
    {
        switch ($this->dataclass) {
            case 'action':
                $data =  $this->db->getAction($item->itemkey(), $item->itemvalue(), $this->id, $this->mode());
                $value = $this->value($data, 'actor_itemkey', 'actor_itemvalue');
                break;
            case 'attribute':
                $data =  $this->db->getAttribute($item->itemkey(), $item->itemvalue(), $this->id, $this->mode());
                $value = $this->value($data, 'attribute');
                break;
            case 'date':
                $data = $this->db->getDate($item->itemkey(), $item->itemvalue(), $this->id, $this->mode());
                $value = $this->value($data, 'date');
                break;
            case 'file':
                $data = $this->db->getFile($item->itemkey(), $item->itemvalue(), $this->id, $this->mode());
                $value = $this->value($data, 'filename');
                break;
            case 'number':
                $data = $this->db->getNumber($item->itemkey(), $item->itemvalue(), $this->id, $this->mode());
                $value = $this->value($data, 'number');
                break;
            case 'span':
                $data = $this->db->getSpan($item->itemkey(), $item->itemvalue(), $this->id, $this->mode());
                $value = $this->value($data, 'beg', 'end');
                break;
            case 'txt':
                $data = $this->db->getText($item->itemkey(), $item->itemvalue(), $this->id, $lang, $this->mode());
                $value = $this->value($data, 'txt');
                break;
            case 'xmi':
                $data = $this->db->getXmi($item->itemkey(), $item->itemvalue(), $this->id, $this->mode());
                $value = $this->value($data, 'xmi_itemkey', 'xmi_itemvalue');
                break;
            case 'modtype':
                $value = $item->modtype();
                break;
            case 'item':
                $value = $item->id();
                break;
            case 'module':
                $value = $item->module();
                break;
            case 'site':
                $value = $item->site();
                break;
            default:
                $value = 'dataclass = '.$this->dataclass;
                break;
        }
        return $value;
    }

    static private function createFromConfig($db, $id, $config)
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
        $property->loadConfig($config);
        return $property;
    }

    static public function get(Database $db, $property)
    {
        $config = $db->getProperty($property);
        return Property::createFromConfig($db, $property, $config);
    }

    public function getAllSchema(Database $db, $schema, $type, $enabled = true)
    {
        $properties = array();
        $configs = $this->db->getSchemaProperties($schema, $type);
        foreach ($configs as $config) {
            $property = Property::createFromConfig($db, $config['property'], $config);
            if ($property->isValid() && ($config['enabled'] || !$enabled)) {
                $element['property'] = $property;
                $element['subtype'] = $config['modtype'];
                $element['required'] = $config['required'];
                $element['enabled'] = $config['enabled'];
                $element['deprecated'] = $config['deprecated'];
                $properties[$property->id()] = $element;
            }
        }
        return $properties;
    }

    public function getAllObject(Database $db, $object)
    {
        $properties = array();
        $configs = $this->db->getObjectProperties($object);
        foreach ($configs as $config) {
            $property = Property::createFromConfig($db, $config['property'], $config);
            if ($property->isValid()) {
                $element['property'] = $property;
                $element['subtype'] = $object;
                $element['required'] = $config['required'];
                $element['graph_root'] = $config['graph_root'];
                $properties[$property->id()] = $element;
            }
        }
        return $properties;
    }
}