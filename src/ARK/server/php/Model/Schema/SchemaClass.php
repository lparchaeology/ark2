<?php

/**
 * ARK Model Schema Association.
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

use ARK\Model\EnabledTrait;
use ARK\Model\Model;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\Common\Collections\Collection;

class SchemaClass
{
    use EnabledTrait;

    protected $schema;
    protected $name;
    protected $vocabulary;
    protected $namespace;
    protected $entity;
    protected $classname;
    protected $superclass;
    protected $instantiable;
    protected $attributes;
    protected $associations;
    protected $subschemas;

    public function schema() : Schema
    {
        return $this->schema;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function namespace() : string
    {
        return $this->namespace;
    }

    public function entity() : string
    {
        return $this->entity;
    }

    public function classname() : string
    {
        return $this->classname;
    }

    public function isSuperclass() : string
    {
        return $this->superclass;
    }

    public function isInstantiable() : string
    {
        return $this->instantiable;
    }

    public function attributes(bool $all = true) : Collection
    {
    }

    public function attribute(string $name) : ?Attribute
    {
    }

    public function associations(string $model, bool $all = true) : Collection
    {
    }

    public function association(string $model, string $name) : ?SchemaAssociation
    {
    }

    public function subschemas(string $model, bool $all = true) : Collection
    {
    }

    public function subschema(string $model, string $name) : ?Schema
    {
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_model_class');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('schema', Schema::class, 'schma');
        $builder->addMappedStringKey('class', 'name', 30);

        // Fields
        $builder->addRequiredVocabularyField('vocabulary');
        $builder->addStringField('namespace', 50);
        $builder->addStringField('entity', 30);
        $builder->addStringField('classname', 100);
        $builder->addField('superclass', 'boolean');
        $builder->addField('instantiable', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);

        // Associations
        $builder->addCompositeOneToManyField(
            'attributes',
            SchemaAttribute::class,
            'schma',
            [
                ['column' => 'schma', 'nullable' => false],
                ['column' => 'class', 'nullable' => false],
            ]
        );
        $builder->addCompositeOneToManyField(
            'associations',
            SchemaAssociation::class,
            'schma',
            [
                ['column' => 'schma', 'nullable' => false],
                ['column' => 'class', 'nullable' => false],
            ]
        );
        /*
        $builder->addCompositeOneToManyField(
            'subschemas',
            ModelSubschema::class,
            'schma',
            [
                ['column' => 'schma', 'nullable' => false],
                ['column' => 'class', 'nullable' => false],
            ]
        );
        */
    }
}
