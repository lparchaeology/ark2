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
use ARK\Model\Format;
use ARK\Model\Fragment;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Vocabulary\Vocabulary;
use Doctrine\Common\Collections\ArrayCollection;

abstract class Attribute
{
    use EnabledTrait;
    use KeywordTrait;

    protected $attribute = '';
    protected $format = null;
    protected $vocabulary = null;
    protected $visibility = 'restricted';
    protected $visibilityTerm = null;
    protected $read = null;
    protected $update = null;
    protected $span = false;
    protected $minimum = 0;
    protected $maximum = 1;
    protected $uniqueValues = false;
    protected $additionalValues = false;

    public function name()
    {
        return $this->attribute;
    }

    public function format()
    {
        return $this->format;
    }

    public function hasVocabulary()
    {
        return $this->vocabulary !== null;
    }

    public function vocabulary()
    {
        return $this->vocabulary;
    }

    public function hasTransitions()
    {
        if ($this->vocabulary) {
            return (bool) $this->vocabulary->hasTransitions();
        }
        return false;
    }

    public function transitions()
    {
        if ($this->vocabulary) {
            return $this->vocabulary->transitions();
        }
        return null;
    }

    public function visibility()
    {
        if ($this->visibilityTerm === null) {
            $this->visibilityTerm = ORM::find(Term::class, ['concept' => 'core.visibility', 'term' => $this->visibility]);
        }
        return $this->visibilityTerm;
    }

    public function readPermission()
    {
        return $this->read;
    }

    public function updatePermission()
    {
        return $this->update;
    }

    public function defaultValue()
    {
        //TODO Needs implementing!
    }

    public function isSpan()
    {
        return $this->span;
    }

    public function isRequired()
    {
        // TODO Should inherit from parent???
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
        if ($this->format) {
            return $this->format()->keyword();
        }
        return '';
    }

    public function nullValue()
    {
        if ($this->hasMultipleOccurrences()) {
            return [];
        }
        if ($this->hasVocabulary()) {
            return null;
        }
        return $this->format()->nullValue();
    }

    public function value(ArrayCollection $fragments, ArrayCollection $properties)
    {
        if ($fragments->isEmpty()) {
            return $this->nullValue();
        }
        if ($this->hasVocabulary()) {
            if ($this->hasMultipleOccurrences()) {
                $data = [];
                foreach ($fragments as $fragment) {
                    $data[] = $this->vocabulary->term($fragment->value());
                }
                return $data;
            }
            return $this->vocabulary->term($fragments[0]->value());
        }
        if ($this->hasMultipleOccurrences()) {
            $data = [];
            foreach ($fragments as $fragment) {
                $data[] = $this->format()->value(new ArrayCollection([$fragment]), $properties->get($fragment->id()));
            }
            return $data;
        }
        return $this->format()->value($fragments, $properties);
    }

    public function serialize(ArrayCollection $fragments, ArrayCollection $properties)
    {
        if ($fragments->isEmpty()) {
            return null;
        }
        if ($this->hasVocabulary()) {
            if ($this->hasMultipleOccurrences()) {
                $data = [];
                foreach ($fragments as $fragment) {
                    $data[] = $fragment->value();
                }
                return $data;
            }
            return $fragments[0]->value();
        }
        if ($this->hasMultipleOccurrences()) {
            $data = [];
            foreach ($fragments as $fragment) {
                $data[] = $this->format()->serialize(new ArrayCollection([$fragment]), $properties->get($fragment->id()));
            }
            return $data;
        }
        return $this->format()->serialize($fragments, $properties);
    }

    public function hydrate($data)
    {
        if ($data === null || $data === [] || $data === $this->nullValue()) {
            return [];
        }
        // TODO Objects/Chains
        if ($this->hasMultipleOccurrences() || $this->format()->hasMultipleValues()) {
            $fragments = [];
            foreach ($data as $datum) {
                $fragment = Fragment::createFromAttribute($this);
                $this->format()->hydrate($datum, $fragment, $this->vocabulary);
                $fragments[] = $fragment;
            }
            return $fragments;
        }
        $fragment = Fragment::createFromAttribute($this);
        $this->format()->hydrate($data, $fragment, $this->vocabulary);
        return $fragment;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setMappedSuperclass();
        $builder->setReadOnly();

        // Attributes
        $builder->addStringField('visibility', 30);
        $builder->addField('span', 'boolean');
        $builder->addField('minimum', 'integer');
        $builder->addField('maximum', 'integer');
        $builder->addField('uniqueValues', 'boolean', [], 'unique_values');
        $builder->addField('additionalValues', 'boolean', [], 'additional_values');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addManyToOneField('format', Format::class, 'format', 'format', false);
        $builder->addVocabularyField('vocabulary');
        $builder->addPermissionField('read', 'view');
        $builder->addPermissionField('update', 'edit');
    }
}
