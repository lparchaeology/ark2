<?php

/**
 * ARK Model Schema Datatype.
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

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class Datatype
{
    use EnabledTrait;
    use KeywordTrait;

    protected $datatype = '';
    protected $type;
    protected $entity;
    protected $valueName;
    protected $formatName;
    protected $formatVocabulary;
    protected $parameterName;
    protected $parameterVocabulary;
    protected $formTypeClass = '';
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
        return $this->datatype;
    }

    public function type() : Type
    {
        return $this->type;
    }

    public function entity() : string
    {
        return $this->entity;
    }

    public function valueName() : string
    {
        return $this->valueName ?: $this->type->valueName();
    }

    public function formatName() : ?string
    {
        return $this->formatName ?: $this->type->formatName();
    }

    public function formatVocabulary() : ?string
    {
        return $this->formatVocabulary ?: $this->type->formatVocabulary();
    }

    public function parameterName() : ?string
    {
        return $this->parameterName ?: $this->type->parameterName();
    }

    public function parameterVocabulary() : ?string
    {
        return $this->parameterVocabulary ?: $this->type->parameterVocabulary();
    }

    public function formTypeClass() : ?string
    {
        return $this->formTypeClass ?: $this->type->formTypeClass();
    }

    public function activeFormType() : ?string
    {
        return $this->activeFormType ?: $this->type->activeFormType();
    }

    public function readonlyFormType() : ?string
    {
        return $this->readonlyFormType ?: $this->type->readonlyFormType();
    }

    public function staticFormType() : ?string
    {
        return $this->staticFormType ?: $this->type->staticFormType();
    }

    public function parameterFormType() : ?string
    {
        return $this->parameterFormType ?: $this->type->parameterFormType();
    }

    public function formatFormType() : ?string
    {
        return $this->formatFormType ?: $this->type->formatFormType();
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
            return $this->nullValue();
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
        // Datatypes with multiple fragments per value, e.g. LocalText (but not Objects)
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

    public function hydrate($data, Attribute $attribute, Vocabulary $vocabulary = null) : Collection
    {
        $fragments = new ArrayCollection();
        if ($data === [] || $data === null) {
            return $fragments;
        }
        if (!$this->hasMultipleValues()) {
            $data = [$data];
        }
        foreach ($data as $datum) {
            $fragment = Fragment::createFromAttribute($attribute);
            $this->hydrateFragment($datum, $fragment, $vocabulary);
            $fragments[] = $fragment;
        }
        return $fragments;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_datatype');
        $builder->setReadOnly();
        $builder->setJoinedTableInheritance()->setDiscriminatorColumn('type', 'string', 30);
        $types = Service::database()->getTypes();
        foreach ($types as $type => $attributes) {
            $builder->addDiscriminatorMapClass($type, $attributes['model_class']);
        }

        // Key
        $builder->addStringKey('datatype', 30);

        // Attributes
        $builder->addStringField('entity', 100);
        $builder->addStringField('valueName', 30, 'value_name');
        $builder->addStringField('formatName', 30, 'format_name');
        $builder->addStringField('formatVocabulary', 30, 'format_vocabulary');
        $builder->addStringField('parameterName', 30, 'parameter_name');
        $builder->addStringField('parameterVocabulary', 30, 'parameter_vocabulary');
        $builder->addStringField('formTypeClass', 100, 'form_type_class');
        $builder->addStringField('activeFormType', 100, 'active_form_class');
        $builder->addStringField('readonlyFormType', 100, 'readonly_form_class');
        $builder->addStringField('staticFormType', 100, 'static_form_class');
        $builder->addStringField('formatFormType', 100, 'format_form_class');
        $builder->addStringField('parameterFormType', 100, 'parameter_form_class');
        $builder->addField('object', 'boolean');
        $builder->addField('array', 'boolean');
        $builder->addField('span', 'boolean');
        $builder->addField('multiple', 'boolean');
        $builder->addField('sortable', 'boolean');
        $builder->addField('searchable', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addManyToOneField('type', Type::class, 'type', 'type', false);
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
        if ($data instanceof DateTime) {
            if ($span) {
                $fragment->setSpan($data, $extent);
            } else {
                $fragment->setValue($data);
            }
            return;
        }
        if ($data instanceof Item) {
            $format = null;
            $parameter = ($this->parameterName() ? $data->schema()->module()->name() : null);
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
