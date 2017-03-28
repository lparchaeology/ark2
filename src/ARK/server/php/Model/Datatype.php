<?php

/**
 * ARK Model Datatype
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
use ARK\Vocabulary\Vocabulary;

class Datatype
{
    use EnabledTrait;
    use KeywordTrait;

    protected $datatype = '';
    protected $object = false;
    protected $compound = false;
    protected $storageType = '';
    protected $storageSize = 0;
    protected $valueName = null;
    protected $formatName = null;
    protected $formatVocabulary = null;
    protected $format = null;
    protected $parameterName = null;
    protected $parameterVocabulary = null;
    protected $parameter = null;
    protected $spanable = false;
    protected $modelTable = '';
    protected $modelClass = '';
    protected $dataTable = '';
    protected $dataClass = '';
    protected $formTypeClass = '';

    public function id()
    {
        return $this->datatype;
    }

    public function isObject()
    {
        return $this->object;
    }

    public function isCompound()
    {
        return $this->compound;
    }

    public function storageType()
    {
        return $this->storageType;
    }

    public function storageSize()
    {
        return $this->storageSize;
    }

    public function valueName()
    {
        return ($this->valueName ? $this->valueName : 'value');
    }

    public function formatName()
    {
        return $this->formatName;
    }

    public function formatVocabulary()
    {
        return $this->format;
    }

    public function parameterName()
    {
        return $this->parameterName;
    }

    public function parameterVocabulary()
    {
        return $this->parameter;
    }

    public function spanable()
    {
        return $this->spanable;
    }

    public function modelTable()
    {
        return $this->modelTable;
    }

    public function modelClass()
    {
        return $this->modelClass;
    }

    public function dataTable()
    {
        return $this->dataTable;
    }

    public function dataClass()
    {
        return $this->dataClass;
    }

    public function formTypeClass()
    {
        return $this->formTypeClass;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_datatype');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('datatype', 30);

        // Attributes
        $builder->addField('object', 'boolean');
        $builder->addField('compound', 'boolean');
        $builder->addStringField('storageType', 30, 'storage_type');
        $builder->addField('storageSize', 'integer', [], 'storage_size');
        $builder->addStringField('valueName', 30, 'value_name');
        $builder->addStringField('formatName', 30, 'format_name');
        $builder->addStringField('formatVocabulary', 30, 'format_vocabulary');
        $builder->addStringField('parameterName', 30, 'parameter_name');
        $builder->addStringField('parameterVocabulary', 30, 'parameter_vocabulary');
        $builder->addField('spanable', 'boolean');
        $builder->addStringField('modelTable', 50, 'model_table');
        $builder->addStringField('modelClass', 100, 'model_class');
        $builder->addStringField('dataTable', 50, 'data_table');
        $builder->addStringField('dataClass', 100, 'data_class');
        $builder->addStringField('formTypeClass', 100, 'form_type_class');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addManyToOneField('format', Vocabulary::class, 'format_vocabulary', 'concept');
        $builder->addManyToOneField('parameter', Vocabulary::class, 'parameter_vocabulary', 'concept');
    }
}
