<?php

/**
 * ARK Model Schema.
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

namespace ARK\Model\Schema;

use ARK\Model\Attribute;
use ARK\Model\EnabledTrait;
use ARK\Model\Exception\SubclassInvalidException;
use ARK\Model\Exception\SubclassRequiredException;
use ARK\Model\Exception\SuperclassInvalidException;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Workflow\Permission;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Schema
{
    use EnabledTrait;
    use KeywordTrait;

    protected $name;
    protected $module;
    protected $hasSubclasses;
    protected $hasEntities;
    protected $attribute;
    protected $entities;
    protected $generator;
    protected $sequence;
    protected $vocabulary;
    protected $visibility = 'private';
    protected $visibilityTerm;
    protected $create;
    protected $read;
    protected $update;
    protected $delete;
    protected $model;
    protected $superclass;
    protected $subclasses;
    protected $attributes;
    protected $associations;

    public function __construct()
    {
        $this->subclasses = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->associations = new ArrayCollection();
    }

    public function name() : string
    {
        return $this->name;
    }

    public function module() : Module
    {
        return $this->module;
    }

    public function superclass() : Module
    {
        return $this->superclass;
    }

    public function hasSubclasses() : bool
    {
        return $this->hasSubclasses;
    }

    public function hasSubclassEntities() : bool
    {
        return $this->hasEntities;
    }

    public function classAttributeName() : string
    {
        return $this->attribute;
    }

    public function classVocabulary() : string
    {
        return $this->vocabulary;
    }

    public function subclassNames() : iterable
    {
        $this->init();
        return $this->subclasses;
    }

    public function generator() : string
    {
        return $this->generator;
    }

    public function sequence() : string
    {
        return $this->sequence;
    }

    public function visibility() : Term
    {
        if ($this->visibilityTerm === null) {
            $this->visibilityTerm = ORM::find(Term::class, ['concept' => 'core.visibility', 'term' => $this->visibility]);
        }
        return $this->visibilityTerm;
    }

    public function createPermission() : ?Permission
    {
        return $this->create;
    }

    public function readPermission() : ?Permission
    {
        return $this->read;
    }

    public function updatePermission() : ?Permission
    {
        return $this->update;
    }

    public function deletePermission() : ?Permission
    {
        return $this->delete;
    }

    public function children() : Collection
    {
        return $this->children;
    }

    public function attributes(string $subclass = null, bool $all = true) : iterable
    {
        $this->init();
        $class = $this->checkClass($subclass);
        $attributes = array_values($this->model[$class]['attributes']);
        if ($all && $class !== $this->superclass) {
            return array_merge(array_values($this->model[$this->superclass]['attributes']), $attributes);
        }
        return $attributes;
    }

    public function hasAttribute(string $attribute, string $subclass = null) : bool
    {
        return in_array($attribute, $this->attributeNames($subclass), true);
    }

    public function attributeNames(string $subclass = null, bool $all = true) : iterable
    {
        $this->init();
        $class = $this->checkClass($subclass);
        $names = array_keys($this->model[$class]['attributes']);
        if ($all && $subclass !== $this->superclass) {
            return array_merge(array_keys($this->model[$this->superclass]['attributes']), $names);
        }
        return $names;
    }

    public function attribute(string $name) : ?Attribute
    {
        $this->init();
        return $this->model[$this->superclass]['allattributes'][$name] ?? null;
    }

    public function associations(string $subclass = null, bool $all = true) : iterable
    {
        $this->init();
        $class = $this->checkClass($subclass);
        $associations = array_values($this->model[$class]['associations']);
        if ($all && $class !== $this->superclass) {
            return array_merge(array_values($this->model[$this->superclass]['associations']), $associations);
        }
        return $associations;
    }

    public function hasAssociation(string $name, string $subclass = null) : bool
    {
        return in_array($name, $this->associationNames($subclass), true);
    }

    public function associationNames(string $subclass = null, bool $all = true) : iterable
    {
        $this->init();
        $class = $this->checkClass($subclass);
        $names = array_keys($this->model[$class]['associations']);
        if ($all && $class !== $this->superclass) {
            return array_merge(array_keys($this->model[$this->superclass]['associations']), $names);
        }
        return $names;
    }

    public function association(string $name) : ?SchemaAssociation
    {
        return $this->model[$subclass]['allassociations'][$name] ?? null
        ;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_model_schema');

        // Key
        $builder->addMappedStringKey('schma', 'name', 30);

        // Fields
        $builder->addMappedField('subclasses', 'hasSubclasses', 'boolean');
        $builder->addMappedField('entities', 'hasEntities', 'boolean');
        $builder->addStringField('attribute', 30);
        $builder->addStringField('generator', 30);
        $builder->addStringField('sequence', 30);
        $builder->addStringField('visibility', 30);
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addRequiredManyToOneField('module', Module::class);
        $builder->addVocabularyField('vocabulary');
        $builder->addPermissionField('new', 'create');
        $builder->addPermissionField('view', 'read');
        $builder->addPermissionField('edit', 'update');
        $builder->addPermissionField('remove', 'delete');
        $builder->addOneToManyField('classes', SchemaClass::class, 'schma');
        $builder->addOneToManyField('attributes', SchemaAttribute::class, 'schma');
        $builder->addOneToManyField('associations', SchemaAssociation::class, 'schma');
        $builder->setReadOnly();
    }

    protected function checkClass(string $class = null) : string
    {
        $this->init();
        if (!$class) {
            $class = $this->superclass;
        }
        if ($this->hasSubclasses()) {
            if ($class === $this->superclass) {
                throw new SubclassRequiredException();
            }
            if (!in_array($class, $this->subclasses, true)) {
                throw new SubclassInvalidException();
            }
        } else {
            if ($class !== $this->superclass) {
                throw new SuperclassInvalidException();
            }
        }
        return $class;
    }

    private function init() : void
    {
        if ($this->model !== null) {
            return;
        }
        $this->model = [];
        $this->subclasses = [];
        $entities = Service::database()->getEntitiesForSchema($this->schma);
        foreach ($entities as $entity) {
            $class = $entity['class'];
            $this->model[$class]['attributes'] = [];
            $this->model[$class]['associations'] = [];
            if ($entity['superclass']) {
                $this->superclass = $class;
                $this->model[$this->superclass]['allattributes'] = [];
                $this->model[$this->superclass]['allassociations'] = [];
            } else {
                $this->subclasses[] = $class;
            }
        }
        foreach ($this->attributes as $attribute) {
            $this->model[$this->superclass]['allattributes'][$attribute->name()] = $attribute;
            $this->model[$attribute->class()]['attributes'][$attribute->name()] = $attribute;
        }
        foreach ($this->associations as $association) {
            $this->model[$this->superclass]['allassociations'][$association->name()] = $association;
            $this->model[$association->class()]['associations'][$association->name()] = $association;
        }
    }
}
