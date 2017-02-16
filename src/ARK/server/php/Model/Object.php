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
class Object
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
                $this->children[] = new Property($item, $child, $fragment);
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

    public function children()
    {
        return $this->children;
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
            $fragment->setItem($this->item->id());
        }
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

    protected function setFragmentValue(Fragment $fragment, $value)
    {
        $val = null;
        $parm = null;
        if ($this->attribute->format()->hasAttributes()) {
            foreach ($this->attribute->format()->attributes() as $attribute) {
                if ($attribute->isRoot()) {
                    $val = $value[$attribute->name()];
                } else {
                    $parm = $value[$attribute->name()];
                }
            }
        } else {
            $val = $value;
            if ($this->attribute->vocabulary()) {
                $parm = $this->attribute->vocabulary()->concept();
            }
        }
        if ($val) {
            $fragment->setValue($val, $parm);
            ORM::persist($fragment);
        } else {
            ORM::remove($fragment);
            $this->fragments->remove($this->fragments->indexOf($fragment));
        }
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
        if ($this->attribute->format()->isAtomic()) {
            // TODO Come up with a proper default strategy!!!
            $type = $this->attribute->format()->datatype()->id();
            if (in_array($type, ['date', 'time', 'datetime'])) {
                return new \DateTime;
            }
            return null;
        }
        $value = [];
        foreach ($this->attribute->format()->attributes() as $attribute) {
            // TODO Come up with a proper default strategy!!!
            if ($attribute->hasVocabulary() && $attribute->vocabulary()->concept() == 'language') {
                $value[$attribute->name()] = Service::locale();
            } else {
                $value[$attribute->name()] = null;
            }
        }
        return $this->attribute->hasMultipleOccurrences() || $this->attribute->format()->serializeAsObject()? [$value] : $value;
    }

    public function value()
    {
        if ($this->fragments->isEmpty()) {
            return $this->nullValue();
        }
        if ($this->attribute->hasMultipleOccurrences()) {
            $values = [];
            foreach ($this->fragments as $fragment) {
                $values[] = $this->attribute->format()->datatype()->isObject()
                            ? $values[] = $this->objectValue($fragment)
                            : $this->fragmentValue($fragment);
            }
            return $values;
        }
        if ($this->attribute->format()->datatype()->isObject()) {
            return $this->objectValue($this->children[$this->fragments->get(0)]);
        }
        if ($this->attribute->format()->serializeAsObject()) {
            $values = [];
            foreach ($this->fragments as $fragment) {
                $values[] = $this->fragmentValue($fragment);
            }
            return $values;
        }
        return $this->fragmentValue($this->fragments->get(0));
    }

    protected function addFragment()
    {
        $fragment = Fragment::create($this->item->schema()->module()->name(), $this->item->id(), $this->attribute);
        $this->fragments->add($fragment);
        return $fragment;
    }

    public function setValue($value)
    {
        // TODO Compound types
        if (!$this->attribute->format()->datatype()->isObject()) {
            // TODO Nasty Hack! Better to track the fid and update the right frag object!
            if ($this->attribute->hasMultipleOccurrences() || $this->attribute->format()->serializeAsObject()) {
                if (!$this->fragments->isEmpty()) {
                    ORM::remove($this->fragments);
                    $this->fragments->clear();
                }
                foreach ($value as $item) {
                    $this->setFragmentValue($this->addFragment(), $item);
                }
            } else {
                if ($this->fragments->isEmpty()) {
                    $fragment = $this->addFragment();
                } else {
                    $fragment = $this->fragments->get(0);
                }
                $this->setFragmentValue($fragment, $value);
            }
        }
        $this->updateItem();
    }

    public function keyValue()
    {
        return [$this->name() => $this->value()];
    }

    public function setKeyValue($keyValue)
    {
        if (count($keyValue) === 1 && isset($keyValue[$this->name()])) {
            $this->setValue($keyValue[$this->name()]);
        }
    }
}
