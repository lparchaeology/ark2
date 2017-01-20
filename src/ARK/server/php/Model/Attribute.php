<?php

/**
 * ARK Model Schema Attribute
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

namespace ARK\Model;

use ARK\Model\EnabledTrait;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

abstract class Attribute
{
    use EnabledTrait;
    use KeywordTrait;

    protected $attribute = '';
    protected $format = null;
    protected $vocabulary = null;
    protected $minimum = 0;
    protected $maximum = 1;
    protected $uniqueValues = false;
    protected $additionalValues = false;

    public function name()
    {
        return $this->attribute;
    }

    public function isCompound()
    {
        return $this->hasMultipleOccurrences() || $this->format->isCompound();
    }

    public function isAtomic()
    {
        return !$this->isCompound();
    }

    public function format()
    {
        return $this->format;
    }

    public function hasVocabulary()
    {
        return (bool) $this->vocabulary;
    }

    public function vocabulary()
    {
        return $this->vocabulary;
    }

    public function defaultValue()
    {
        //TODO Needs implementing!
    }

    public function isRequired()
    {
        return $this->minimum > 0;
    }

    public function hasMultipleOccurrences()
    {
        return ($this->maximum != 1);
    }

    public function minimumOccurrences()
    {
        return $this->minimum;
    }

    public function maximumOccurrences()
    {
        return $this->maximum;
    }

    public function uniqueValues()
    {
        return $this->uniqueValues;
    }

    public function additionalValues()
    {
        return $this->additionalValues;
    }

    public function keyword()
    {
        if ($this->keyword) {
            return $this->keyword;
        }
        return $this->format()->keyword();
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setMappedSuperclass();
        $builder->setReadOnly();

        // Attributes
        $builder->addField('minimum', 'integer');
        $builder->addField('maximum', 'integer');
        $builder->addField('uniqueValues', 'boolean', [], 'unique_values');
        $builder->addField('additionalValues', 'boolean', [], 'additional_values');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addManyToOneField('format', 'ARK\Model\Format', 'format', 'format', false);
        $builder->addManyToOneField('vocabulary', 'ARK\Vocabulary\Vocabulary', 'vocabulary', 'concept');
    }
}
