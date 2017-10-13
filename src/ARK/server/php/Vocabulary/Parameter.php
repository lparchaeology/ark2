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

class Parameter
{
    protected $concept = '';
    protected $termName = '';
    protected $term;
    protected $name = '';
    protected $type = '';
    protected $value = '';

    public function term() : Term
    {
        return $this->term;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function type() : string
    {
        return $this->type;
    }

    public function value() : string
    {
        return $this->value;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_vocabulary_parameter');
        $builder->setReadOnly();

        // Key
        $builder->addVocabularyKey('concept', 'concept', 'terms');
        $builder->addMappedStringKey('term', 'termName', 30);
        $builder->addStringKey('name', 30);

        // Attributes
        $builder->addStringField('type', 10);
        $builder->addStringField('value', 1431655765);

        // Associations
        $builder->addCompositeManyToOneField(
            'term',
            Term::class,
            [
                ['column' => 'concept', 'nullable' => false],
                ['column' => 'term', 'nullable' => false],
            ]
        );
    }
}
