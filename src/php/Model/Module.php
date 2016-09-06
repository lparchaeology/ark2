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

    private function loadSubodules()
    {
        $modules = Module::getAll($this->db, $this->id());
        $this->submodules = ($modules ? $modules : array());
    }

    public function submodule($module)
    {
        if ($this->submodules === null) {
            $this->loadSubodules();
        }
        foreach ($this->submodules as $mod) {
            if ($mod->id() == $module || $mod->type() == $module) {
                return $mod;
            }
        }
        throw new Error(9999);
    }

    public function submodules()
    {
        if ($this->submodules === null) {
            $this->loadSubodules();
        }
        return $this->submodules;
    }

    public function item($item)
    {
        return Item::get($this->db, $this->id, $item, $this->table);
    }

    public function items()
    {
        if ($this->parent && $this->parent->id() != 'ark') {
            $parent = $this->parent->id();
        } else {
            $parent = null;
        }
        return Item::getAll($this->db, $this->id, $parent, $this->table);
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

    static public function getSubmodules(Database $db, Module $parent, Item $item, $enabled = true)
    {
        $modules = array();
        $configs = $db->getSubmodules($parent->id(), $item->schemaId());
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
