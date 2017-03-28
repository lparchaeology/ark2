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
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use Doctrine\Common\Collections\ArrayCollection;

abstract class Format
{
    use EnabledTrait;
    use KeywordTrait;

    protected $format = '';
    protected $datatype = null;
    protected $valueName = null;
    protected $formatName = null;
    protected $formatVocabulary = null;
    protected $parameterName = null;
    protected $parameterVocabulary = null;
    protected $formTypeClass = '';
    protected $input = '';
    protected $object = false;
    protected $array = false;
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

    public function input()
    {
        return $this->input;
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
        if ($this->isAtomic()) {
            return null;
        }
        if ($this->hasMultipleValues()) {
            return [];
        }
        $data = [];
        if ($this->formatName()) {
            $data[$this->formatName()] = null;
        }
        if ($this->parameterName()) {
            $data[$this->parameterName()] = null;
        }
        $data[$this->valueName()] = null;
        return $data;
    }

    public function serialize($model)
    {
        if ($model instanceof Fragment) {
            return $this->serializeFragment($model);
        }
        if (!$model instanceof ArrayCollection || $model->isEmpty()) {
            return $this->nullValue();
        }
        if ($this->hasMultipleValues()) {
            $data = [];
            foreach ($model as $fragment) {
                $data[] = $this->serializeFragment($fragment);
            }
            return $data;
        }
        return $this->serializeFragment($model->first());
    }

    protected function serializeFragment(Fragment $fragment)
    {
        if ($this->isAtomic()) {
            return $fragment->value();
        }
        $data = [];
        if ($this->formatName()) {
            $data[$this->formatName()] = $fragment->format();
        }
        if ($this->parameterName()) {
            $data[$this->parameterName()] = $fragment->parameter();
        }
        $data[$this->valueName()] = $fragment->value();
        return $data;
    }

    public function hydrate($data, $model, Vocabulary $vocabulary = null)
    {
        if ($model instanceof Fragment) {
            $this->hydrateFragment($data, $model);
            return;
        }
        if (!is_array($model) || $model = []) {
            return;
        }
        if ($data === [] || $data === null) {
            return;
        }
        if ($this->hasMultipleValues()) {
            for ($i = 0; $i < count($data); $i++) {
                $this->hydrateFragment($data[i], $fragments[i], $vocabulary);
            }
            return;
        }
        $data = (is_array($data) ? $data[0] : $data);
        $fragment = (is_array($fragments) ? $fragments[0] : $fragments);
        $this->dataToFragment($data, $fragment, $vocabulary);
    }

    protected function hydrateFragment($data, Fragment $fragment, Vocabulary $vocabulary = null)
    {
        if ($vocabulary instanceof Vocabulary) {
            $data = ($data instanceof Term ? $data->name() : $data);
            $fragment->setValue($data, $vocabulary->concept());
            return;
        }
        if ($this->isAtomic()) {
            $fragment->setValue($data);
            return;
        }
        $format = ($this->formatName() ? $data[$this->formatName()] : null);
        $parameter = ($this->parameterName() ? $data[$this->parameterName()] : null);
        $value = ($this->valueName() ? $data[$this->valueName()] : null);
        $fragment->setValue($value, $parameter, $format);
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
        $builder->addStringField('valueName', 30, 'value_name');
        $builder->addStringField('formatName', 30, 'format_name');
        $builder->addStringField('formatVocabulary', 30, 'format_vocabulary');
        $builder->addStringField('parameterName', 30, 'parameter_name');
        $builder->addStringField('parameterVocabulary', 30, 'parameter_vocabulary');
        $builder->addStringField('formTypeClass', 100, 'form_type_class');
        $builder->addStringField('input', 30);
        $builder->addField('object', 'boolean');
        $builder->addField('array', 'boolean');
        $builder->addField('multiple', 'boolean');
        $builder->addField('sortable', 'boolean');
        $builder->addField('searchable', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addManyToOneField('datatype', Datatype::class, 'datatype', 'datatype', false);
    }
}
