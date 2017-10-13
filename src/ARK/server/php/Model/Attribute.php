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

use ARK\Actor\Actor;
use ARK\Model\Fragment\Fragment;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Vocabulary\Vocabulary;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;

abstract class Attribute
{
    use EnabledTrait;
    use KeywordTrait;

    protected $attribute = '';
    protected $dataclass;
    protected $vocabulary;
    protected $span = false;
    protected $minimum = 0;
    protected $maximum = 1;
    protected $uniqueValues = false;
    protected $additionalValues = false;

    public function name() : string
    {
        return $this->attribute;
    }

    public function dataclass() : Dataclass
    {
        return $this->dataclass;
    }

    public function hasVocabulary() : bool
    {
        return $this->vocabulary !== null;
    }

    public function isItem() : bool
    {
        return $this->dataclass->datatype()->id() === 'item';
    }

    public function isObject() : bool
    {
        return $this->dataclass->datatype()->id() === 'object';
    }

    public function entity() : string
    {
        return $this->dataclass->entity();
    }

    public function vocabulary() : ?Vocabulary
    {
        return $this->vocabulary;
    }

    public function hasTransitions() : bool
    {
        if ($this->vocabulary) {
            return (bool) $this->vocabulary->hasTransitions();
        }
        return false;
    }

    public function transitions() : Collection
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
        return $this->dataclass->defaultValue();
    }

    public function isSpan() : bool
    {
        return $this->span;
    }

    public function isRequired() : bool
    {
        // TODO Should inherit from parent???
        return $this->minimum > 0;
    }

    public function hasMultipleOccurrences() : bool
    {
        return $this->maximum !== 1;
    }

    public function minimumOccurrences() : int
    {
        return $this->minimum;
    }

    public function maximumOccurrences() : int
    {
        return $this->maximum;
    }

    public function uniqueValues() : bool
    {
        return $this->uniqueValues;
    }

    public function additionalValues() : bool
    {
        return $this->additionalValues;
    }

    public function constraints() : iterable
    {
        $constraints = $this->dataclass->constraints();
        if ($this->maximum > 1) {
            $constraints[] = new Count(['min' => $this->minimum, 'max' => $this->maximum]);
        } elseif ($this->maximum === 0) {
            $constraints[] = new Count(['min' => $this->minimum]);
        } elseif ($this->minimum > 0) {
            $constraints[] = new NotBlank();
        }
        return $constraints;
    }

    public function keyword() : ?string
    {
        return $this->keyword ?? $this->dataclass()->keyword() ?? null;
    }

    public function emptyValue()
    {
        if ($this->hasMultipleOccurrences()) {
            return [];
        }
        if ($this->hasVocabulary()) {
            return null;
        }
        return $this->dataclass()->emptyValue();
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
                    $data[] = $this->fragmentToTerm($fragment);
                }
                return $data;
            }
            return $this->fragmentToTerm($fragments[0]);
        }
        if ($this->dataclass()->datatype()->isObject()) {
            if ($this->hasMultipleOccurrences()) {
                $data = [];
                foreach ($fragments as $fragment) {
                    $data[] = $this->dataclass()->value($fragment, $properties->get($fragment->id()));
                }
                return $data;
            }
            $fragment = $fragments->first();
            return $this->dataclass()->value($fragment, $properties->get($fragment->id()));
        }
        if ($this->hasMultipleOccurrences()) {
            $data = [];
            foreach ($fragments as $fragment) {
                $data[] = $this->dataclass()->value(new ArrayCollection([$fragment]));
            }
            return $data;
        }
        return $this->dataclass()->value($fragments);
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
        if ($this->dataclass()->datatype()->isObject()) {
            if ($this->hasMultipleOccurrences()) {
                $data = [];
                foreach ($fragments as $fragment) {
                    $data[] = $this->dataclass()->serialize($fragment, $properties->get($fragment->id()));
                }
                return $data;
            }
            $fragment = $fragments->first();
            return $this->dataclass()->serialize($fragment, $properties->get($fragment->id()));
        }
        if ($this->hasMultipleOccurrences()) {
            $data = [];
            foreach ($fragments as $fragment) {
                $data[] = $this->dataclass()->serialize(new ArrayCollection([$fragment]), $properties->get($fragment->id()));
            }
            return $data;
        }
        return $this->dataclass()->serialize($fragments, $properties);
    }

    public function hydrate($data, Actor $creator, DateTime $created) : Collection
    {
        $fragments = new ArrayCollection();
        if (is_array($data)) {
            ksort($data);
        }
        if ($data === null || $data === [] || $data === $this->emptyValue()) {
            return $fragments;
        }
        if (!$this->hasMultipleOccurrences() && !$this->dataclass()->hasMultipleValues()) {
            $data = [$data];
        }
        foreach ($data as $datum) {
            $frags = $this->dataclass()->hydrate($datum, $this, $creator, $created, $this->vocabulary);
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
        $builder->addMappedField('unique_values', 'uniqueValues', 'boolean');
        $builder->addMappedField('additional_values', 'additionalValues', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addRequiredManyToOneField('dataclass', Dataclass::class);
        $builder->addVocabularyField('vocabulary');
    }

    protected function fragmentToTerm(Fragment $fragment)
    {
        $value = ($fragment->value() ? $this->vocabulary->term($fragment->value()) : null);
        if ($this->dataclass()->isSpan() || $fragment->isSpan()) {
            $extent = ($fragment->extent() ? $this->vocabulary->term($fragment->extent()) : null);
            return [$value, $extent];
        }
        return $value;
    }
}
