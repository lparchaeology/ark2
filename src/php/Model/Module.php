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
    private $modtypes = null;
    private $submodules = null;
    private $xmis = null;

    use ObjectTrait;

    protected function __construct(Database $db, $id)
    {
        parent::__construct($db, $id);
    }

    protected function loadConfig($config, Item $parent = null)
    {
        parent::loadConfig($config);

        if (isset($config['subschema_id'])) {
            $this->schemaId = $config['subschema_id'];
        }
        if ($parent === null) {
            $this->parent = Item::getRoot($this, 'ARK');
        } else {
            $this->parent = $parent;
        }
        $this->typeCode = $config['module'];
        $this->type = $config['resource'];
        $this->table = $config['tbl'];
        $this->valid = true;
    }

    public function parent()
    {
        return $this->parent;
    }

    private function loadSubmodules(Item $item)
    {
        $submodules = Module::getSubmodules($this->db, $item);
        $this->submodules[$item->schemaId()] = ($submodules ? $submodules : array());
    }

    private function loadXmi($item)
    {
        $xmis = $this->db->getXmiModules($item->module()->parent()->module()->id(), $item->module()->parent()->schemaId());
        $this->xmis = array();
        foreach ($xmis as $xmi) {
            $this->xmis[$item->schemaId()][$xmi['module1']][] = $xmi['module2'];
            $this->xmis[$item->schemaId()][$xmi['module2']][] = $xmi['module1'];
        }
    }

    private function loadModtypes($schemaId)
    {
        $modtypes = $this->db->getModtypes($this->id(), $schemaId);
        $this->modtypes = array();
        foreach ($modtypes as $modtype) {
            $this->xmis[$schemaId][] = $modtype['modtype'];
        }
    }

    public function modtypes($schemaId = null)
    {
        return array();
        if ($schemaId === null) {
            $schemaId = $this->schemaId();
        }
        if (!isset($this->modtypes[$schemaId])) {
            $this->loadModtypes($schemaId);
        }
        return $this->modtypes[$schemaId];
    }

    public function submodule(Item $item, string $submodule)
    {
        $schemaId = $item->schemaId();
        if (!isset($this->submodules[$schemaId])) {
            $this->loadSubmodules($item);
        }
        foreach ($this->submodules[$schemaId] as $mod) {
            if ($mod->id() == $submodule || $mod->type() == $submodule) {
                return $mod;
            }
        }
        throw new \Exception('No submodule found '.$submodule);
        //throw new Error(9999);
    }

    public function submodules(Item $item)
    {
        $schemaId = $item->schemaId();
        if (!isset($this->submodules[$schemaId])) {
            $this->loadSubmodules($item);
        }
        return $this->submodules[$schemaId];
    }

    public function relationships(Item $item)
    {
        if (!isset($this->xmis[$item->schemaId()])) {
            $this->loadXmi($item);
        }
        $modules = array();
        foreach ($this->xmis[$item->schemaId()][$item->module()->id()] as $moduleId) {
            $modules[] = $item->module()->parent()->submodule($moduleId);
        }
        return $modules;
    }

    public function related(Item $item)
    {
        return Item::getAllXmi($this->db, $this, $item, $this->table);
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

    static public function get(Database $db, $moduleId, Item $item = null)
    {
        $module = new Module($db, $moduleId);
        $config = $db->getModule($moduleId);
        if (!$config) {
            //throw new Error(1000);
            throw new \Exception('No module config '.$moduleId);
        }
        $module->loadConfig($config, $item);
        return $module;
    }

    static public function getSubmodule(Database $db, Item $item, $submodule)
    {
        $module = new Module($db, $submodule);
        $config = $db->getSubmodule($item->module()->id(), $item->schemaId(), $submodule);
        if (!$config) {
            throw new \Exception('No submodule config '.$submodule);
            //throw new Error(1000);
        }
        $module->loadConfig($config, $item);
        return $module;
    }

    static public function getSubmodules(Database $db, Item $item, $enabled = true)
    {
        $modules = array();
        $configs = $db->getSubmodules($item->module()->id(), $item->schemaId());
        foreach ($configs as $config) {
            $module = new Module($db, $config['module']);
            $module->loadConfig($config, $item);
            if ($module->isValid() && ($module->isEnabled() || !$enabled)) {
                $modules[] = $module;
            }
        }
        return $modules;
    }
}
