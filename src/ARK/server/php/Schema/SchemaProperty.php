<?php

/**
 * ARK Schema Property
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

class SchemaProperty
{
    use EnabledTrait;
    use KeywordTrait;

    protected $schma = null;
    protected $subtypeName = '';
    protected $subtype = null;
    protected $property = '';
    protected $format = null;
    protected $vocabulary = null;
    protected $minimum = 0;
    protected $maximum = 1;
    protected $uniqueValues = false;
    protected $additionalValues = false;

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
        return $this->property;
    }

    public function format()
    {
        return $this->format;
    }

    public function vocabulary()
    {
        return $this->vocabulary;
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

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_schema_property');
        $builder->addManyToOneKey('schma', 'Schema');
        $builder->addStringKey('subtypeName', 30, 'subtype');
        $builder->addStringKey('property', 30);
        $builder->addManyToOneField('format', 'Format', 'format', 'format', false);
        $builder->addManyToOneField('vocabulary', 'ARK\\Vocabulary\\Vocabulary', 'vocabulary', 'concept');
        $builder->addField('minimum', 'integer');
        $builder->addField('maximum', 'integer');
        $builder->addField('uniqueValues', 'boolean', [], 'unique_values');
        $builder->addField('additionalValues', 'boolean', [], 'additional_values');
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
