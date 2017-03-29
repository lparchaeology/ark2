<?php

/**
 * ARK Model Property
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

use ARK\Model\Attribute;
use ARK\Model\Fragment;
use ARK\Model\Item;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;

// TODO Think about extending from Attribute??? Or move serializing *into* attribute/format? Or separate serializers?
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
        $this->fragments = ORM::findBy($attribute->format()->datatype()->dataClass(), $key);
        if (!$attribute->format()->datatype()->isObject()) {
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

    public function properties()
    {
        return $this->children;
    }

    public function nullValue()
    {
        return $this->attribute->nullValue();
    }

    // TODO Look into returning 'natural' objects instead, offer serialize separately
    public function value()
    {
        return $this->attribute->serialize($this->fragments);
    }

    public function setValue($value)
    {
        dump('setValue '.$this->name());
        dump($value);
        dump('before');
        dump($this->fragments);
        // TODO Nasty Hack! Better to track the fid and update the right frag object to keep history!
        // OTOH is more efficient look-ups if in block together, and simpler update code
        if (!$this->fragments->isEmpty()) {
            ORM::remove($this->fragments);
            $this->fragments->clear();
        }
        $model = $this->attribute->hydrate($value);
        dump('model');
        dump($model);
        $this->fragments = new ArrayCollection(is_array($model) ? $model : [$model]);
        if (!$this->fragments->isEmpty()) {
            $this->updateFragments();
            dump($this->fragments);
            ORM::persist($this->fragments);
            $this->updateItem();
        }
        dump('after');
        dump($this->fragments);
    }

    // TODO Is there a better way?
    protected function updateItem()
    {
        if ($this->item->schema()->typeName() == $this->name()) {
            $this->item->setType($this->fragments->get(0)->value());
        }
        $this->item->refreshVersion();
    }

    // TODO Is there a better way?
    public function updateFragments()
    {
        foreach ($this->fragments as $fragment) {
            $fragment->setItem($this->item);
        }
    }
}
