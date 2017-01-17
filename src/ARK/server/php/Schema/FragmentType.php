<?php

/**
 * ARK Schema Fragment Type
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Schema;

use ARK\EnabledTrait;
use ARK\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class FragmentType
{
    use EnabledTrait;
    use KeywordTrait;

    protected $type = '';
    protected $compound = '';
    protected $formatClass = '';
    protected $modelClass = '';
    protected $formClass = '';
    protected $table = '';

    public function name()
    {
        return $this->type;
    }

    public function isCompound()
    {
        return $this->compound;
    }

    public function isAtomic()
    {
        return !$this->compound;
    }

    public function table()
    {
        return $this->table;
    }

    public function formatClass()
    {
        return $this->formatClass;
    }

    public function modelClass()
    {
        return $this->modelClass;
    }

    public function formClass()
    {
        return $this->formClass;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_fragment_type');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('type', 20);

        // Attributes
        $builder->addField('compound', 'boolean');
        $builder->addStringField('table', 50, 'tbl');
        $builder->addStringField('formatClass', 100, 'format_class');
        $builder->addStringField('modelClass', 100, 'model_class');
        $builder->addStringField('formClass', 100, 'form_class');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);
    }
}
