<?php

/**
 * ARK Class Metadata Builder
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Builder\FieldBuilder;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder as DoctrineClassMetadataBuilder;
use RuntimeException;

class ClassMetadataBuilder extends DoctrineClassMetadataBuilder
{
    public function __construct($metadata, $table = '')
    {
        parent::__construct($metadata);
        if ($table) {
            $this->setTable($table);
        }
    }

    public function addManyToOneKey($name, $class, $column = null, $reference = null, $inverse = null)
    {
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
        $builder->build();
    }

    public function addManyToOneField($name, $class, $column = null, $reference = null, $nullable = true, $inverse = null)
    {
        if ($column === null) {
            $column = $name;
        }
        if ($reference === null) {
            $reference = $column;
        }
        $builder = $this->createManyToOne($name, $class)->addJoinColumn($column, $reference, $nullable);
        if ($inverse) {
            $builder->inversedBy($inverse);
        }
        $builder->build();
    }

    public function addCompoundManyToOneField($name, $class, $joins, $inverse = null)
    {
        $builder = $this->createManyToOne($name, $class);
        foreach ($joins as $join) {
            $builder->addJoinColumn(
                $join['column'],
                isset($join['reference']) ? $join['reference'] : $join['column'],
                isset($join['nullable']) ? $join['nullable'] : true
            );
        }
        if ($inverse) {
            $builder->inversedBy($inverse);
        }
        $builder->build();
    }

    public function addKey($name, $type, $column = '')
    {
        $builder = $this->createField($name, $type)->makePrimaryKey();
        if ($column) {
            $builder->columnName($column);
        }
        $builder->build();
    }

    public function addField($name, $type, array $mapping = [], $column = '', $nullable = false)
    {
        if ($column) {
            $mapping['fieldName'] = $name;
            $mapping['type'] = $type;
            $builder = new FieldBuilder($this, $mapping);
            $builder->columnName($column)->nullable($nullable)->build();
            return;
        }
        parent::addField($name, $type, $mapping);
    }

    public function addStringKey($name, $length, $column = '')
    {
        $builder = $this->createField($name, 'string')->length($length)->makePrimaryKey();
        if ($column) {
            $builder->columnName($column);
        }
        $builder->build();
    }

    public function addStringField($name, $length, $column = '', $nullable = false)
    {
        $builder = $this->createField($name, 'string')->length($length)->nullable($nullable);
        if ($column) {
            $builder->columnName($column);
        }
        $builder->build();
    }
}