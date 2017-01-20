<?php

/**
 * ARK Model Schema Association
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

namespace ARK\Model\Schema;

use ARK\Model\EnabledTrait;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class SchemaAssociation
{
    use EnabledTrait;
    use KeywordTrait;

    protected $schma = null;
    protected $typeName = '';
    protected $type = null;
    protected $association = '';
    protected $degree = 0;
    protected $inverse = null;
    protected $inverseDegree = 1;
    protected $bidirectional = false;

    public function schema()
    {
        return $this->schma;
    }

    public function type()
    {
        if ($this->typeName) {
            return $this->type;
        }
        return null;
    }

    public function typeName()
    {
        return $this->typeName;
    }

    public function name()
    {
        return $this->association;
    }

    public function degree()
    {
        return $this->degree;
    }

    public function inverseSchema()
    {
        return $this->inverse;
    }

    public function inverseDegree()
    {
        return $this->inverseDegree;
    }

    public function bidirectional()
    {
        return $this->bidirectional;
    }
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_schema_association');
        $builder->addManyToOneKey('schma', 'ARK\Model\Schema');
        $builder->addStringKey('typeName', 30, 'type');
        $builder->addStringKey('association', 30);
        $builder->addField('degree', 'integer');
        $builder->addManyToOneField('inverse', 'ARK\Model\Schema', 'inverse', 'schma', false);
        $builder->addField('inverseDegree', 'integer', [], 'inverse_degree');
        $builder->addField('bidirectional', 'boolean');
        $builder->addCompoundManyToOneField(
            'type',
            'SchemaType',
            [
                ['column' => 'schma', 'nullable' => false],
                ['column' => 'type', 'nullable' => false],
            ]
        );
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->setReadOnly();
    }
}
