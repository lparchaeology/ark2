<?php

/**
 * ARK Model Schema Attribute.
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

namespace ARK\Model;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Vocabulary\Vocabulary;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;

abstract class Attribute
{
    use EnabledTrait;
    use KeywordTrait;

    protected $attribute = '';
    protected $datatype;
    protected $vocabulary;
    protected $span = false;
    protected $minimum = 0;
    protected $maximum = 1;
    protected $uniqueValues = false;
    protected $additionalValues = false;

    public function name()
    {
        return $this->attribute;
    }

    public function datatype()
    {
        return $this->datatype;
    }

    public function hasVocabulary()
    {
        return $this->vocabulary !== null;
    }

    public function isItem()
    {
        return $this->datatype->type()->id() === 'item';
    }

    public function isObject()
    {
        return $this->datatype->type()->id() === 'object';
    }

    public function entity()
    {
        return $this->datatype->entity();
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

    public function defaultValue()
    {
        if ($this->vocabulary) {
            return $this->vocabulary->defaultTerm();
        }
        return $this->datatype->defaultValue();
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
        return $this->maximum !== 1;
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

    public function constraints() : iterable
    {
        $constraints = $this->datatype->constraints();
        if ($this->maximum > 1) {
            $constraints[] = new Count(['min' => $this->minimum, 'max' => $this->maximum]);
        } elseif ($this->maximum === 0) {
            $constraints[] = new Count(['min' => $this->minimum]);
        } elseif ($this->minimum > 0) {
            $constraints[] = new NotBlank();
        }
        return $constraints;
    }

    public function keyword()
    {
        if ($this->keyword) {
            return $this->keyword;
        }
        if ($this->datatype) {
            return $this->datatype()->keyword();
        }
        return '';
    }

    public function emptyValue()
    {
        if ($this->hasMultipleOccurrences()) {
            return [];
        }
        if ($this->hasVocabulary()) {
            return null;
        }
        return $this->datatype()->emptyValue();
    }

    public function value(ArrayCollection $fragments, ArrayCollection $properties)
    {
        if ($fragments->isEmpty()) {
            return $this->hasMultipleOccurrences() ? [] : null;
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
        if ($this->datatype()->type()->isObject()) {
            if ($this->hasMultipleOccurrences()) {
                $data = [];
                foreach ($fragments as $fragment) {
                    $data[] = $this->datatype()->value($fragment, $properties->get($fragment->id()));
                }
                return $data;
            }
            $fragment = $fragments->first();
            return $this->datatype()->value($fragment, $properties->get($fragment->id()));
        }
        if ($this->hasMultipleOccurrences()) {
            $data = [];
            foreach ($fragments as $fragment) {
                $data[] = $this->datatype()->value(new ArrayCollection([$fragment]));
            }
            return $data;
        }
        return $this->datatype()->value($fragments);
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
                    $data[] = ($fragment->isSpan() ? [$fragment->value(), $fragment->extent()] : $fragment->value());
                }
                return $data;
            }
            $fragment = $fragments[0];
            return $fragment->isSpan() ? [$fragment->value(), $fragment->extent()] : $fragment->value();
        }
        if ($this->datatype()->type()->isObject()) {
            if ($this->hasMultipleOccurrences()) {
                $data = [];
                foreach ($fragments as $fragment) {
                    $data[] = $this->datatype()->serialize($fragment, $properties->get($fragment->id()));
                }
                return $data;
            }
            $fragment = $fragments->first();
            return $this->datatype()->serialize($fragment, $properties->get($fragment->id()));
        }
        if ($this->hasMultipleOccurrences()) {
            $data = [];
            foreach ($fragments as $fragment) {
                $data[] = $this->datatype()->serialize(new ArrayCollection([$fragment]), $properties->get($fragment->id()));
            }
            return $data;
        }
        return $this->datatype()->serialize($fragments, $properties);
    }

    public function hydrate($data)
    {
        $fragments = new ArrayCollection();
        if ($data === null || $data === [] || $data === $this->emptyValue()) {
            return $fragments;
        }
        if (!$this->hasMultipleOccurrences() && !$this->datatype()->hasMultipleValues()) {
            $data = [$data];
        }
        foreach ($data as $datum) {
            $frags = $this->datatype()->hydrate($datum, $this, $this->vocabulary);
            foreach ($frags as $frag) {
                $fragments->add($frag);
            }
        }
        return $fragments;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setMappedSuperclass();
        $builder->setReadOnly();

        // Attributes
        $builder->addField('span', 'boolean');
        $builder->addField('minimum', 'integer');
        $builder->addField('maximum', 'integer');
        $builder->addField('uniqueValues', 'boolean', [], 'unique_values');
        $builder->addField('additionalValues', 'boolean', [], 'additional_values');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addManyToOneField('datatype', Datatype::class, 'datatype', 'datatype', false);
        $builder->addVocabularyField('vocabulary');
    }
}
