<?php

/**
 * ARK Model Property.
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

namespace ARK\Model;

use ARK\ORM\ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

// TODO Think about extending from Attribute??? Or move serializing *into* attribute/dataclass? Or separate serializers?
class Property
{
    protected $item;
    protected $attribute;
    protected $fragments;
    protected $parent;
    protected $children;

    public function __construct(Item $item, Attribute $attribute, Fragment $parent = null)
    {
        $this->item = $item;
        $this->attribute = $attribute;
        $this->parent = $parent;
        $this->children = new ArrayCollection();
        $key = [
           'module' => $item->schema()->module()->id(),
           'item' => $item->id(),
           'attribute' => $attribute->name(),
        ];
        if ($parent) {
            $key['object'] = $parent->id();
        }
        $this->fragments = ORM::findBy($attribute->dataclass()->datatype()->dataEntity(), $key);
        if (!$attribute->dataclass()->datatype()->isObject()) {
            return;
        }
        foreach ($this->fragments as $fragment) {
            $properties = new ArrayCollection();
            foreach ($attribute->dataclass()->attributes() as $child) {
                $properties->set($child->name(), new self($item, $child, $fragment));
            }
            $this->children->set($fragment->id(), $properties);
        }
    }

    public function name() : string
    {
        return $this->attribute->name();
    }

    public function item() : Item
    {
        return $this->item;
    }

    public function attribute() : Attribute
    {
        return $this->attribute;
    }

    public function fragments() : Collection
    {
        return $this->fragments;
    }

    public function properties() : Collection
    {
        return $this->children;
    }

    public function emptyValue()
    {
        return $this->attribute->emptyValue();
    }

    public function value()
    {
        return $this->attribute->value($this->fragments, $this->children);
    }

    public function serialize()
    {
        return $this->attribute->serialize($this->fragments, $this->children);
    }

    public function setValue($value) : void
    {
        // TODO Nasty Hack! Better to track the fid and update the right frag object to keep history!
        // OTOH is more efficient look-ups if in block together, and simpler update code
        if (!$this->fragments->isEmpty()) {
            ORM::remove($this->fragments);
            $this->fragments->clear();
        }
        $this->fragments = $this->attribute->hydrate($value);
        if ($this->fragments->isEmpty()) {
            return;
        }
        $this->updateFragments();
        ORM::persist($this->fragments);
        $this->updateItem();
    }

    // TODO Is there a better way?
    public function updateFragments() : void
    {
        foreach ($this->fragments as $fragment) {
            $fragment->setItem($this->item);
        }
    }

    // TODO Is there a better way?
    protected function updateItem() : void
    {
        if ($this->name() === $this->item->schema()->classProperty()) {
            $this->item->setClass($this->fragments->get(0)->value());
        }
        $this->item->refreshVersion();
    }
}
