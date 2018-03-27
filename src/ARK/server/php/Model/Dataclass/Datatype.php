<?php

/**
 * ARK Model Type.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Model\Dataclass;

use ARK\Model\EnabledTrait;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Vocabulary\Concept;
use DateTime;

class Datatype
{
    use EnabledTrait;
    use KeywordTrait;

    protected $datatype = '';
    protected $numeric = false;
    protected $temporal = false;
    protected $structure = false;
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

    public function isStructure() : bool
    {
        return $this->structure;
    }

    public function isCompound() : bool
    {
        return $this->compound;
    }

    public function cast($value)
    {
        if ($this->numeric) {
            if ($this->storageType === 'integer') {
                return (int) $value;
            }
            return (float) $value;
        }
        if ($this->temporal) {
            return DateTime($value);
        }
        if ($this->compound || $this->structure) {
            return $value;
        }
        if ($this->storageType === 'boolean') {
            return (bool) $value;
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

    public function formatVocabulary() : ?Concept
    {
        return $this->format;
    }

    public function parameterName() : ?string
    {
        return $this->parameterName;
    }

    public function parameterVocabulary() : ?Concept
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
        $builder->addMappedField('number', 'numeric', 'boolean');
        $builder->addField('temporal', 'boolean');
        $builder->addField('structure', 'boolean');
        $builder->addField('compound', 'boolean');
        $builder->addMappedStringField('storage_type', 'storageType', 30);
        $builder->addMappedField('storage_size', 'storageSize', 'integer');
        $builder->addMappedStringField('value_name', 'valueName', 30);
        $builder->addMappedStringField('format_name', 'formatName', 30);
        $builder->addMappedStringField('format_vocabulary', 'formatVocabulary', 30);
        $builder->addMappedStringField('parameter_name', 'parameterName', 30);
        $builder->addMappedStringField('parameter_vocabulary', 'parameterVocabulary', 30);
        $builder->addField('spanable', 'boolean');
        $builder->addMappedStringField('model_table', 'modelTable', 50);
        $builder->addMappedStringField('model_entity', 'modelEntity', 100);
        $builder->addMappedStringField('data_table', 'dataTable', 50);
        $builder->addMappedStringField('data_entity', 'dataEntity', 100);
        $builder->addMappedStringField('form_type', 'formType', 100);
        $builder->addMappedStringField('active_form_type', 'activeFormType', 100);
        $builder->addMappedStringField('readonly_form_type', 'readonlyFormType', 100);
        $builder->addMappedStringField('static_form_type', 'staticFormType', 100);
        $builder->addMappedStringField('format_form_type', 'formatFormType', 100);
        $builder->addMappedStringField('parameter_form_type', 'parameterFormType', 100);
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addVocabularyField('format_vocabulary', 'format');
        $builder->addVocabularyField('parameter_vocabulary', 'parameter');
    }
}
