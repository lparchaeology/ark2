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

use ARK\Model\EnabledTrait;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class Term
{
    use EnabledTrait;
    use KeywordTrait;

    protected $concept = null;
    protected $term = '';
    protected $alias = '';
    protected $parameters = null;

    public function __construct()
    {
        $this->parameters = new ArrayCollection();
    }

    public function concept()
    {
        return $this->concept;
    }

    public function name()
    {
        return $this->term;
    }

    public function alias()
    {
        return $this->alias;
    }

    public function parameters()
    {
        return $this->parameters;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_vocabulary_term');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('concept', 'ARK\Vocabulary\Vocabulary', 'concept', 'concept', 'terms');
        $builder->addStringKey('term', 30);

        // Attributes
        $builder->addStringField('alias', 10);
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addOneToMany('parameters', 'ARK\Vocabulary\Parameter', 'term');
    }
}
