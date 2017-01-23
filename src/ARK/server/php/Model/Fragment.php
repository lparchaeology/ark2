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
use ARK\Model\VersionTrait;
use ARK\Model\Fragment\BlobFragment;
use ARK\Model\Attribute;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;

abstract class Fragment
{
    use VersionTrait;

    protected $fid = null;
    protected $module = '';
    protected $item = '';
    protected $attribute = '';
    protected $parameter = null;
    protected $value = null;
    protected $parent = null;

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

    public function attribute()
    {
        return $this->attribute;
    }

    public function parameter()
    {
        return $this->parameter;
    }

    public function value()
    {
        return $this->value;
    }

    public function setValue($value, $parameter = null)
    {
        $this->value = $value;
        $this->parameter = $parameter;
    }

    public function parent()
    {
        return $this->parent;
    }

    public static function create($module, $item, Attribute $attribute, Fragment $parent = null)
    {
        $class = $attribute->format()->type()->modelClass();
        $fragment = new $class;
        $fragment->module = $module;
        $fragment->item = $item;
        $fragment->attribute = $attribute->name();
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
        $builder->addStringField('parameter', 30);
        $builder->addField('parent', 'integer', [], 'object_fid');
        VersionTrait::buildVersionMetadata($builder);
    }
}
