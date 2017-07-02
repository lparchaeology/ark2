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
use ARK\Model\Type;
use ARK\Model\Item;
use ARK\Model\VersionTrait;
use ARK\Model\Fragment\ObjectFragment;
use ARK\Service;

abstract class Fragment
{
    use VersionTrait;

    protected $fid = null;
    protected $module = '';
    protected $item = '';
    protected $attribute = '';
    protected $type = '';
    protected $format = '';
    protected $parameter = '';
    protected $value = null;
    protected $span = false;
    protected $extent = null;
    protected $object = null;

    public function __toString()
    {
        if ($this->span) {
            return '['.$this->value.' -> '.$this->extent.']';
        }
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

    public function setItem(Item $item)
    {
        $this->item = $item->id();
        $this->module = $item->schema()->module()->name();
    }

    public function attribute()
    {
        return $this->attribute;
    }

    public function type()
    {
        return $this->type;
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
        return $this->span;
    }

    public function extent()
    {
        return $this->extent;
    }

    public function setValue($value, $parameter = null, $format = null)
    {
        $this->value = $value;
        $this->span = false;
        $this->parameter = $parameter;
        $this->format = $format;
    }

    public function setSpan($value, $extent, $parameter = null, $format = null)
    {
        $this->value = $value;
        $this->span = true;
        $this->extent = $extent;
        $this->parameter = $parameter;
        $this->format = $format;
    }

    public function object()
    {
        return $this->object;
    }

    public function setObject(ObjectFragment $object)
    {
        $this->object = $object;
    }

    public static function create($module, $item, Attribute $attribute, ObjectFragment $object = null)
    {
        $class = $attribute->datatype()->type()->dataClass();
        $fragment = new $class;
        $fragment->module = $module;
        $fragment->item = $item;
        $fragment->attribute = $attribute->name();
        $fragment->type = $attribute->datatype()->type()->id();
        $fragment->object = $object;
        $fragment->refreshVersion();
        return $fragment;
    }

    public static function createFromAttribute(Attribute $attribute, ObjectFragment $object = null)
    {
        $class = $attribute->datatype()->type()->dataClass();
        $fragment = new $class;
        $fragment->attribute = $attribute->name();
        $fragment->type = $attribute->datatype()->type()->id();
        $fragment->span = $attribute->isSpan();
        $fragment->object = $object;
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
        $builder->addStringField('type', 30, 'type');
        $builder->addStringField('format', 30);
        $builder->addStringField('parameter', 30);
        $builder->addField('span', 'boolean');
        VersionTrait::buildVersionMetadata($builder);

        // Attributes
        $builder->addManyToOneField('object', ObjectFragment::class, 'object', 'fid', true);
    }

    public static function buildSubclassMetadata(ClassMetadata $metadata, $class)
    {
        $type = Service::database()->getFragmentType($class);
        $builder = new ClassMetadataBuilder($metadata, $type['data_table']);
        $builder->addGeneratedKey('fid');
        if ($type['storage_type'] == 'string') {
            $builder->addStringField('value', $type['storage_size']);
            $builder->addStringField('extent', $type['storage_size']);
        } else {
            $builder->addField('value', $type['storage_type']);
            $builder->addField('extent', $type['storage_type']);
        }
    }
}
