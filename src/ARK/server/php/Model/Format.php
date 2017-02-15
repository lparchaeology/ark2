<?php

/**
 * ARK Model Schema Format
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
use Doctrine\Common\Collections\ArrayCollection;

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
    protected $attributes = null;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    public function id()
    {
        return $this->format;
    }

    public function datatype()
    {
        return $this->datatype;
    }

    public function isCompound()
    {
        return $this->hasAttributes() || $this->datatype->isCompound();
    }

    public function input()
    {
        return $this->input;
    }

    public function hasAttributes()
    {
        return !$this->attributes->isEmpty();
    }

    public function attributes()
    {
        return $this->attributes;
    }

    public function attribute($name)
    {
        foreach ($this->attributes as $attribute) {
            if ($attribute->name() == $name) {
                return $attribute;
            }
        }
        return null;
    }

    public function serializeAsObject()
    {
        return $this->object;
    }

    public function serializeAsArray()
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
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_format');
        $builder->setReadOnly();
        $builder->setJoinedTableInheritance()->setDiscriminatorColumn('datatype', 'string', 30);
        // TODO Build from ark_datatype?
        $datatypes = Database::getDatatypes();
        foreach ($datatypes as $datatype => $attributes) {
            $builder->addDiscriminatorMapClass($datatype, $attributes['model_class']);
        }

        // Key
        $builder->addStringKey('format', 30);

        // Attributes
        $builder->addStringField('input', 30);
        $builder->addField('object', 'boolean');
        $builder->addField('array', 'boolean');
        $builder->addField('sortable', 'boolean');
        $builder->addField('searchable', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addManyToOneField('datatype', 'ARK\Model\Datatype', 'datatype', 'datatype', false);
        $builder->addOneToMany('attributes', 'ARK\Model\Format\FormatAttribute', 'parent');
    }
}
