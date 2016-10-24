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

class Item extends AbstractResource
{
    private $index = null;
    private $name = null;

    protected function init(Database $db, Module $module, Item $parent = null, array $config)
    {
        parent::init($db, $module, $parent, $config);
        $this->index = $config['idx'];
        $this->name = $config['name'];
    }

    public function index()
    {
        return $this->index;
    }

    public function name()
    {
        return $this->name;
    }

    public function path()
    {
        if ($this->parent) {
            return $this->parent->path().'/'.$this->index();
        }
        return '/'.$this->index();
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
        if ($property->id() == 'item') {
            return $this->name;
        }
        if ($property->id() == 'modtype') {
            return $this->modtype;
        }
        if ($property->dataclass()) {
            $data = $this->db->getPropertyFragments(
                $this->module()->id(),
                $this->id(),
                $property->id(),
                $property->dataclass()
            );
            return $this->propertyValue($property, $data);
        }
        return null;
    }

    private function propertyValue(Property $property, array $data)
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
                return $this->value($data, $property->multipleValues(), 'value');
            case 'file':
                return $this->value($data, $property->multipleValues(), 'filename');
            case 'action':
                return $this->keyedValues($data, $property->multipleValues(), 'actor_module', 'actor_item');
            case 'span':
                return $this->keyedValues($data, $property->multipleValues(), 'beg', 'end');
            case 'text':
                return $this->textValue($data);
            default:
                return 'TODO: dataclass '.$property->dataclass();
        }
    }

    private function value(array $data, bool $multipleValues, string $field)
    {
        if ($multipleValues) {
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
        // TODO Somewhere we need to prevent text fields being multipleValues!
        $values = null;
        foreach ($data as $row) {
            $values[][$row['language']] = $row['value'];
        }
        return $values;
    }

    private function keyedValues(array $data, bool $multipleValues, string $field1, string $field2)
    {
        if ($multipleValues) {
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
        return $related;
    }

    public static function get(Database $db, Module $module, Item $parent = null, string $id)
    {
        $item = new Item();
        $config = $db->getItem($module->id(), $id);
        if (!$config) {
            // Item not found
            //throw new Error(9999);
            throw new \Exception();
        }
        // TODO check parent matches!
        $item->init($db, $module, $parent, $config);
        return $item;
    }

    public static function getFromIndex(Database $db, Module $module, Item $parent = null, string $index)
    {
        $item = new Item();
        $config = $db->getItemFromIndex($module->id(), $parent->id(), $index);
        if (!$config) {
            // Item not found
            //throw new Error(9999);
            throw new \Exception();
        }
        // TODO check parent matches!
        $item->init($db, $module, $parent, $config);
        return $item;
    }

    public static function getRoot(Database $db, string $root)
    {
        return Item::get($db, Module::getRoot($db, $root), null, $root);
    }

    public static function getAll(Database $db, Module $module, Item $parent = null)
    {
        $items = array();
        $parentId = $parent ? $parent->id() : null;
        $configs = $db->getItems($module->id(), $parentId);
        // TODO check parent matches!
        foreach ($configs as $config) {
            $item = new Item();
            $item->init($db, $module, $parent, $config);
            $items[] = $item;
        }
        if ($items) {
            return $items;
        }
        return array();
    }

    public static function getRecent(Database $db, Module $module, Item $parent = null, int $limit)
    {
        $items = array();
        $configs = $db->getRecentItems($module->id(), $parent->id(), $limit);
        // TODO check parent matches!
        foreach ($configs as $config) {
            $item = new Item();
            $item->init($db, $module, $parent, $config);
            $items[] = $item;
        }
        return $items;
    }

    public static function getAllXmi(Database $db, Module $module, Item $item)
    {
        $items = array();
        $configs = $db->getXmiItems($item->module()->id(), $item->id(), $module->id());
        // TODO check parent matches!
        foreach ($configs as $config) {
            $item = new Item();
            $item->init($db, $module, $item->parent(), $config);
            $items[] = $item;
        }
        return $items;
    }
}
