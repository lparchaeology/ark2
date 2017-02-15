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

class Datatype
{
    use EnabledTrait;
    use KeywordTrait;

    protected $datatype = '';
    protected $compound = false;
    protected $formatName = '';
    protected $formatRequired = false;
    protected $parameterName = '';
    protected $parameterRequired = false;
    protected $valueName = '';
    protected $modelTable = '';
    protected $modelClass = '';
    protected $dataTable = '';
    protected $dataClass = '';
    protected $formClass = '';

    public function id()
    {
        return $this->type;
    }

    public function isCompound()
    {
        return $this->compound;
    }

    public function formatName()
    {
        return ($this->formatName ? $this->formatName : 'format');
    }

    public function formatRequired()
    {
        return $this->formatRequired;
    }

    public function parameterName()
    {
        return ($this->parameterName ? $this->parameterName : 'parameter');
    }

    public function parameterRequired()
    {
        return $this->parameterRequired;
    }

    public function valueName()
    {
        return ($this->value ? $this->value : 'value');
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

    public function formClass()
    {
        return $this->formClass;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_datatype');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('datatype', 30);

        // Attributes
        $builder->addField('compound', 'boolean');
        $builder->addStringField('formatName', 30, 'format_name');
        $builder->addField('formatRequired', 'boolean');
        $builder->addStringField('parameterName', 30, 'parameter_name');
        $builder->addField('parameterRequired', 'boolean');
        $builder->addStringField('valueName', 30, 'value_name');
        $builder->addField('valueRequired', 'boolean');
        $builder->addStringField('modelTable', 50, 'model_table');
        $builder->addStringField('modelClass', 100, 'model_class');
        $builder->addStringField('dataTable', 50, 'data_table');
        $builder->addStringField('dataClass', 100, 'data_class');
        $builder->addStringField('formClass', 100, 'form_class');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);
    }
}
