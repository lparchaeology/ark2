<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/Module.php
*
* ARK Model Module
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/Module.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

final class Module extends AbstractResource
{
    private $parent = null;
    private $table = null;
    private $modules = null;

    use ObjectTrait;

    protected function __construct(Database $db, $id)
    {
        parent::__construct($db, $id);
    }

    protected function loadConfig($config, Module $parent = null)
    {
        parent::loadConfig($config);

        if (isset($config['subschema_id'])) {
            $this->schemaId = $config['subschema_id'];
        }
        $this->parent = $parent;
        $this->typeCode = $config['module'];
        $this->type = $config['resource'];
        $this->table = $config['tbl'];
        $this->valid = true;
    }

    public function parent()
    {
        return $this->parent;
    }

    private function loadSubodules($schemaId)
    {
        $submodules = Module::getSubmodules($this->db, $this, $schemaId);
        $this->submodules[$schemaId] = ($submodules ? $submodules : array());
    }

    public function submodule($schemaId, $module)
    {
        if (!isset($this->submodules[$schemaId])) {
            $this->loadSubodules($schemaId);
        }
        foreach ($this->submodules[$schemaId] as $mod) {
            if ($mod->id() == $module || $mod->type() == $module) {
                return $mod;
            }
        }
        throw new Error(9999);
    }

    public function submodules($schemaId)
    {
        if (!isset($this->submodules[$schemaId])) {
            $this->loadSubodules($schemaId);
        }
        return $this->submodules[$schemaId];
    }

    public function item($id)
    {
        return Item::get($this->db, $this, $id, $this->table);
    }

    public function itemFromIndex($parent, $index)
    {
        return Item::getFromIndex($this->db, $this, $parent, $index, $this->table);
    }

    public function items($parent = null)
    {
        return Item::getAll($this->db, $this, $parent, $this->table);
    }

    static public function get(Database $db, $moduleId, Module $parent = null)
    {
        $module = new Module($db, $moduleId);
        $config = $db->getModule($moduleId);
        if (!$config) {
            throw new Error(1000);
        }
        $module->loadConfig($config, $parent);
        return $module;
    }

    static public function getSubmodule(Database $db, Module $parent, Item $item, $submodule)
    {
        $module = new Module($db, $submodule);
        $config = $db->getSubmodule($parent->id(), $item->schemaId(), $submodule);
        if (!$config) {
            throw new \Exception();
            //throw new Error(1000);
        }
        $module->loadConfig($config, $parent);
        return $module;
    }

    static public function getSubmodules(Database $db, Module $parent, $schemaId, $enabled = true)
    {
        $modules = array();
        $configs = $db->getSubmodules($parent->id(), $schemaId);
        foreach ($configs as $config) {
            $module = new Module($db, $config['module']);
            $module->loadConfig($config, $parent);
            if ($module->isValid() && ($module->isEnabled() || !$enabled)) {
                $modules[] = $module;
            }
        }
        return $modules;
    }

}
