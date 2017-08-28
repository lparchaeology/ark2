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

namespace ARK\Model;

use ARK\Model\Exception\SubclassInvalidException;
use ARK\Model\Exception\SubclassRequiredException;
use ARK\Model\Exception\SuperclassInvalidException;
use ARK\Model\Schema\SchemaAssociation;
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Vocabulary\Term;
use ARK\Workflow\Permission;
use Doctrine\Common\Collections\ArrayCollection;

class Schema
{
    use EnabledTrait;
    use KeywordTrait;

    protected $schma = '';
    protected $module;
    protected $generator = '';
    protected $sequence = '';
    protected $classProperty;
    protected $vocabulary;
    protected $visibility = 'private';
    protected $visibilityTerm;
    protected $create;
    protected $read;
    protected $update;
    protected $delete;
    protected $entities = false;
    protected $model;
    protected $subclasses = [];
    protected $attributes;
    protected $associations;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->associations = new ArrayCollection();
    }

    public function name() : string
    {
        return $this->schma;
    }

    public function module() : Module
    {
        return $this->module;
    }

    public function generator() : string
    {
        return $this->generator;
    }

    public function sequence() : string
    {
        return $this->sequence;
    }

    public function useSubclasses() : bool
    {
        return (bool) $this->classProperty;
    }

    public function useSubclassEntities() : bool
    {
        return $this->entities;
    }

    public function classProperty() : string
    {
        return $this->classProperty;
    }

    public function subclassNames() : iterable
    {
        $this->init();
        return $this->subclasses;
    }

    public function visibility() : Term
    {
        if ($this->visibilityTerm === null) {
            $this->visibilityTerm = ORM::find(Term::class, ['concept' => 'core.visibility', 'term' => $this->visibility]);
        }
        return $this->visibilityTerm;
    }

    public function createPermission() : Permission
    {
        return $this->create;
    }

    public function readPermission() : Permission
    {
        return $this->read;
    }

    public function updatePermission() : Permission
    {
        return $this->update;
    }

    public function deletePermission() : Permission
    {
        return $this->delete;
    }

    public function attributes(string $subclass = null, bool $all = true) : iterable
    {
        $this->init();
        $class = $this->checkClass($subclass);
        $attributes = array_values($this->model[$class]['attributes']);
        if ($all && $class !== $this->module->superclass()) {
            return array_merge(array_values($this->model[$this->module->superclass()]['attributes']), $attributes);
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
        if ($all && $subclass !== $this->module->superclass()) {
            return array_merge(array_keys($this->model[$this->module->superclass()]['attributes']), $names);
        }
        return $names;
    }

    public function attribute(string $name) : ?Attribute
    {
        $this->init();
        return $this->model[$this->module->id()]['allattributes'][$name] ?? null;
    }

    public function associations(string $subclass = null, bool $all = true) : iterable
    {
        $this->init();
        $class = $this->checkClass($subclass);
        $associations = array_values($this->model[$class]['associations']);
        if ($all && $class !== $this->module->superclass()) {
            return array_merge(array_values($this->model[$this->module->superclass()]['associations']), $associations);
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
        if ($all && $class !== $this->module->superclass()) {
            return array_merge(array_keys($this->model[$this->module->superclass()]['associations']), $names);
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
        $builder = new ClassMetadataBuilder($metadata, 'ark_schema');

        // Key
        $builder->addStringKey('schma', 30);

        // Fields
        $builder->addManyToOneField('module', Module::class, null, null, false);
        $builder->addStringField('generator', 30);
        $builder->addStringField('sequence', 30);
        $builder->addStringField('classProperty', 30, 'class_property');
        $builder->addStringField('visibility', 30);
        $builder->addField('entities', 'boolean', [], 'entities');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addVocabularyField('vocabulary');
        $builder->addPermissionField('create', 'new');
        $builder->addPermissionField('read', 'view');
        $builder->addPermissionField('update', 'edit');
        $builder->addPermissionField('delete', 'remove');
        $builder->addOneToMany('attributes', SchemaAttribute::class, 'schma');
        $builder->addOneToMany('associations', SchemaAssociation::class, 'schma');
        $builder->setReadOnly();
    }

    protected function checkClass(string $class = null) : string
    {
        $this->init();
        $superclass = $this->module()->superclass();
        if (!$class) {
            $class = $superclass;
        }
        if ($this->useSubclasses()) {
            if ($class === $superclass) {
                throw new SubclassRequiredException();
            }
            if (!in_array($class, $this->subclasses, true)) {
                throw new SubclassInvalidException();
            }
        } else {
            if ($class !== $superclass) {
                throw new SuperclassInvalidException();
            }
        }
        return $class;
    }

    private function init() : void
    {
        if ($this->model === null) {
            $module = $this->module->id();
            $this->model[$module]['attributes'] = [];
            $this->model[$module]['allattributes'] = [];
            $this->model[$module]['associations'] = [];
            $this->model[$module]['allassociations'] = [];
            if ($this->vocabulary) {
                foreach ($this->vocabulary->terms() as $term) {
                    $subclass = $term->name();
                    $this->subclasses[] = $subclass;
                    $this->model[$subclass]['subclass'] = $subclass;
                    $this->model[$subclass]['attributes'] = [];
                    $this->model[$subclass]['associations'] = [];
                }
            }
            foreach ($this->attributes as $attribute) {
                $this->model[$module]['allattributes'][$attribute->name()] = $attribute;
                $this->model[$attribute->class()]['attributes'][$attribute->name()] = $attribute;
            }
            foreach ($this->associations as $association) {
                $this->model[$module]['allassociations'][$association->name()] = $association;
                $this->model[$association->class()]['associations'][$association->name()] = $association;
            }
        }
    }
}
