<?php

/**
 * ARK Model Vocabulary Term
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
    protected $fromConcept = null;
    protected $fromTermName = '';
    protected $fromTerm = null;
    protected $toConcept = null;
    protected $toTermName = '';
    protected $toTerm = null;
    protected $relation = '';
    protected $depth = 0;

    public function fromTerm()
    {
        return $this->fromTerm;
    }

    public function toTerm()
    {
        return $this->toTerm;
    }

    public function type()
    {
        return $this->relation;
    }

    public function depth()
    {
        return $this->depth;
    }

    public static function loadMetadata(ClassMetadata $metadata)
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
        $builder->addStringField('relation', 30);
        $builder->addField('depth', 'integer');

        // Associations
        $builder->addCompoundManyToOneField(
            'fromTerm',
            'ARK\Vocabulary\Term',
            [
                ['column' => 'from_concept', 'reference' => 'concept', 'nullable' => false],
                ['column' => 'from_term', 'reference' => 'term', 'nullable' => false],
            ]
        );
        $builder->addCompoundManyToOneField(
            'toTerm',
            'ARK\Vocabulary\Term',
            [
                ['column' => 'to_concept', 'reference' => 'concept', 'nullable' => false],
                ['column' => 'to_term', 'reference' => 'term', 'nullable' => false],
            ]
        );
    }
}
