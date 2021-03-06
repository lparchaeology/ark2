<?php

/**
 * ARK Vocabulary Relation  Type.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Vocabulary;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class Relation
{
    protected $relation = '';
    protected $notation = '';
    protected $recipricol = '';
    protected $recipricolNotation = '';
    protected $equivalence = false;
    protected $hierarchy = false;
    protected $associative = false;

    public function id() : string
    {
        return $this->relation;
    }

    public function notation() : string
    {
        return $this->notation;
    }

    public function reciprocolRelation() : string
    {
        return $this->recipricol;
    }

    public function recipricolNotation() : string
    {
        return $this->recipricolNotation;
    }

    public function isEquivalence() : bool
    {
        return $this->equivalence;
    }

    public function isHierarchy() : bool
    {
        return $this->hierarchy;
    }

    public function isAssociative() : bool
    {
        return $this->associative;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_vocabulary_relation');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('relation', 30);

        // Attributes
        $builder->addStringField('notation', 30);
        $builder->addStringField('recipricol', 30);
        $builder->addMappedStringField('recipricol_notation', 'recipricolNotation', 30);
        $builder->addField('equivalence', 'boolean');
        $builder->addField('hierarchy', 'boolean');
        $builder->addField('associative', 'boolean');
    }
}
