<?php

/**
 * ARK Model Schema Fragment
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
use ARK\ORM\ORM;
use ARK\Model\Attribute;
use ARK\Model\Datatype;
use ARK\Model\VersionTrait;
use ARK\Service;

abstract class Fragment
{
    use VersionTrait;

    protected $fid = null;
    protected $module = '';
    protected $item = '';
    protected $attribute = '';
    protected $datatype = '';
    protected $format = '';
    protected $parameter = '';
    protected $value = null;
    protected $span = null;
    protected $parent = null;

    public function __toString()
    {
        return $this->value;
    }

    public function id()
    {
        return $this->fid;
    }

    public function module()
    {
        return $this->module;
    }

    public function item()
    {
        return $this->item;
    }

    public function setItem($item)
    {
        $this->item = $item;
    }

    public function attribute()
    {
        return $this->attribute;
    }

    public function datatype()
    {
        return $this->datatype;
    }

    public function format()
    {
        return $this->format;
    }

    public function parameter()
    {
        return $this->parameter;
    }

    public function value()
    {
        return $this->value;
    }

    public function isSpan()
    {
        return $this->value !== null;
    }

    public function span()
    {
        return $this->span;
    }

    public function setValue($value, $parameter = null, $format = null)
    {
        $this->value = $value;
        $this->parameter = $parameter;
        $this->format = $format;
    }

    public function setSpan($fromValue, $toValue, $parameter = null, $format = null)
    {
        $this->value = $fromValue;
        $this->value = $toValue;
        $this->parameter = $parameter;
        $this->format = $format;
    }

    public function parent()
    {
        return $this->parent;
    }

    public static function create($module, $item, Attribute $attribute, Fragment $parent = null)
    {
        $class = $attribute->format()->datatype()->dataClass();
        $fragment = new $class;
        $fragment->module = $module;
        $fragment->item = $item;
        $fragment->attribute = $attribute->name();
        $fragment->datatype = $attribute->format()->datatype()->id();
        if ($parent) {
            $fragment->parent = $parent->id();
        }
        $fragment->refreshVersion();
        return $fragment;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setMappedSuperclass();

        // Attributes
        $builder->addStringField('module', 30);
        $builder->addStringField('item', 30);
        $builder->addStringField('attribute', 30);
        $builder->addStringField('datatype', 30, 'datatype');
        $builder->addStringField('format', 30);
        $builder->addStringField('parameter', 30);
        $builder->addField('parent', 'integer', [], 'object_fid');
        VersionTrait::buildVersionMetadata($builder);
    }

    public static function buildSubclassMetadata(ClassMetadata $metadata, $class)
    {
        $datatype = Service::database()->getFragmentDatatype($class);
        $builder = new ClassMetadataBuilder($metadata, $datatype['data_table']);
        $builder->addGeneratedKey('fid');
        if ($datatype['storage_type'] == 'string') {
            $builder->addStringField('value', $datatype['storage_size']);
            $builder->addStringField('span', $datatype['storage_size']);
        } else {
            $builder->addField('value', $datatype['storage_type']);
            $builder->addField('span', $datatype['storage_type']);
        }
    }
}
