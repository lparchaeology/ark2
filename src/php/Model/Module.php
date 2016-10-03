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

use ARK\AbstractObject;
use ARK\Database\Database;

final class Module extends AbstractObject
{
    private $parent = null;
    private $modtypes = null;
    private $submodules = null;
    private $xmis = null;

    use ObjectTrait;

    protected function __construct(Database $db, string $id)
    {
        parent::__construct($db, $id);
    }

    protected function init(array $config, Module $parent = null)
    {
        parent::init($config);
        $this->initSchema($config);

        $schemas = $this->db->getModuleSchemas($this->id);
        foreach ($schemas as $schema) {
            $this->schemas[$schema['schema_id']] = array();
        }

        $this->parent = $parent;
        $this->typeCode = $config['module'];
        $this->type = $config['resource'];
        $this->valid = true;
    }

    public function parent()
    {
        return $this->parent;
    }

    public function schemas()
    {
        return array_keys($this->schemas);
    }

    private function loadSubmodules(string $schemaId)
    {
        $submodules = Module::getSubmodules($this->db, $this, $schemaId);
        $this->submodules[$schemaId] = ($submodules ? $submodules : array());
    }

    private function loadXmiModules(string $schemaId)
    {
        $xmis = $this->db->getXmiModules($this->id(), $schemaId);
        $this->xmis = array();
        foreach ($xmis as $xmi) {
            $this->xmis[$schemaId][$xmi['module1']][] = $xmi['module2'];
            $this->xmis[$schemaId][$xmi['module2']][] = $xmi['module1'];
        }
    }

    private function loadModtypes(string $schemaId)
    {
        $modtypes = $this->db->getModtypes($this->id(), $schemaId);
        $this->modtypes[$schemaId] = array();
        foreach ($modtypes as $modtype) {
            $this->modtypes[$schemaId][] = $modtype['modtype'];
        }
    }

    public function modtypes($schemaId = null)
    {
        if ($schemaId === null) {
            $schemaId = $this->schemaId();
        }
        if (!isset($this->modtypes[$schemaId])) {
            $this->loadModtypes($schemaId);
        }
        return $this->modtypes[$schemaId];
    }

    public function submodule(string $schemaId, string $submodule)
    {
        foreach ($this->submodules($schemaId) as $mod) {
            if ($mod->id() == $submodule || $mod->type() == $submodule) {
                return $mod;
            }
        }
        throw new \Exception('No submodule found '.$submodule);
        //throw new Error(9999);
    }

    public function submodules(string $schemaId)
    {
        if (!isset($this->submodules[$schemaId])) {
            $this->loadSubmodules($schemaId);
        }
        return $this->submodules[$schemaId];
    }

    public function xmis(string $schemaId, string $submodule)
    {
        if (!isset($this->xmis[$schemaId])) {
            $this->loadXmiModules($schemaId);
        }
        $xmis = array();
        foreach ($this->xmis[$schemaId][$submodule] as $module) {
            $xmis[] = $this->submodule($schemaId, $module);
        }
        return $xmis;
    }

    public function item(string $id, Item $parent = null)
    {
        return Item::get($this->db, $this, $parent, $id);
    }

    public function itemFromIndex(Item $parent, string $index)
    {
        return Item::getFromIndex($this->db, $this, $parent, $index);
    }

    public function items(Item $parent = null)
    {
        return Item::getAll($this->db, $this, $parent);
    }

    public function recentItems(Item $parent = null, int $recent)
    {
        return Item::getRecent($this->db, $this, $parent, 5);
    }

    public static function getRoot(Database $db, string $moduleId)
    {
        $module = new Module($db, $moduleId);
        $config = $db->getModule($moduleId);
        if (!$config) {
            //throw new Error(1000);
            throw new \Exception('No module config '.$moduleId);
        }
        $config['schema_id'] = $moduleId;
        $module->init($config);
        return $module;
    }

    public static function getSubmodule(Database $db, Module $parent, string $schemaId, string $submodule)
    {
        $module = new Module($db, $submodule);
        $config = $db->getSubmodule($parent->id(), $schemaId, $submodule);
        if (!$config) {
            throw new \Exception('No submodule config '.$submodule);
            //throw new Error(1000);
        }
        $module->init($config, $parent);
        return $module;
    }

    public static function getSubmodules(Database $db, Module $parent, string $schemaId, bool $enabled = true)
    {
        $modules = array();
        $configs = $db->getSubmodules($parent->id(), $schemaId);
        foreach ($configs as $config) {
            $module = new Module($db, $config['module']);
            $module->init($config, $parent);
            if ($module->isValid() && ($module->isEnabled() || !$enabled)) {
                $modules[] = $module;
            }
        }
        return $modules;
    }
}
