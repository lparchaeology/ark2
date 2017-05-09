<?php

/**
 * ARK Model Schema Format
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

use ARK\Model\Datatype;
use ARK\Model\Fragment;
use ARK\Model\EnabledTrait;
use ARK\Model\Format\FormatAttribute;
use ARK\Model\LocalText;
use ARK\Model\Attribute;
use ARK\Model\Item;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

abstract class Format
{
    use EnabledTrait;
    use KeywordTrait;

    protected $format = '';
    protected $datatype = null;
    protected $entity = null;
    protected $valueName = null;
    protected $formatName = null;
    protected $formatVocabulary = null;
    protected $parameterName = null;
    protected $parameterVocabulary = null;
    protected $formTypeClass = '';
    protected $valueFormType = '';
    protected $formatFormType = '';
    protected $parameterFormType = '';
    protected $object = false;
    protected $array = false;
    protected $span = false;
    protected $multiple = false;
    protected $sortable = false;
    protected $searchable = false;

    public function id()
    {
        return $this->format;
    }

    public function datatype()
    {
        return $this->datatype;
    }

    public function entity()
    {
        return $this->entity;
    }

    public function valueName()
    {
        return ($this->valueName ?: $this->datatype->valueName());
    }

    public function formatName()
    {
        return ($this->formatName ?: $this->datatype->formatName());
    }

    public function formatVocabulary()
    {
        return ($this->formatVocabulary ?: $this->datatype->formatVocabulary());
    }

    public function parameterName()
    {
        return ($this->parameterName ?: $this->datatype->parameterName());
    }

    public function parameterVocabulary()
    {
        return ($this->parameterVocabulary ?: $this->datatype->parameterVocabulary());
    }

    public function formTypeClass()
    {
        return ($this->formTypeClass ?: $this->datatype->formTypeClass());
    }

    public function valueFormType()
    {
        return ($this->valueFormType ?: $this->datatype->valueFormType());
    }

    public function parameterFormType()
    {
        return ($this->parameterFormType ?: $this->datatype->parameterFormType());
    }

    public function formatFormType()
    {
        return ($this->formatFormType ?: $this->datatype->formatFormType());
    }

    public function isSpan()
    {
        return $this->span;
    }

    public function isSortable()
    {
        return $this->sortable;
    }

    public function isSearchable()
    {
        return $this->searchable;
    }

    public function hasMultipleValues()
    {
        return $this->multiple;
    }

    public function isAtomic()
    {
        return $this->formatName() === null && $this->parameterName() === null;
    }

    public function nullValue()
    {
        if ($this->hasMultipleValues()) {
            return [];
        }
        if ($this->isAtomic()) {
            return ($this->isSpan() ? [null, null] : null);
        }
        $data = [];
        if ($this->formatName()) {
            $data[$this->formatName()] = null;
        }
        if ($this->parameterName()) {
            $data[$this->parameterName()] = null;
        }
        if ($this->isSpan()) {
            return [null, null];
        }
        $data[$this->valueName()] = ($this->isSpan() ? [null, null] : null);
        return $data;
    }

    public function value($model, ArrayCollection $properties = null)
    {
        if ($model instanceof Fragment) {
            return $this->fragmentValue($model);
        }
        if (!$model instanceof ArrayCollection || $model->isEmpty()) {
            return $this->nullValue();
        }
        if ($this->hasMultipleValues()) {
            $data = [];
            foreach ($model as $fragment) {
                $data[] = $this->value($fragment);
            }
            return $data;
        }
        return $this->fragmentValue($model, $properties);
    }

    protected function fragmentValue($fragment, ArrayCollection $properties = null)
    {
        if ($fragment instanceof ArrayCollection) {
            return $this->serializeFragment($fragment->first(), $properties);
        }
        if ($fragment instanceof Fragment) {
            return $this->serializeFragment($fragment, $properties);
        }
        return null;
    }

    public function serialize($model, ArrayCollection $properties = null)
    {
        if ($model instanceof Fragment) {
            return $this->serializeFragment($model, $properties);
        }
        if (!$model instanceof ArrayCollection || $model->isEmpty()) {
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

    protected function serializeFragment(Fragment $fragment, ArrayCollection $properties = null)
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

    public function hydrate($data, Attribute $attribute, Vocabulary $vocabulary = null)
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

    protected function hydrateFragment($data, Fragment $fragment, Vocabulary $vocabulary = null)
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
        $format = ($this->formatName() ? $data[$this->formatName()] : null);
        $parameter = ($this->parameterName() ? $data[$this->parameterName()] : null);
        $value = ($this->valueName() ? $data[$this->valueName()] : null);
        if ($span) {
            $extent = ($this->valueName() ? $extent[$this->valueName()] : null);
            $fragment->setSpan($value, $extent, $parameter, $format);
        } else {
            $fragment->setValue($value, $parameter, $format);
        }
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_format');
        $builder->setReadOnly();
        $builder->setJoinedTableInheritance()->setDiscriminatorColumn('datatype', 'string', 30);
        $datatypes = Service::database()->getDatatypes();
        foreach ($datatypes as $datatype => $attributes) {
            $builder->addDiscriminatorMapClass($datatype, $attributes['model_class']);
        }

        // Key
        $builder->addStringKey('format', 30);

        // Attributes
        $builder->addStringField('entity', 100);
        $builder->addStringField('valueName', 30, 'value_name');
        $builder->addStringField('formatName', 30, 'format_name');
        $builder->addStringField('formatVocabulary', 30, 'format_vocabulary');
        $builder->addStringField('parameterName', 30, 'parameter_name');
        $builder->addStringField('parameterVocabulary', 30, 'parameter_vocabulary');
        $builder->addStringField('formTypeClass', 100, 'form_type_class');
        $builder->addStringField('valueFormType', 100, 'value_form_class');
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
        $builder->addManyToOneField('datatype', Datatype::class, 'datatype', 'datatype', false);
    }
}
