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
use ARK\Model\KeywordTrait;
use ARK\Model\Schema;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class SchemaAssociation
{
    use EnabledTrait;
    use KeywordTrait;

    protected $schma;
    protected $class = '';
    protected $association = '';
    protected $module1 = '';
    protected $schema1 = '';
    protected $owningSchema;
    protected $module2 = '';
    protected $schema2 = '';
    protected $degree = 0;
    protected $inverse;
    protected $inverseSchema;
    protected $inverseDegree = 1;
    protected $bidirectional = false;

    public function schema() : Schema
    {
        return $this->schma;
    }

    public function class() : string
    {
        return $this->class;
    }

    public function name() : string
    {
        return $this->association;
    }

    public function owningSchema() : Schema
    {
        return $this->owningSchema;
    }

    public function degree() : int
    {
        return $this->degree;
    }

    public function inverseSchema() : Schema
    {
        return $this->inverseSchma;
    }

    public function inverseDegree() : int
    {
        return $this->inverseDegree;
    }

    public function bidirectional() : bool
    {
        return $this->bidirectional;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_schema_association');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('schma', Schema::class);
        $builder->addStringKey('class', 30);
        $builder->addStringKey('association', 30);

        // Fields
        $builder->addStringField('module1', 30);
        $builder->addStringField('schema1', 30);
        $builder->addField('degree', 'integer');
        $builder->addStringField('inverse', 30);
        $builder->addStringField('module2', 30);
        $builder->addStringField('schema2', 30);
        $builder->addField('inverseDegree', 'integer', [], 'inverse_degree');
        $builder->addField('bidirectional', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addCompositeManyToOneField(
            'owningSchema',
            Schema::class,
            [
                ['column' => 'schema1', 'reference' => 'schma'],
            ],
            $inverse = 'schma'
        );
        $builder->addCompositeManyToOneField(
            'inverseSchema',
            Schema::class,
            [
                ['column' => 'schema2', 'reference' => 'schma'],
            ],
            $inverse = 'schma'
        );
    }
}
