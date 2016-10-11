<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/AbstractResource.php
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/AbstractResource.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

abstract class AbstractResource
{
    protected $db = null;
    protected $module = null;
    protected $id = null;
    protected $parent = null;
    protected $modtype = '';
    protected $valid = false;

    use SchemaTrait;

    protected function init(Database $db, Module $module, Item $parent = null, array $config)
    {
        $this->db = $db;
        $this->module = $module;
        $this->initSchema($config);
        if ($parent) {
            $this->parent = $parent;
        } elseif (!empty($config['parent'])) {
            // TODO get the actual parent
            $this->parent = $config['parent'];
        }
        if (!empty($config['id'])) {
            $this->id = $config['id'];
        }
        if (!empty($config['modtype'])) {
            $this->modtype = $config['modtype'];
        }
        if (empty($this->schemaId)) {
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

    // HACK temp for use in Forms
    public function moduleId()
    {
        if ($this->module) {
            return $this->module->id();
        }
        return null;
    }

    public function id()
    {
        return $this->id;
    }

    public function parent()
    {
        return $this->parent;
    }

    // HACK temp for use in Forms
    public function parentId()
    {
        if ($this->parent) {
            return $this->parent->id();
        }
        return null;
    }

    abstract public function path();

    public function modtype()
    {
        return $this->modtype;
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

    public function relationships()
    {
        if ($this->parent) {
            return $this->parent->module->xmis($this->parent->schemaId(), $this->module->id());
        }
        return null;
    }

    public function submodules()
    {
        return $this->module->submodules($this->schemaId);
    }

    public function submodule(string $submodule)
    {
        return $this->module->submodule($this->schemaId, $submodule);
    }
}
