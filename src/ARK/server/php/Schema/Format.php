<?php

/**
 * ARK Schema Format
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
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

abstract class Format
{
    use EnabledTrait;
    use KeywordTrait;

    protected $format = '';
    protected $type = null;
    protected $input = '';
    protected $object = false;
    protected $array = false;
    protected $sortable = false;
    protected $searchable = false;

    public function name()
    {
        return $this->format;
    }

    public function type()
    {
        return $this->type;
    }

    public function input()
    {
        return $this->input;
    }

    public function hasProperties()
    {
        return $this->object || $this->array;
    }

    protected function isObject()
    {
        return $this->object;
    }

    protected function isArray()
    {
        return $this->array;
    }

    public function isSortable()
    {
        return $this->sortable;
    }

    public function isSearchable()
    {
        return $this->searchable;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_format');
        $builder->addStringKey('format', 30);
        $builder->addManyToOneField('type', 'FragmentType', 'type', 'type', false);
        $builder->addStringField('input', 30);
        $builder->addField('object', 'boolean');
        $builder->addField('array', 'boolean');
        $builder->addField('sortable', 'boolean');
        $builder->addField('searchable', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->setJoinedTableInheritance()->setDiscriminatorColumn('type', 'string', 10);
        $builder->addDiscriminatorMapClass('blob', 'BlobFormat');
        $builder->addDiscriminatorMapClass('boolean', 'BooleanFormat');
        $builder->addDiscriminatorMapClass('date', 'DateFormat');
        $builder->addDiscriminatorMapClass('datetime', 'DateTimeFormat');
        $builder->addDiscriminatorMapClass('decimal', 'DecimalFormat');
        $builder->addDiscriminatorMapClass('float', 'FloatFormat');
        $builder->addDiscriminatorMapClass('geometry', 'GeometryFormat');
        $builder->addDiscriminatorMapClass('integer', 'IntegerFormat');
        $builder->addDiscriminatorMapClass('item', 'ItemFormat');
        $builder->addDiscriminatorMapClass('object', 'ObjectFormat');
        $builder->addDiscriminatorMapClass('string', 'StringFormat');
        $builder->addDiscriminatorMapClass('text', 'TextFormat');
        $builder->addDiscriminatorMapClass('time', 'TimeFormat');
        $builder->setReadOnly();
    }
}
