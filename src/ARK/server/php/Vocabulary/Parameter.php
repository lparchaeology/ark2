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

class Parameter
{
    protected $concept = '';
    protected $termName = '';
    protected $term = null;
    protected $name = '';
    protected $type = '';
    protected $value = '';

    public function term()
    {
        return $this->term;
    }

    public function name()
    {
        return $this->name;
    }

    public function type()
    {
        return $this->type;
    }

    public function value()
    {
        return $this->value;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_vocabulary_parameter');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('concept', 'ARK\Vocabulary\Vocabulary', 'concept', 'concept', 'terms');
        $builder->addStringKey('termName', 30, 'term');
        $builder->addStringKey('name', 30);

        // Attributes
        $builder->addStringField('type', 10);
        $builder->addStringField('value', 1431655765);

        // Associations
        $builder->addCompoundManyToOneField(
            'term',
            'ARK\Vocabulary\Term',
            [
                ['column' => 'concept', 'nullable' => false],
                ['column' => 'term', 'nullable' => false],
            ]
        );
    }
}
