<?php

/**
 * ARK Schema Property
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

namespace ARK\Model;

use ARK\Model\Item;
use ARK\Schema\Attribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use Doctrine\Common\Collections\ArrayCollection;

class Property
{
    protected $item = null;
    protected $attribute = null;
    protected $fragments = null;
    protected $parent = null;
    protected $children = [];

    public function __construct(Item $item, Attribute $attribute, Fragment $parent = null)
    {
        $this->item = $item;
        $this->attribute = $attribute;
        $this->parent = $parent;
        $key = [
           'module' => $item->schema()->module()->name(),
           'item' => $item->id(),
           'attribute' => $attribute->name(),
        ];
        if ($parent) {
            $key['parent'] = $parent->id();
        }
        $this->fragments = ORM::findBy($attribute->format()->type()->modelClass(), $key);
        if ($attribute->format()->type()->isAtomic()) {
            return;
        }
        foreach ($this->fragments as $fragment) {
            foreach ($attribute->format()->attributes() as $child) {
                $this->children[$fragment->id()] = new Property($item, $child, $fragment);
            }
        }
    }

    public function name()
    {
        return $this->attribute->name();
    }

    public function item()
    {
        return $this->item;
    }

    public function attribute()
    {
        return $this->attribute;
    }

    public function fragments()
    {
        return $this->fragments;
    }

    public function isAtomicValue()
    {
        return !$this->isCompoundValue();
    }

    public function isCompoundValue()
    {
        return $this->attribute->format()->hasAttributes() || $this->attribute->hasMultipleOccurrences();
    }

    protected function fragmentValue(Fragment $fragment)
    {
        if ($this->attribute->format()->hasAttributes()) {
            $value = [];
            foreach ($this->attribute->format()->attributes() as $attribute) {
                $value[$attribute->name()] = ($attribute->isRoot() ? $fragment->value() : $fragment->parameter());
            }
            return $value;
        }
        return $fragment->value();
    }

    protected function objectValue(Fragment $fragment)
    {
        $values = [];
        foreach ($this->children[$fragment->id()] as $child) {
            $values[$child->name()] = $child->value();
        }
        return $values;
    }

    protected function nullValue()
    {
        if ($this->attribute->format()->type()->isAtomic() && !$this->attribute->format()->hasAttributes()) {
            return null;
        }
        $value = [];
        foreach ($this->attribute->format()->attributes() as $attribute) {
            $value[$attribute->name()] = null;
        }
        return $this->attribute->hasMultipleOccurrences() ? [$value] : $value;
    }

    public function value()
    {
        if (!$this->fragments) {
            return $this->nullValue();
        }
        if ($this->attribute->hasMultipleOccurrences()) {
            $values = [];
            foreach ($this->fragments as $fragment) {
                $values[] = $this->attribute->format()->type()->isAtomic()
                            ? $this->fragmentValue($fragment)
                            : $values[] = $this->objectValue($fragment);
            }
            return $values;
        }
        return $this->attribute->format()->type()->isAtomic()
                ? $this->fragmentValue($this->fragments[0])
                : $this->objectValue($this->children[$this->fragments[0]]);
    }

    public function keyValue()
    {
        return [$this->name() => $this->value()];
    }
}
