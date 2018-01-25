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
use ARK\Vocabulary\Concept;
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
    protected $hasSubclassEntities;
    protected $classAttributeName;
    protected $generator;
    protected $sequence;
    protected $classVocabulary;
    protected $visibility = 'private';
    protected $visibilityTerm;
    protected $createPermission;
    protected $readPermission;
    protected $updatePermission;
    protected $deletePermission;
    protected $model;
    protected $superclass;
    protected $classes;
    protected $subclassNames;
    protected $attributes;
    protected $associations;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->associations = new ArrayCollection();
    }

    public function id() : string
    {
        return $this->name;
    }

    public function module() : Module
    {
        return $this->module;
    }

    public function hasSubclassEntities() : bool
    {
        return $this->hasSubclassEntities;
    }

    public function classAttributeName() : ?string
    {
        return $this->classAttributeName;
    }

    public function classVocabulary() : Concept
    {
        return $this->classVocabulary;
    }

    public function subclassNames() : iterable
    {
        $this->init();
        return $this->subclassNames;
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
            $this->visibilityTerm = Vocabulary::find('core.visibility', $this->visibility);
        }
        return $this->visibilityTerm;
    }

    public function createPermission() : ?Permission
    {
        return $this->createPermission;
    }

    public function readPermission() : ?Permission
    {
        return $this->readPermission;
    }

    public function updatePermission() : ?Permission
    {
        return $this->updatePermission;
    }

    public function deletePermission() : ?Permission
    {
        return $this->deletePermission;
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

    public static function find(string $schema) : ?self
    {
        return ORM::find(self::class, $schema);
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_model_schema');

        // Key
        $builder->addMappedStringKey('schma', 'name', 30);

        // Fields
        $builder->addMappedStringField('class_attribute', 'classAttributeName', 30);
        $builder->addMappedField('subclasses', 'hasSubclassEntities', 'boolean');
        $builder->addStringField('generator', 30);
        $builder->addStringField('sequence', 30);
        $builder->addStringField('visibility', 30);
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addRequiredManyToOneField('module', Module::class);
        $builder->addVocabularyField('class_vocabulary', 'classVocabulary');
        $builder->addPermissionField('create_permission', 'createPermission');
        $builder->addPermissionField('read_permission', 'readPermission');
        $builder->addPermissionField('update_permission', 'updatePermission');
        $builder->addPermissionField('delete_permission', 'deletePermission');
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
        return $class;
        if ($this->hasSubclasses()) {
            if ($class === $this->superclass) {
                throw new SubclassRequiredException();
            }
            if (!in_array($class, $this->subclassNames, true)) {
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
        $this->subclassNames = [];
        $this->superclass = $this->module->id();
        $baseClassName = $this->classVocabulary->classname();
        foreach ($this->classVocabulary->terms() as $classTerm) {
            $class = $classTerm->name();
            $this->model[$class]['attributes'] = [];
            $this->model[$class]['associations'] = [];
            if ($class === $this->superclass || $classTerm->classname() === $baseClassName) {
                $this->superclass = $class;
                $this->model[$this->superclass]['allattributes'] = [];
                $this->model[$this->superclass]['allassociations'] = [];
            } else {
                $this->subclassNames[] = $class;
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
