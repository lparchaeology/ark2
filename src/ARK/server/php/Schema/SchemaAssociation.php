<?php

/**
 * ARK Schema Association
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

namespace ARK\Schema;

use ARK\EnabledTrait;
use ARK\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class SchemaAssociation
{
    use EnabledTrait;
    use KeywordTrait;

    protected $schma = null;
    protected $subtypeName = '';
    protected $subtype = null;
    protected $association = '';
    protected $degree = 0;
    protected $inverse = null;
    protected $inverseDegree = 1;
    protected $bidirectional = false;

    public function schema()
    {
        return $this->schma;
    }

    public function subtype()
    {
        if ($this->subtypeName) {
            return $this->subtype;
        }
        return null;
    }

    public function subtypeName()
    {
        return $this->subtypeName;
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
        $builder->addManyToOneKey('schma', 'Schema');
        $builder->addStringKey('subtypeName', 30, 'subtype');
        $builder->addStringKey('association', 30);
        $builder->addField('degree', 'integer');
        $builder->addManyToOneField('inverse', 'Schema', 'inverse', 'schma', false);
        $builder->addField('inverseDegree', 'integer', [], 'inverse_degree');
        $builder->addField('bidirectional', 'boolean');
        $builder->addCompoundManyToOneField(
            'subtype',
            'SchemaSubtype',
            [['column' => 'schma', 'nullable' => false], ['column' => 'subtype', 'nullable' => false]]
        );
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->setReadOnly();
    }
}
