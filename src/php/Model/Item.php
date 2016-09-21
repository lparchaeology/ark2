<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/Item.php
*
* ARK Model Item
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/Item.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

class Item
{
    private $db = null;
    private $module = null;
    private $id = null;
    private $parent = null;
    private $index = null;
    private $modtype = '';
    private $schemaId = null;
    protected $valid = false;

    protected function init(Database $db, Module $module, array $config)
    {
        $this->db = $db;
        $this->module = $module;
        $this->id = $config['item'];
        $this->parent = $config['parent'];
        $this->index = $config['idx'];
        if (isset($config['modtype'])) {
            $this->modtype = $config['modtype'];
        }
        if (isset($config['schema_id'])) {
            $this->schemaId = $config['schema_id'];
        } else {
            $this->schemaId = $module->schemaId();
        }
        $this->valid = true;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function module()
    {
        return $this->module;
    }

    // TODO temp for use in Forms
    public function moduleId()
    {
        return $this->module->id();
    }

    public function id()
    {
        return $this->id;
    }

    public function parent()
    {
        return $this->parent;
    }

    public function index()
    {
        return $this->index;
    }

    public function modtype()
    {
        return $this->modtype;
    }

    public function schemaId()
    {
        return $this->schemaId;
    }

    public function schema(int $reference = Schema::ReferenceSchema)
    {
        return $this->module->schema($this->schemaId, $reference);
    }

    public function properties()
    {
        return $this->module->properties($this->schemaId, $this->modtype);
    }

    public function property(string $property)
    {
        return $this->module->property($this->schemaId, $this->modtype, $property);
    }

    public function required()
    {
        return $this->module->required($this->schemaId, $this->modtype);
    }

    public function definitions()
    {
        return $this->module->definitions($this->schemaId);
    }

    public function attributes()
    {
        $attributes = array();
        foreach ($this->properties() as $property) {
            $attributes[$property->id()] = $this->attribute($property);
        }
        return $attributes;
    }

    public function attribute(Property $property)
    {
            switch ($property->dataclass()) {
            case 'blob':
            case 'boolean':
            case 'date':
            case 'datetime':
            case 'float':
            case 'integer':
            case 'string':
            case 'time':
                $data = $this->db->getDataclassFragments($this->module()->id(), $this->id(), $property->id(), $property->dataclass());
                return $this->value($data, $property->isArray(), 'value');
            case 'file':
                $data = $this->db->getDataclassFragments($this->module()->id(), $this->id(), $property->id(), $property->dataclass());
                return $this->value($data, $property->isArray(), 'filename');
            case 'action':
                $data =  $this->db->getDataclassFragments($this->module()->id(), $this->id(), $property->id(), $property->dataclass());
                return $this->keyedValues($data, $property->isArray(), 'actor_module', 'actor_item');
            case 'span':
                $data = $this->db->getDataclassFragments($this->module()->id(), $this->id(), $property->id(), $property->dataclass());
                return $this->keyedValues($data, $property->isArray(), 'beg', 'end');
            case 'text':
                $data = $this->db->getDataclassFragments($this->module()->id(), $this->id(), $property->id(), $property->dataclass());
                return $this->textValue($data);
            default:
                return 'TODO: dataclass '.$property->dataclass();
        }
    }

    private function value(array $data, bool $isArray, string $field)
    {
        if ($isArray) {
            $values = null;
            foreach ($data as $row) {
                $values[] = $row[$field];
            }
            return $values;
        }
        if (isset($data[0][$field])) {
            return $data[0][$field];
        }
        return null;
    }

    private function textValue(array $data)
    {
        // TODO Somewhere we need to prevent text fields being isArray!
        $values = null;
        foreach ($data as $row) {
            $values[][$row['language']] = $row['value'];
        }
        return $values;
    }

    private function keyedValues(array $data, bool $isArray, string $field1, string $field2)
    {
        if ($isArray) {
            $values = null;
            foreach ($data as $row) {
                $values[] = array($field1 => $row[$field1], $field2 = $row[$field2]);
            }
            return $values;
        }
        if (isset($data[0][$field2]) && isset($data[0][$field2])) {
            return array($field1 => $data[0][$field1], $field2 = $data[0][$field2]);
        }
        return null;
    }

    public function relationships()
    {
        return $this->module->relationships($this->schemaId);
    }

    public function related(Module $module = null)
    {
        $related = array();
        if ($module === null) {
            foreach ($this->relationships() as $module) {
                $related = array_merge($related, Item::getAllXmi($this->db, $module, $this));
            }
        } else {
            $related = Item::getAllXmi($this->db, $module, $this);
        }
    }

    public function submodules()
    {
        return $this->module->submodules($this->schemaId);
    }

    public function submodule(string $submodule)
    {
        return $this->module->submodule($this->schemaId, $submodule);
    }

    public static function get(Database $db, Module $module, string $id)
    {
        $item = new Item();
        $config = $db->getItem($module->id(), $id);
        if (!$config) {
            // Item not found
            //throw new Error(9999);
            throw new \Exception();
        }
        $item->init($db, $module, $config);
        return $item;
    }

    public static function getFromIndex(Database $db, Module $module, string $parent, string $index)
    {
        $item = new Item();
        $config = $db->getItemFromIndex($module->id(), $parent, $index);
        if (!$config) {
            // Item not found
            //throw new Error(9999);
            throw new \Exception();
        }
        $item->init($db, $module, $config);
        return $item;
    }

    public static function getAll(Database $db, Module $module, string $parent)
    {
        $items = array();
        $configs = $db->getItems($module->id(), $parent);
        foreach ($configs as $config) {
            $item = new Item();
            $item->init($db, $module, $config);
            $items[] = $item;
        }
        return $items;
    }

    public static function getRecent(Database $db, Module $module, string $parent, int $limit)
    {
        $items = array();
        $configs = $db->getRecentItems($module->id(), $parent, $limit);
        foreach ($configs as $config) {
            $item = new Item();
            $item->init($db, $config, $module);
            $items[] = $item;
        }
        return $items;
    }

    public static function getAllXmi(Database $db, Module $module, Item $item)
    {
        $items = array();
        $configs = $db->getXmiItems($item->module()->id(), $item->id(), $module->id());
        foreach ($configs as $config) {
            $item = new Item();
            $item->init($db, $config, $module);
            $items[] = $item;
        }
        return $items;
    }
}
