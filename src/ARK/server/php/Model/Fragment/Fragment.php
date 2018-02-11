<?php

/**
 * ARK Model Schema Fragment.
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

namespace ARK\Model\Fragment;

use ARK\Model\Attribute;
use ARK\Model\Item;
use ARK\Model\Schema\Module;
use ARK\Model\VersionTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Security\Actor;
use ARK\Service;
use DateTime;

abstract class Fragment
{
    use VersionTrait;

    protected $fid;
    protected $module = '';
    protected $moduleObject;
    protected $item = '';
    protected $owner;
    protected $attribute = '';
    protected $datatype = '';
    protected $format = '';
    protected $parameter = '';
    protected $value;
    protected $span = false;
    protected $extent;
    protected $object;

    public function __toString() : string
    {
        if ($this->span) {
            return '['.$this->value.' -> '.$this->extent.']';
        }
        return $this->value;
    }

    public function id() : int
    {
        return $this->fid;
    }

    public function module() : string
    {
        return $this->module;
    }

    public function item() : string
    {
        return $this->item;
    }

    public function setItem(Item $item) : void
    {
        $this->item = $item->id();
        $this->module = $item->schema()->module()->id();
    }

    public function owner() : ?Item
    {
        if ($this->moduleObject === null) {
            $this->moduleObject = ORM::find(Module::class, $this->module);
        }
        if ($this->owner === null) {
            $this->owner = ORM::find($this->moduleObject->classname(), $this->item);
        }
        return $this->owner;
    }

    public function attribute() : string
    {
        return $this->attribute;
    }

    public function datatype() : string
    {
        return $this->datatype;
    }

    public function format() : ?string
    {
        return $this->format;
    }

    public function parameter() : ?string
    {
        return $this->parameter;
    }

    public function value()
    {
        return $this->value;
    }

    public function isSpan() : bool
    {
        return $this->span;
    }

    public function extent()
    {
        return $this->extent;
    }

    public function setValue($value, $parameter = null, $format = null) : void
    {
        $this->value = $value;
        $this->span = false;
        $this->parameter = $parameter;
        $this->format = $format;
    }

    public function setSpan($value, $extent, $parameter = null, $format = null) : void
    {
        $this->value = $value;
        $this->span = true;
        $this->extent = $extent;
        $this->parameter = $parameter;
        $this->format = $format;
    }

    public function object() : ?ObjectFragment
    {
        return $this->object;
    }

    public function setObject(ObjectFragment $object) : void
    {
        $this->object = $object;
    }

    public function update(Item $item = null) : void
    {
        if ($item) {
            $this->setItem($item);
        }
    }

    public function delete() : void
    {
    }

    public static function create(string $module, string $item, Attribute $attribute, Actor $creator, DateTime $created, ObjectFragment $object = null) : self
    {
        $class = $attribute->dataclass()->datatype()->dataEntity();
        $fragment = new $class();
        $fragment->module = $module;
        $fragment->item = $item;
        $fragment->attribute = $attribute->name();
        $fragment->datatype = $attribute->dataclass()->datatype()->id();
        $fragment->object = $object;
        $fragment->refreshVersion($creator, $created);
        return $fragment;
    }

    public static function createFromAttribute(Attribute $attribute, Actor $creator, DateTime $created, ObjectFragment $object = null) : self
    {
        $class = $attribute->dataclass()->datatype()->dataEntity();
        $fragment = new $class();
        $fragment->attribute = $attribute->name();
        $fragment->datatype = $attribute->dataclass()->datatype()->id();
        $fragment->span = $attribute->isSpan();
        $fragment->object = $object;
        $fragment->refreshVersion($creator, $created);
        return $fragment;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setMappedSuperclass();

        // Attributes
        $builder->addStringField('module', 30);
        $builder->addStringField('item', 30);
        $builder->addStringField('attribute', 30);
        $builder->addStringField('datatype', 30);
        $builder->addStringField('format', 30);
        $builder->addStringField('parameter', 30);
        $builder->addField('span', 'boolean');
        VersionTrait::buildVersionMetadata($builder);

        // Attributes
        $builder->addManyToOneField('object', ObjectFragment::class, 'object', 'fid');
    }

    public static function buildSubclassMetadata(ClassMetadata $metadata, string $class) : void
    {
        $datatype = Service::database()->getFragmentDatatype($class);
        if (!$datatype || !$datatype['enabled']) {
            return;
        }
        $builder = new ClassMetadataBuilder($metadata, $datatype['data_table']);
        $builder->addGeneratedKey('fid');
        if ($datatype['storage_type'] === 'string') {
            $builder->addStringField('value', $datatype['storage_size']);
            $builder->addStringField('extent', $datatype['storage_size']);
        } else {
            $builder->addField('value', $datatype['storage_type']);
            $builder->addField('extent', $datatype['storage_type']);
        }
    }
}
