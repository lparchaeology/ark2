<?php

/**
 * ARK Model Vocabulary Relation
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

namespace ARK\Vocabulary;

use ARK\ORM\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class Related
{
    protected $relation = '';
    protected $notation = '';
    protected $recipricol = '';
    protected $recipricolNotation = '';
    protected $equivalence = false;
    protected $heirarchy = false;
    protected $associative = false;

    public function id()
    {
        return $this->relation;
    }

    public function notation()
    {
        return $this->notation;
    }

    public function reciprocolRelation()
    {
        return $this->recipricol;
    }

    public function recipricolNotation()
    {
        return $this->recipricolNotation;
    }

    public function isEquivalence()
    {
        return $this->equivalence;
    }

    public function isHeirarchy()
    {
        return $this->heirarchy;
    }

    public function isAssociative()
    {
        return $this->associative;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_vocabulary_relation');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('relation', 30);

        // Attributes
        $builder->addStringField('notation', 30);
        $builder->addStringField('recipricol', 30);
        $builder->addStringField('recipricolNotation', 30, 'recipricol_notation');
        $builder->addField('equivalence', 'boolean');
        $builder->addField('heirarchy', 'boolean');
        $builder->addField('associative', 'boolean');
    }
}
