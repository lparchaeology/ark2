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
    protected $datatypeId = '';
    protected $datatype = null;
    protected $format = '';
    protected $parameter = '';
    protected $value = null;
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
        if (!$this->datatype) {
            $this->datatype = ORM::find(Datatype::class, $this->datatypeId);
        }
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

    public function isAtomic()
    {
        return !($this->format
                || $this->parameter
                || $this->datatype()->isObject()
                || $this->datatype()->formatRequired()
                || $this->datatype()->formatRequired());
    }

    public function setValue($value, $parameter = null, $format = null)
    {
        $this->value = $value;
        $this->parameter = $parameter;
        $this->format = $format;
    }

    public function parent()
    {
        return $this->parent;
    }

    public function toArray()
    {
        $array = [];
        if ($this->format || $this->datatype()->formatRequired()) {
            $array[$this->datatype()->formatName()] = $this->format;
        }
        if ($this->parameter || $this->datatype()->parameterRequired()) {
            $array[$this->datatype()->parameterName()] = $this->parameter;
        }
        $array[$this->datatype()->valueName()] = $this->value;
        return $array;
    }

    public function fromArray(array $array)
    {
        $format = $this->datatype()->formatName();
        $this->format = (isset($array[$format]) ? $array[$format] : null);
        $parameter = $this->datatype()->parameterName();
        $this->parameter = (isset($array[$parameter]) ? $array[$parameter] : null);
        $value = $this->datatype()->valueName();
        $this->format = (isset($array[$format]) ? $array[$format] : null);
    }

    public static function create($module, $item, Attribute $attribute, Fragment $parent = null)
    {
        $class = $attribute->format()->datatype()->modelClass();
        $fragment = new $class;
        $fragment->module = $module;
        $fragment->item = $item;
        $fragment->attribute = $attribute->name();
        $fragment->datatypeId = $attribute->datatype()->id();
        $fragment->parent = $parent;
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
        $builder->addStringField('datatypeId', 30, 'datatype');
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
        if ($datatype['doctrine'] == 'string') {
            $builder->addStringField('value', $datatype['size']);
        } else {
            $builder->addField('value', $datatype['doctrine']);
        }
    }
}
