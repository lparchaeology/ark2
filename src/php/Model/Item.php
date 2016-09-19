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
    private $module = null;
    private $id = null;
    private $parent = null;
    private $index = null;
    private $modtype = '';
    private $schemaId = null;
    protected $valid = false;

    protected function init(Module $module, array $config)
    {
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
            $attributes[$property->id()] = $property->value($this);
        }
        return $attributes;
    }

    public function relationships()
    {
        return $this->module->relationships($this->schemaId);
    }

    public function submodules()
    {
        return $this->module->submodules($this->schemaId);
    }

    public function submodule($submodule)
    {
        return $this->module->submodule($this, $submodule);
    }

    public static function get(Database $db, Module $module, string $id)
    {
        $item = new Item();
        $config = $db->getItem($module->id(), $id, $module->table());
        if (!$config) {
            // Item not found
            //throw new Error(9999);
            throw new \Exception();
        }
        $item->init($module, $config);
        return $item;
    }

    public static function getFromIndex(Database $db, Module $module, string $parent, string $index)
    {
        $item = new Item();
        $config = $db->getItemFromIndex($module->id(), $parent, $index, $module->table());
        if (!$config) {
            // Item not found
            //throw new Error(9999);
            throw new \Exception();
        }
        $item->init($module, $config);
        return $item;
    }

    public static function getAll(Database $db, Module $module, string $parent)
    {
        $items = array();
        $configs = $db->getItems($module->id(), $parent, $module->table());
        foreach ($configs as $config) {
            $item = new Item();
            $item->init($module, $config);
            $items[] = $item;
        }
        return $items;
    }

    public static function getRecent(Database $db, Module $module, string $parent, int $limit)
    {
        $items = array();
        $configs = $db->getRecentItems($module->id(), $parent, $limit, $module->table());
        foreach ($configs as $config) {
            $item = new Item();
            $item->init($config, $module);
            $items[] = $item;
        }
        return $items;
    }

    public static function getAllXmi(Database $db, Module $module, Item $item)
    {
        $items = array();
        $configs = $db->getXmiItems($item->module()->id(), $item->id(), $module->id(), $module->table());
        foreach ($configs as $config) {
            $item = new Item();
            $item->init($config, $module);
            $items[] = $item;
        }
        return $items;
    }
}
