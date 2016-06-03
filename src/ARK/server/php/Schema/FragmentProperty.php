<?php

/**
 * ARK Schema Fragment Type
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

class FragmentProperty
{
    use EnabledTrait;
    use KeywordTrait;

    protected $type = null;
    protected $property = '';
    protected $field = '';
    protected $format = null;
    protected $vocabulary = null;

    public function type()
    {
        return $this->type;
    }

    public function name()
    {
        return $this->property;
    }

    public function field()
    {
        return $this->field;
    }

    public function format()
    {
        return $this->format;
    }

    public function vocabulary()
    {
        return $this->vocabulary;
    }

    public function hasMultipleOccurrences()
    {
        return false;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_fragment_property');
        $builder->addManyToOneKey('type', 'FragmentType', 'type', 'type', false);
        $builder->addStringKey('property', 30);
        $builder->addStringField('field', 50);
        $builder->addManyToOneField('format', 'Format', 'format', 'format', false);
        $builder->addManyToOneField('vocabulary', 'ARK\\Vocabulary\\Vocabulary', 'vocabulary', 'concept');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->setReadOnly();
    }
}
