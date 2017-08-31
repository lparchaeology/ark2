<?php

/**
 * ARK Model Type.
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
use DateTime;

class Datatype
{
    use EnabledTrait;
    use KeywordTrait;

    protected $datatype = '';
    protected $numeric = false;
    protected $temporal = false;
    protected $object = false;
    protected $compound = false;
    protected $storageType = '';
    protected $storageSize = 0;
    protected $valueName;
    protected $formatName;
    protected $formatVocabulary;
    protected $format;
    protected $parameterName;
    protected $parameterVocabulary;
    protected $parameter;
    protected $spanable = false;
    protected $modelTable = '';
    protected $modelEntity = '';
    protected $dataTable = '';
    protected $dataEntity = '';
    protected $formType = '';
    protected $activeFormType = '';
    protected $readonlyFormType = '';
    protected $staticFormType = '';
    protected $formatFormType = '';
    protected $parameterFormType = '';

    public function id() : string
    {
        return $this->datatype;
    }

    public function isNumeric() : bool
    {
        return $this->numeric;
    }

    public function isTemporal() : bool
    {
        return $this->temporal;
    }

    public function isObject() : bool
    {
        return $this->object;
    }

    public function isCompound() : bool
    {
        return $this->compound;
    }

    public function cast($value)
    {
        if ($this->number) {
            if ($this->storageType === 'integer') {
                return (int) $value;
            }
            return (float) $value;
        }
        if ($this->temporal) {
            return DateTime($value);
        }
        if ($this->compound || $this->object) {
            return $value;
        }
        return (string) $value;
    }

    public function storageType() : string
    {
        return $this->storageType;
    }

    public function storageSize() : ?int
    {
        return $this->storageSize;
    }

    public function valueName() : string
    {
        return $this->valueName ?? 'value';
    }

    public function formatName() : ?string
    {
        return $this->formatName;
    }

    public function formatVocabulary() : ?Vocabulary
    {
        return $this->format;
    }

    public function parameterName() : ?string
    {
        return $this->parameterName;
    }

    public function parameterVocabulary() : ?Vocabulary
    {
        return $this->parameter;
    }

    public function spanable() : bool
    {
        return $this->spanable;
    }

    public function modelTable() : string
    {
        return $this->modelTable;
    }

    public function modelEntity() : string
    {
        return $this->modelEntity;
    }

    public function dataTable() : string
    {
        return $this->dataTable;
    }

    public function dataEntity() : string
    {
        return $this->dataEntity;
    }

    public function formType() : ?string
    {
        return $this->formType;
    }

    public function activeFormType() : ?string
    {
        return $this->activeFormType;
    }

    public function readonlyFormType() : ?string
    {
        return $this->readonlyFormType;
    }

    public function staticFormType() : ?string
    {
        return $this->staticFormType;
    }

    public function formatFormType() : ?string
    {
        return $this->formatFormType;
    }

    public function parameterFormType() : ?string
    {
        return $this->parameterFormType;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_dataclass_type');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('datatype', 30);

        // Attributes
        $builder->addField('numeric', 'boolean', [], 'number');
        $builder->addField('temporal', 'boolean');
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
        $builder->addStringField('modelEntity', 100, 'model_entity');
        $builder->addStringField('dataTable', 50, 'data_table');
        $builder->addStringField('dataEntity', 100, 'data_entity');
        $builder->addStringField('formType', 100, 'form_type');
        $builder->addStringField('activeFormType', 100, 'active_form_type');
        $builder->addStringField('readonlyFormType', 100, 'readonly_form_type');
        $builder->addStringField('staticFormType', 100, 'static_form_type');
        $builder->addStringField('formatFormType', 100, 'format_form_type');
        $builder->addStringField('parameterFormType', 100, 'parameter_form_type');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addManyToOneField('format', Vocabulary::class, 'format_vocabulary', 'concept');
        $builder->addManyToOneField('parameter', Vocabulary::class, 'parameter_vocabulary', 'concept');
    }
}
