<?php

/**
 * ARK Model Vocabulary Term.
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

namespace ARK\Vocabulary;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class Related
{
    protected $fromConcept;
    protected $fromTermName = '';
    protected $fromTerm;
    protected $toConcept;
    protected $toTermName = '';
    protected $toTerm;
    protected $relation;
    protected $depth = 0;

    public function fromTerm() : Term
    {
        return $this->fromTerm;
    }

    public function toTerm() : Term
    {
        return $this->toTerm;
    }

    public function relation() : Relation
    {
        return $this->relation;
    }

    public function depth() : int
    {
        return $this->depth;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_vocabulary_related');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('fromConcept', 'ARK\Vocabulary\Vocabulary', 'from_concept', 'concept');
        $builder->addStringKey('fromTermName', 30, 'from_term');
        $builder->addManyToOneKey('toConcept', 'ARK\Vocabulary\Vocabulary', 'to_concept', 'concept');
        $builder->addStringKey('toTermName', 30, 'to_term');

        // Attributes
        $builder->addManyToOneField('relation', Relation::class, 'relation');
        $builder->addField('depth', 'integer');

        // Associations
        $builder->addCompositeManyToOneField(
            'fromTerm',
            'ARK\Vocabulary\Term',
            [
                ['column' => 'from_concept', 'reference' => 'concept', 'nullable' => false],
                ['column' => 'from_term', 'reference' => 'term', 'nullable' => false],
            ]
        );
        $builder->addCompositeManyToOneField(
            'toTerm',
            'ARK\Vocabulary\Term',
            [
                ['column' => 'to_concept', 'reference' => 'concept', 'nullable' => false],
                ['column' => 'to_term', 'reference' => 'term', 'nullable' => false],
            ]
        );
    }
}
