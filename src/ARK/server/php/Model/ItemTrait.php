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
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\Item\ItemIdGenerator;
use ARK\ORM\Item\ItemRepository;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

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
            if ($property->name() === 'id') {
                $property->setValue($this->id);
            } else {
                $property->update();
            }
        }
    }

    public function label() : string
    {
        return $this->label;
    }

    public function class() : string
    {
        // If subclass entities, then class is discriminator column and doctrine doesn't populate.
        // Need to determine the class manually in this case.
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
            $this->schema = Schema::find($this->schma);
        }
        return $this->schema;
    }

    public function status() : Term
    {
        if ($this->statusTerm === null) {
            $this->statusTerm = Vocabulary::findTerm('core.item.status', $this->status);
        }
        return $this->statusTerm;
    }

    public function visibility() : Term
    {
        if ($this->visibilityTerm === null) {
            $this->visibilityTerm = Vocabulary::findTerm('core.visibility', $this->visibility);
        }
        return $this->visibilityTerm;
    }

    public function setVisibility($visibility) : void
    {
        if (is_string($visibility)) {
            $visibility = Vocabulary::findTerm('core.visibility', $visibility);
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

    public function attribute(string $name) : ?Attribute
    {
        return $this->schema()->attribute($name);
    }

    public function path() : string
    {
        $resource = $this->schema()->module()->resource();
        if ($this->schema()->generator() === 'hierarchy') {
            return $this->parent()->path().'/'.$resource.'/'.$this->index();
        }
        return '/'.$resource.'/'.$this->index();
    }

    // TODO This should be protected, need to change table rendering to do so
    public function property(string $attribute) : ?Property
    {
        if (!$this->hasAttribute($attribute)) {
            return null;
        }
        if (!isset($this->properties[$attribute])) {
            $this->properties[$attribute] = new Property($this, $this->schema()->attribute($attribute, $this->class()));
        }
        return $this->properties[$attribute];
    }

    public function value(string $attribute)
    {
        $property = $this->property($attribute);
        return $property instanceof Property ? $property->value() : null;
    }

    public function setValue(string $attribute, $value) : void
    {
        $property = $this->property($attribute);
        if ($property instanceof Property) {
            $property->setValue($value);
            $this->refreshVersion();
        }
    }

    public function serialize(string $attribute)
    {
        $property = $this->property($attribute);
        return $property instanceof Property ? $property->serialize() : null;
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

    public function delete() : void
    {
        foreach ($this->properties() as $property) {
            $property->delete();
        }
        ORM::remove($this);
    }

    public static function find(string $id) : ?self
    {
        return ORM::find(get_called_class(), $id);
    }

    public static function findAll() : Collection
    {
        return ORM::findAll(get_called_class());
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $classname = get_called_class();
        $entity = Service::database()->getEntityForClassName($classname);
        if (!$entity || ($entity['subclasses'] && !$entity['superclass'])) {
            dump($classname);
            dump($entity);
            return;
        }
        $classnames[] = $entity['classname'];

        $builder = new ClassMetadataBuilder($metadata, $entity['tbl']);
        $builder->setCustomRepositoryClass(ItemRepository::class);

        // Key
        $builder->addStringKey('id', 30);
        $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_CUSTOM);
        // TODO Get from $entity?
        $metadata->setCustomGeneratorDefinition(['class' => ItemIdGenerator::class]);

        // Fields
        $builder->addStringField('module', 30);
        $builder->addStringField('schma', 30);
        if ($entity['subclasses']) {
            $subclasses = Service::database()->getSubclassEntities($entity['schma']);
            $builder->setSingleTableInheritance()->setDiscriminatorColumn('class', 'string', 30);
            $metadata->addDiscriminatorMapClass('', $entity['classname']);
            foreach ($subclasses as $subclass) {
                $metadata->addDiscriminatorMapClass($subclass['class'], $subclass['classname']);
                $classnames[] = $subclass['classname'];
            }
        } else {
            $builder->addStringField('class', 30);
        }
        $builder->addStringField('status', 30, false, ['default' => 'allocated']);
        $builder->addStringField('visibility', 30, false, ['default' => 'restricted']);
        $builder->addMappedStringField('parent_module', 'parentModule', 30, true);
        $builder->addMappedStringField('parent_id', 'parentId', 30, true);
        $builder->addStringField('idx', 30);
        $builder->addStringField('label', 30);
        VersionTrait::buildVersionMetadata($builder);
        $metadata->setItemEntity(true);
        $metadata->setClassNames($classnames);
    }

    public static function loadClassNames() : iterable
    {
        // Table
        $classname = get_called_class();
        $entity = Service::database()->getEntityForClassName($classname);
        if (!$entity || ($entity['subclasses'] && !$entity['superclass'])) {
            return [];
        }
        $classnames[] = $entity['classname'];
        if ($entity['subclasses']) {
            $subclasses = Service::database()->getSubclassEntities($entity['schma']);
            foreach ($subclasses as $subclass) {
                $classnames[] = $subclass['classname'];
            }
        }
        return $classnames;
    }

    public function loadMetadataForGenerator(ClassMetadata $metadata) : void
    {
        $classname = get_called_class();
        $entity = Service::database()->getEntityForClassName($classname);
        $builder = new ClassMetadataBuilder($metadata, $entity['tbl']);
    }

    protected function properties() : iterable
    {
        foreach ($this->attributes() as $attribute) {
            if (!isset($this->properties[$attribute->name()])) {
                $this->properties[$attribute->name()] = new Property($this, $attribute);
            }
        }
        return array_values($this->properties);
    }

    protected function construct(string $schema, string $class = null) : void
    {
        $this->schma = $schema;
        $this->module = $this->schema()->module()->id();
        if ($this->schema()->hasSubclassEntities()) {
            $this->class = ($class ?: $this->makeSubclass());
        } else {
            $this->class = $this->schema()->classVocabulary()->defaultTerm()->name();
        }
        if ($this->class === null) {
            $this->class = $this->module;
        }
        $this->setValue($this->schema()->classAttributeName(), $this->class);
        $this->setValue('visibility', $this->schema()->visibility());
    }

    protected function makeSubclass() : string
    {
        return mb_strtolower(mb_substr(mb_strrchr(get_class($this), '\\'), 1));
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
