<?php

/**
 * ARK Model Item Trait.
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
 */

namespace ARK\Model;

use ARK\Model\Schema\Schema;
use ARK\ORM\ORM;
use ARK\Vocabulary\Term;

trait ItemTrait
{
    use VersionTrait;

    protected $id = '';
    protected $module;
    protected $schma;
    protected $schema;
    protected $class;
    protected $status = 'allocated';
    protected $statusTerm;
    protected $visibility = 'private';
    protected $visibilityTerm;
    protected $parentModule;
    protected $parentId;
    protected $parent;
    protected $idx;
    protected $label;
    protected $properties;
    protected $meta;

    public function id() : string
    {
        return $this->id;
    }

    public function parent() : ?Item
    {
        if ($this->parentId && $this->parent === null) {
            $this->parent = ORM::findItemByModule($this->parentModule, $this->parentId);
        }
        return $this->parent;
    }

    // TODO Should this be here? Or use reflection? Make function private, use Reflection to call!
    public function setParent(Item $parent) : void
    {
        $this->parent = $parent;
        $this->parentModule = $parent->schema()->module()->id();
        $this->parentId = $parent->id();
    }

    public function index() : string
    {
        return $this->idx;
    }

    // TODO Should this be here? Or use reflection? Make function private, use Reflection to call!
    public function setId(string $id, string $index = null, string $label = null) : void
    {
        $this->id = $id;
        $this->idx = ($index !== null ? $index : $id);
        $this->label = ($label !== null ? $label : $id);
        foreach ($this->properties() as $property) {
            $property->updateFragments();
            if ($property->name() === 'id') {
                $property->setValue($this->id);
            }
        }
    }

    public function label() : string
    {
        return $this->label;
    }

    public function class() : string
    {
        if ($this->class === null) {
            $this->class =
                $this->schema()->hasSubclassEntities()
                    ? $this->makeSubclass()
                    : $this->schema()->module()->superclass();
        }
        return $this->class;
    }

    // TODO Danger, Will Robinson!!! Change to private and use reflection to call
    public function setClass(string $class) : void
    {
        $this->class = $class;
    }

    public function schema() : Schema
    {
        if ($this->schema === null) {
            $this->schema = ORM::find(Schema::class, $this->schma);
        }
        return $this->schema;
    }

    public function status() : Term
    {
        if ($this->statusTerm === null) {
            $this->statusTerm = ORM::find(Term::class, ['concept' => 'core.item.status', 'term' => $this->status]);
        }
        return $this->statusTerm;
    }

    public function visibility() : Term
    {
        if ($this->visibilityTerm === null) {
            $this->visibilityTerm = ORM::find(Term::class, ['concept' => 'core.visibility', 'term' => $this->visibility]);
        }
        return $this->visibilityTerm;
    }

    public function setVisibility($visibility) : void
    {
        if (is_string($visibility)) {
            $visibility = ORM::find(Term::class, ['concept' => 'core.visibility', 'term' => $visibility]);
        }
        if ($visibility instanceof Term && $visibility->name() !== $this->visibility) {
            $this->visibilityTerm = $visibility;
            $this->visibility = $visibility->name();
            $this->setValue('visibility', $visibility);
        }
    }

    public function hasAttribute(string $name) : bool
    {
        return $this->schema()->hasAttribute($name, $this->class());
    }

    public function attributes() : iterable
    {
        return $this->schema()->attributes($this->class());
    }

    public function path() : string
    {
        $resource = $this->schema()->module()->resource();
        if ($this->schema()->generator() === 'hierarchy') {
            return $this->parent()->path().'/'.$resource.'/'.$this->index();
        }
        return '/'.$resource.'/'.$this->index();
    }

    public function properties() : iterable
    {
        foreach ($this->attributes() as $attribute) {
            if (!isset($this->properties[$attribute->name()])) {
                $this->properties[$attribute->name()] = new Property($this, $attribute);
            }
        }
        return array_values($this->properties);
    }

    public function propertyArray() : iterable
    {
        foreach ($this->attributes() as $attribute) {
            if (!isset($this->properties[$attribute->name()])) {
                $this->properties[$attribute->name()] = new Property($this, $attribute);
            }
        }
        return $this->properties;
    }

    public function property(string $attribute) : ?Property
    {
        if ($this->schema()->attribute($attribute, $this->class()) === null) {
            return null;
        }
        if (!isset($this->properties[$attribute])) {
            $this->properties[$attribute] = new Property($this, $this->schema()->attribute($attribute, $this->class()));
        }
        return $this->properties[$attribute];
    }

    public function value(string $attribute)
    {
        if ($property = $this->property($attribute)) {
            return $property->value();
        }
        return null;
    }

    public function setValue(string $attribute, $value) : void
    {
        if ($property = $this->property($attribute)) {
            $property->setValue($value);
            $this->refreshVersion();
        }
    }

    public function related(string $module = null) : iterable
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

    public function relationships() : iterable
    {
        if ($this->parent) {
            return $this->parent->schema->xmis($this->parent->schemaId(), $this->schema()->module());
        }
        return [];
    }

    protected function construct(string $schema, string $class = null) : void
    {
        $this->schma = $schema;
        $this->module = $this->schema()->module()->id();
        // TODO Is this really needed?
        if ($this->schema()->hasSubclassEntities()) {
            $this->class = ($class ?: $this->makeSubclass());
            $this->property('class')->setValue($this->class);
        }
    }

    protected function makeSubclass() : string
    {
        return strtolower(substr(strrchr(get_class($this), '\\'), 1));
    }

    protected function makeIdentifier(string $parentId, string $sep, string $index) : string
    {
        return $parentId && $index ? $parentId.$sep.$index : $index;
    }

    private function loadRelated() : void
    {
        if ($this->related) {
            return;
        }
        foreach ($this->relationships() as $module) {
            $this->related[$module->id()] = $this->em->repository($module->id())->getRelated($this->schema()->module(), $this->id());
        }
    }
}
