<?php

/**
 * ARK Model Schema Dataclass.
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
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class Dataclass
{
    use EnabledTrait;
    use KeywordTrait;

    protected $dataclass = '';
    protected $datatype;
    protected $entity;
    protected $valueName;
    protected $formatName;
    protected $formatVocabulary;
    protected $parameterName;
    protected $parameterVocabulary;
    protected $formType = '';
    protected $activeFormType = '';
    protected $readonlyFormType = '';
    protected $staticFormType = '';
    protected $formatFormType = '';
    protected $parameterFormType = '';
    protected $object = false;
    protected $array = false;
    protected $span = false;
    protected $multiple = false;
    protected $sortable = false;
    protected $searchable = false;
    protected $preset;

    public function id() : string
    {
        return $this->dataclass;
    }

    public function datatype() : Datatype
    {
        return $this->datatype;
    }

    public function entity() : ?string
    {
        return $this->entity;
    }

    public function valueName() : string
    {
        return $this->valueName ?? $this->datatype->valueName();
    }

    public function formatName() : ?string
    {
        return $this->formatName ?? $this->datatype->formatName();
    }

    public function formatVocabulary() : ?string
    {
        return $this->formatVocabulary ?? $this->datatype->formatVocabulary();
    }

    public function parameterName() : ?string
    {
        return $this->parameterName ?? $this->datatype->parameterName();
    }

    public function parameterVocabulary() : ?string
    {
        return $this->parameterVocabulary ?? $this->datatype->parameterVocabulary();
    }

    public function formType() : ?string
    {
        return $this->formType ?? $this->datatype->formType();
    }

    public function activeFormType() : ?string
    {
        return $this->activeFormType ?? $this->datatype->activeFormType();
    }

    public function readonlyFormType() : ?string
    {
        return $this->readonlyFormType ?? $this->datatype->readonlyFormType();
    }

    public function staticFormType() : ?string
    {
        return $this->staticFormType ?? $this->datatype->staticFormType();
    }

    public function parameterFormType() : ?string
    {
        return $this->parameterFormType ?? $this->datatype->parameterFormType();
    }

    public function formatFormType() : ?string
    {
        return $this->formatFormType ?? $this->datatype->formatFormType();
    }

    public function isSpan() : bool
    {
        return $this->span;
    }

    public function isSortable() : bool
    {
        return $this->sortable;
    }

    public function isSearchable() : bool
    {
        return $this->searchable;
    }

    public function hasMultipleValues() : bool
    {
        return $this->multiple;
    }

    public function isAtomic() : bool
    {
        return $this->formatName() === null && $this->parameterName() === null;
    }

    public function constraints() : iterable
    {
        return [];
    }

    public function emptyValue()
    {
        if ($this->hasMultipleValues()) {
            return [];
        }
        if ($this->isAtomic()) {
            return $this->isSpan() ? [null, null] : null;
        }
        $data = [];
        if ($this->formatName()) {
            $data[$this->formatName()] = null;
        }
        if ($this->parameterName()) {
            $data[$this->parameterName()] = null;
        }
        $data[$this->valueName()] = ($this->isSpan() ? [null, null] : null);
        ksort($data);
        return $data;
    }

    public function defaultValue()
    {
        return $this->preset;
    }

    public function value($model, Collection $properties = null)
    {
        if ($model instanceof Fragment) {
            return $this->fragmentValue($model, $properties);
        }
        if (!$model instanceof Collection || $model->isEmpty()) {
            return $this->emptyValue();
        }
        if ($this->hasMultipleValues()) {
            $data = [];
            foreach ($model as $fragment) {
                if ($properties && $properties->hasKey($fragment->id())) {
                    $data[] = $this->value($fragment, $properties[$fragment->id()]);
                } else {
                    $data[] = $this->value($fragment, $properties);
                }
            }
            return $data;
        }
        // Dataclasss with multiple fragments per value, e.g. LocalText (but not Objects)
        return $this->fragmentValue($model, $properties);
    }

    public function serialize($model, Collection $properties = null)
    {
        if ($model instanceof Fragment) {
            return $this->serializeFragment($model, $properties);
        }
        if (!$model instanceof Collection || $model->isEmpty()) {
            return null;
        }
        if ($this->hasMultipleValues()) {
            $data = [];
            foreach ($model as $fragment) {
                $data[] = $this->serializeFragment($fragment, $properties);
            }
            return $data;
        }
        return $this->serializeFragment($model->first(), $properties);
    }

    public function hydrate(
        $data,
        Attribute $attribute,
        Actor $creator,
        DateTime $created,
        Vocabulary $vocabulary = null
    ) : Collection {
        $fragments = new ArrayCollection();
        if ($data === [] || $data === null) {
            return $fragments;
        }
        if (!$this->hasMultipleValues()) {
            $data = [$data];
        }
        foreach ($data as $datum) {
            $fragment = Fragment::createFromAttribute($attribute, $creator, $created);
            $this->hydrateFragment($datum, $fragment, $vocabulary);
            $fragments[] = $fragment;
        }
        return $fragments;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_dataclass');
        $builder->setReadOnly();
        $builder->setJoinedTableInheritance()->setDiscriminatorColumn('datatype', 'string', 30);
        $datatypes = Service::database()->getDatatypes();
        foreach ($datatypes as $datatype => $attributes) {
            $builder->addDiscriminatorMapClass($datatype, $attributes['model_entity']);
        }

        // Key
        $builder->addStringKey('dataclass', 30);

        // Attributes
        $builder->addStringField('entity', 100);
        $builder->addMappedStringField('value_name', 'valueName', 30);
        $builder->addMappedStringField('format_name', 'formatName', 30);
        $builder->addMappedStringField('format_vocabulary', 'formatVocabulary', 30);
        $builder->addMappedStringField('parameter_name', 'parameterName', 30);
        $builder->addMappedStringField('parameter_vocabulary', 'parameterVocabulary', 30);
        $builder->addMappedStringField('form_type', 'formType', 100);
        $builder->addMappedStringField('active_form_type', 'activeFormType', 100);
        $builder->addMappedStringField('readonly_form_type', 'readonlyFormType', 100);
        $builder->addMappedStringField('static_form_type', 'staticFormType', 100);
        $builder->addMappedStringField('format_form_type', 'formatFormType', 100);
        $builder->addMappedStringField('parameter_form_type', 'parameterFormType', 100);
        $builder->addField('object', 'boolean');
        $builder->addField('array', 'boolean');
        $builder->addField('span', 'boolean');
        $builder->addField('multiple', 'boolean');
        $builder->addField('sortable', 'boolean');
        $builder->addField('searchable', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addRequirdManyToOneField('datatype', Datatype::class);
    }

    protected function fragmentValue($fragment, Collection $properties = null)
    {
        if ($fragment instanceof Collection) {
            return $this->serializeFragment($fragment->first(), $properties);
        }
        if ($fragment instanceof Fragment) {
            return $this->serializeFragment($fragment, $properties);
        }
        return null;
    }

    protected function serializeFragment(Fragment $fragment, Collection $properties = null)
    {
        if ($this->isAtomic()) {
            if ($fragment->isSpan() || $this->isSpan()) {
                return [$fragment->value(), $fragment->extent()];
            }
            return $fragment->value();
        }
        $data = [];
        if ($this->formatName()) {
            $data[$this->formatName()] = $fragment->format();
        }
        if ($this->parameterName()) {
            $data[$this->parameterName()] = $fragment->parameter();
        }
        if ($fragment->isSpan() || $this->isSpan()) {
            $data[$this->valueName()] = [$fragment->value(), $fragment->extent()];
        } else {
            $data[$this->valueName()] = $fragment->value();
        }
        ksort($data);
        return $data;
    }

    protected function hydrateFragment($data, Fragment $fragment, Vocabulary $vocabulary = null) : void
    {
        $span = ($this->isSpan() || $fragment->isSpan());
        if ($span) {
            $extent = $data[1];
            $data = $data[0];
        }
        if ($vocabulary instanceof Vocabulary) {
            $data = ($data instanceof Term ? $data->name() : $data);
            if ($span) {
                $extent = ($extent instanceof Term ? $extent->name() : $extent);
                $fragment->setSpan($data, $extent, $vocabulary->concept());
            } else {
                $fragment->setValue($data, $vocabulary->concept());
            }
            return;
        }
        if ($data instanceof Term) {
            if ($span) {
                $fragment->setSpan($data->name(), $extent->name(), $data->concept()->concept());
            } else {
                $fragment->setValue($data->name(), $data->concept()->concept());
            }
            return;
        }
        if ($data instanceof Item) {
            $format = null;
            $parameter = ($this->parameterName() ? $data->schema()->module()->id() : null);
            $value = ($this->valueName() ? $data->id() : null);
            $fragment->setValue($value, $parameter, $format);
            return;
        }
        if ($this->isAtomic()) {
            if ($span) {
                $fragment->setSpan($data, $extent);
            } else {
                $fragment->setValue($data);
            }
            return;
        }
        if (!is_array($data)) {
            // TODO throw error
        }
        $format = ($this->formatName() && isset($data[$this->formatName()]) ? $data[$this->formatName()] : null);
        $parameter = ($this->parameterName() && isset($data[$this->parameterName()]) ? $data[$this->parameterName()] : null);
        $value = ($this->valueName() && isset($data[$this->valueName()]) ? $data[$this->valueName()] : null);
        if ($span) {
            $extent = ($this->valueName() ? $extent[$this->valueName()] : null);
            $fragment->setSpan($value, $extent, $parameter, $format);
        } else {
            $fragment->setValue($value, $parameter, $format);
        }
    }
}
