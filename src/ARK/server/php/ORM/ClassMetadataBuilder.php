<?php

/**
 * ARK Class Metadata Builder.
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

namespace ARK\ORM;

use ARK\Vocabulary\Vocabulary;
use ARK\Workflow\Permission;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder as DoctrineClassMetadataBuilder;
use Doctrine\ORM\Mapping\Builder\FieldBuilder;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class ClassMetadataBuilder extends DoctrineClassMetadataBuilder
{
    public function __construct(
        ClassMetadataInfo $metadata,
        string $table = '',
        int $generator = ClassMetadataInfo::GENERATOR_TYPE_NONE
    ) {
        parent::__construct($metadata);
        $this->setIdGeneratorType($generator);
        if ($table) {
            $this->setTable($table);
        }
    }

    public function setIdGeneratorType(int $type) : void
    {
        $this->getClassMetadata()->setIdGeneratorType($type);
    }

    public function addManyToMany(
        string $name,
        string $targetEntity,
        string $joinTable,
        string $joinColumn = null,
        string $inverseColumn = null
    ) : ClassMetadataBuilder {
        $builder = $this->createManyToMany($name, $targetEntity);
        $builder->setJoinTable($joinTable);
        $builder->addJoinColumn($joinColumn, $joinColumn);
        $builder->addInverseJoinColumn($inverseColumn, $inverseColumn);
        return $builder->build();
    }

    public function addOneToMany(
        string $name,
        string $targetEntity,
        string $mappedBy,
        string $column = null,
        string $reference = null,
        bool $nullable = true,
        iterable $orderBy = []
    ) : ClassMetadataBuilder {
        $builder = $this->createOneToMany($name, $targetEntity);
        $builder->mappedBy($mappedBy);
        if ($reference) {
            $builder->addJoinColumn($column, $reference, $nullable);
        }
        if ($orderBy) {
            $builder->setOrderBy($orderBy);
        }
        return $builder->build();
    }

    public function addCompositeOneToMany(
        string $name,
        string $targetEntity,
        string $mappedBy,
        iterable $joins
    ) : ClassMetadataBuilder {
        $builder = $this->createOneToMany($name, $targetEntity);
        $builder->mappedBy($mappedBy);
        foreach ($joins as $join) {
            $builder->addJoinColumn(
                $join['column'],
                $join['reference'] ?? $join['column'],
                $join['nullable'] ?? true
            );
        }
        return $builder->build();
    }

    public function addOneToManyCascade(
        string $name,
        string $targetEntity,
        string $mappedBy,
        bool $persist = true,
        bool $delete = false
    ) : ClassMetadataBuilder {
        $builder = $this->createOneToMany($name, $targetEntity);
        $builder->mappedBy($mappedBy);
        if ($persist) {
            $builder->cascadePersist();
        }
        if ($delete) {
            $builder->cascadeDelete();
        }
        return $builder->build();
    }

    public function addManyToOneKey(
        string $name,
        string $class,
        string $column = null,
        string $reference = null,
        string $inverse = null
    ) : ClassMetadataBuilder {
        if ($column === null) {
            $column = $name;
        }
        if ($reference === null) {
            $reference = $column;
        }
        $builder = $this->createManyToOne($name, $class)->makePrimaryKey()->addJoinColumn($column, $reference, false);
        if ($inverse) {
            $builder->inversedBy($inverse);
        }
        return $builder->build();
    }

    public function addCompositeManyToOneKey(
        string $name,
        string $class,
        string $joins,
        string $inverse = null
    ) : ClassMetadataBuilder {
        $builder = $this->createManyToOne($name, $class)->makePrimaryKey();
        foreach ($joins as $join) {
            $builder->addJoinColumn(
                $join['column'],
                $join['reference'] ?? $join['column'],
                $join['nullable'] ?? true
            );
        }
        if ($inverse) {
            $builder->inversedBy($inverse);
        }
        return $builder->build();
    }

    public function addVocabularyField(
        string $name,
        string $column = null,
        bool $nullable = true
    ) : ClassMetadataBuilder {
        return $this->addManyToOneField($name, Vocabulary::class, $column, 'concept', $nullable);
    }

    public function addPermissionField(
        string $name,
        string $column = null,
        bool $nullable = true
    ) : ClassMetadataBuilder {
        return $this->addManyToOneField($name, Permission::class, $column, 'permission', $nullable);
    }

    public function addCompositeManyToOneField(
        string $name,
        string $class,
        iterable $joins,
        string $inverse = null
    ) : ClassMetadataBuilder {
        $builder = $this->createManyToOne($name, $class);
        foreach ($joins as $join) {
            $builder->addJoinColumn(
                $join['column'],
                $join['reference'] ?? $join['column'],
                $join['nullable'] ?? true
            );
        }
        if ($inverse) {
            $builder->inversedBy($inverse);
        }
        return $builder->build();
    }

    public function addKey(string $name, string $type) : ClassMetadataBuilder
    {
        $builder = $this->createField($name, $type)->makePrimaryKey();
        return $builder->build();
    }

    public function addMappedKey(string $column, string $name, string $type) : ClassMetadataBuilder
    {
        $builder = $this->createField($name, $type)->columnName($column)->makePrimaryKey();
        return $builder->build();
    }

    public function addGeneratedKey(string $name) : ClassMetadataBuilder
    {
        $builder = $this->createField($name, 'integer')->makePrimaryKey()->generatedValue('IDENTITY');
        return $builder->build();
    }

    public function addMappedField(
        string $column,
        string $name,
        string $type,
        bool $nullable = false
    ) : ClassMetadataBuilder {
        $mapping['fieldName'] = $name;
        $mapping['type'] = $type;
        $builder = new FieldBuilder($this, $mapping);
        return $builder->columnName($column)->nullable($nullable)->build();
    }

    public function addTimestampableField(
        string $name,
        string $type,
        string $action,
        string $column = '',
        bool $nullable = false,
        string $trackedField = null,
        string $trackedValue = null
    ) : ClassMetadataBuilder {
        // $type = ['date','time', 'datetime', 'datetimetz', 'timestamp', 'zenddate', 'vardatetime', 'integer'];
        // $action = ['update', 'create', 'change'];
        $mapping['fieldName'] = $name;
        $mapping['type'] = $type;
        $builder = new FieldBuilder($this, $mapping);
        $builder->nullable($nullable);
        if ($column) {
            $builder->columnName($column);
        }
        $field = [
            'field' => $name,
            'trackedField' => $trackedField,
            'value' => $trackedValue,
        ];
        $config[$action][] = $field;
        return $builder->build();
    }

    public function addStringKey(
        string $name,
        int $length,
        string $generator = null
    ) : ClassMetadataBuilder {
        $builder = $this->createField($name, 'string')->length($length)->makePrimaryKey();
        if ($generator) {
            $builder->setCustomIdGenerator($generator);
        }
        return $builder->build();
    }

    public function addMappedStringKey(
        string $column,
        string $name,
        int $length,
        string $generator = null
    ) : ClassMetadataBuilder {
        $builder = $this->createField($name, 'string')->length($length)->columnName($column)->makePrimaryKey();
        if ($generator) {
            $builder->setCustomIdGenerator($generator);
        }
        return $builder->build();
    }

    public function addStringField(
        string $name,
        int $length,
        bool $nullable = false,
        iterable $options = []
    ) : bool {
        $builder = $this->createField($name, 'string')->length($length)->nullable($nullable);
        foreach ($options as $name => $value) {
            $builder->option($name, $value);
        }
        return $builder->build();
    }

    public function addMappedStringField(
        string $column,
        string $name,
        int $length,
        bool $nullable = false,
        iterable $options = []
    ) : ClassMetadataBuilder {
        $builder = $this->createField($name, 'string')->length($length)->columnName($column)->nullable($nullable);
        foreach ($options as $name => $value) {
            $builder->option($name, $value);
        }
        return $builder->build();
    }
}
