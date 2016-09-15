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

    protected function loadConfig($config, Module $module)
    {
        $this->module = $module;
        $this->id = $config['item'];
        if (isset($config['parent'])) {
            $this->parent = $config['parent'];
        }
        if (isset($config['idx'])) {
            $this->index = $config['idx'];
        } else {
            $last = strrpos($this->id, '_');
            if ($last === false) {
                $this->index = $this->id;
            } else {
                $this->index = substr($this->id, $last + 1);
            }
        }
        if (isset($config['modtype'])) {
            $this->modtype = $config['modtype'];
        }
        if (isset($config['schema_id'])) {
            $this->schemaId = $config['schema_id'];
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
        if ($this->schemaId) {
            return $this->schemaId;
        }
        if ($this->module) {
            return $this->module->schemaId();
        }
        return null;
    }

    public function schema($reference = Schema::ReferenceSchema)
    {
        return $this->module->schema($this->schemaId(), $reference);
    }

    public function properties()
    {
        return $this->module->properties($this->schemaId(), $this->modtype());
    }

    public function required()
    {
        return $this->module->required($this->schemaId(), $this->modtype());
    }

    public function definitions()
    {
        return $this->module->definitions($this->schemaId());
    }

    public function attributes($lang)
    {
        $attributes = array();
        foreach ($this->properties() as $property) {
            $attributes[$property->id()] = $property->value($this, $lang);
        }
        return $attributes;
    }

    public function relationships()
    {
        return $this->module->relationships($this);
    }

    public function submodules()
    {
        return $this->module->submodules($this);
    }

    public function submodule($submodule)
    {
        return $this->module->submodule($this, $submodule);
    }

    static public function get(Database $db, Module $module, $id, $table = null)
    {
        $item = new Item();
        $config = $db->getItem($module->id(), $id, $table);
        if (!$config) {
            // Item not found
            //throw new Error(9999);
            throw new \Exception();
        }
        $item->loadConfig($config, $module);
        return $item;
    }

    static public function getRoot(Module $module, $id)
    {
        $item = new Item();
        $config['item'] = $id;
        //$config['schema_id'] = $module->schemaId();
        $item->loadConfig($config, $module);
        return $item;
    }

    static public function getFromIndex(Database $db, Module $module, $parent, $index, $table = null)
    {
        $item = new Item();
        $config = $db->getItemFromIndex($module->id(), $parent, $index, $table);
        if (!$config) {
            // Item not found
            //throw new Error(9999);
            throw new \Exception();
        }
        $item->loadConfig($config, $module);
        return $item;
    }

    static public function getAll(Database $db, Module $module, $parent, $table = null)
    {
        $items = array();
        $configs = $db->getItems($module->id(), $parent, $table);
        foreach ($configs as $config) {
            $item = new Item();
            $item->loadConfig($config, $module);
            $items[] = $item;
        }
        return $items;
    }

    static public function getRecent(Database $db, Module $module, $parent, $limit, $table = null)
    {
        $items = array();
        $configs = $db->getRecentItems($module->id(), $parent, $limit, $table);
        foreach ($configs as $config) {
            $item = new Item();
            $item->loadConfig($config, $module);
            $items[] = $item;
        }
        return $items;
    }

    static public function getAllXmi(Database $db, Module $module, Item $item, $table = null)
    {
        $items = array();
        $configs = $db->getXmiItems($item->module()->id(), $item->id(), $module->id(), $table);
        foreach ($configs as $config) {
            $item = new Item();
            $item->loadConfig($config, $module);
            $items[] = $item;
        }
        return $items;
    }
}
