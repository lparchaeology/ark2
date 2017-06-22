<?php

/**
 * ARK Model Item Trait
 *
 * Copyright (C) 2017  L - P : Heritage LLP.
 *
 * This file is part of ARK, the Archaeological Recording Kit.
 *
 * ARK is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ARK is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ARK.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     John Layt <j.layt@lparchaeology.com>
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Model;

use ARK\Model\Module;
use ARK\Model\Schema;
use ARK\Model\VersionTrait;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;

trait ItemTrait
{
    use VersionTrait;

    protected $item = null;
    protected $module = null;
    protected $schma = null;
    protected $schema = null;
    protected $type = null;
    protected $status = 'allocated';
    protected $statusTerm = null;
    protected $visibility = 'restricted';
    protected $visibilityTerm = null;
    protected $parentModule = null;
    protected $parentItem = null;
    protected $parent = null;
    protected $idx = null;
    protected $label = null;
    protected $properties = null;
    protected $meta = null;

    protected function construct($schema, $type = null)
    {
        $this->schma = $schema;
        $this->module = $this->schema()->module()->name();
        // TODO Is this really needed?
        if ($this->schema()->useTypeEntities()) {
            $this->type = ($type ?: $this->makeType());
            $this->property('type')->setValue($this->type);
        }
    }

    protected function makeType()
    {
        return strtolower(substr(strrchr(get_class($this), '\\'), 1));
    }

    protected function makeIdentifier($parentId, $sep, $index)
    {
        return ($parentId && $index ? $parentId.$sep.$index : $index);
    }

    public function id()
    {
        return $this->item;
    }

    public function parent()
    {
        if ($this->parentItem && !$this->parent) {
            $module = ORM::find(Module::class, $this->parentModule);
            $this->parent = ORM::find($module->classname(), $this->parentItem);
        }
        return $this->parent;
    }

    public function setParent(Item $parent)
    {
        $this->parent = $parent;
        $this->parentModule = $parent->schema()->module()->name();
        $this->parentItem = $parent->id();
    }

    public function index()
    {
        return $this->idx;
    }

    // TODO Should this be here? Or use reflection?
    public function setItem($id, $index = null, $name = null)
    {
        $this->item = $id;
        $this->idx = ($index !== null ? $index : $id);
        $this->label = ($name !== null ? $name : $id);
        foreach ($this->properties() as $property) {
            $property->updateFragments();
            if ($property->name() == 'id') {
                $property->setValue($this->item);
            }
        }
    }

    public function label()
    {
        return $this->label;
    }

    public function type()
    {
        if ($this->type === null && $this->schema()->useTypeEntities()) {
            $this->type = $this->makeType();
        }
        return $this->type;
    }

    public function setType($type)
    {
        // TODO Danger, Will Robinson!!!
        $this->type = $type;
    }

    public function schema()
    {
        if (!$this->schema) {
            $this->schema = ORM::find(Schema::class, $this->schma);
        }
        return $this->schema;
    }

    public function status()
    {
        if ($this->statusTerm === null) {
            $this->statusTerm = ORM::find(Term::class, ['concept' => 'core.item.status', 'term' => $this->status]);
        }
        return $this->statusTerm;
    }

    public function visibility()
    {
        if ($this->visibilityTerm === null) {
            $this->visibilityTerm = ORM::find(Term::class, ['concept' => 'core.visibility', 'term' => $this->visibility]);
        }
        return $this->visibilityTerm;
    }

    public function hasAttribute($attribute)
    {
        return $this->schema()->hasAttribute($attribute, $this->type());
    }

    public function attributes()
    {
        return $this->schema()->attributes($this->type());
    }

    public function path()
    {
        $resource = $this->schema()->module()->resource();
        if ($this->schema()->generator() == 'hierarchy') {
            return $this->parent()->path().'/'.$resource.'/'.$this->index();
        }
        return '/'.$resource.'/'.$this->index();
    }

    public function properties()
    {
        foreach ($this->attributes() as $attribute) {
            if (!isset($this->properties[$attribute->name()])) {
                $this->properties[$attribute->name()] = new Property($this, $attribute);
            }
        }
        return array_values($this->properties);
    }

    public function propertyArray()
    {
        foreach ($this->attributes() as $attribute) {
            if (!isset($this->properties[$attribute->name()])) {
                $this->properties[$attribute->name()] = new Property($this, $attribute);
            }
        }
        return $this->properties;
    }

    public function property($attribute)
    {
        if ($this->schema()->attribute($attribute, $this->type()) === null) {
            return null;
        }
        if (!isset($this->properties[$attribute])) {
            $this->properties[$attribute] = new Property($this, $this->schema()->attribute($attribute, $this->type()));
        }
        return $this->properties[$attribute];
    }

    private function loadRelated()
    {
        if ($this->related) {
            return;
        }
        foreach ($this->relationships() as $module) {
            $this->related[$module->id()] = $this->em->repository($module->id())->getRelated($this->schema()->module(), $this->id());
        }
    }

    public function related($module = null)
    {
        $this->loadRelated();
        if ($module) {
            if (isset($this->related[$module])) {
                return $this->related[$module];
            }
            return [];
        }
        return $this->related;
    }

    public function relationships()
    {
        if ($this->parent) {
            return $this->parent->schema->xmis($this->parent->schemaId(), $this->schema()->module());
        }
        return [];
    }
}
