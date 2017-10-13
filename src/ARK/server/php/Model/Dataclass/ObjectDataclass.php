<?php

/**
 * ARK Model Object Dataclass.
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

namespace ARK\Model\Dataclass;

use ARK\Actor\Actor;
use ARK\Model\Attribute;
use ARK\Model\Fragment\Fragment;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Vocabulary\Vocabulary;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\Type;

class ObjectDataclass extends Dataclass
{
    protected $attributes;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    public function constraints() : iterable
    {
        $constraints = parent::constraints();
        if ($this->entity) {
            $constraints[] = new Type($this->entity);
        }
        return $constraints;
    }

    public function attributes() : iterable
    {
        return $this->attributes;
    }

    public function attribute(string $name) : ?Attribute
    {
        foreach ($this->attributes as $attribute) {
            if ($attribute->name() === $name) {
                return $attribute;
            }
        }
        return null;
    }

    public function emptyValue()
    {
        foreach ($this->attributes as $attribute) {
            $data[$attribute->name()] = $attribute->dataclass()->emptyValue();
        }
        ksort($data);
        return $data;
    }

    public function hydrate(
        $data,
        Attribute $attribute,
        Actor $creator,
        DateTime $created,
        Vocabulary $vocabulary = null
    ) : Collection {
        $fragments = new ArrayCollection();
        if ($data === [] || $data === null) {
            return $fragments;
        }
        if (!$this->hasMultipleValues()) {
            $data = [$data];
        }
        foreach ($data as $datum) {
            $fragment = Fragment::createFromAttribute($attribute, $creator, $created);
            $fragment->setValue('');
            $fragments->add($fragment);
            if ($this->entity && $datum instanceof $this->entity) {
                $datum = $this->entity::toArray($datum);
            }
            if (!is_array($datum)) {
                return [];
            }
            foreach ($datum as $key => $value) {
                $children = $this->attribute($key)->hydrate($value, $creator, $created);
                foreach ($children as $child) {
                    $child->setObject($fragment);
                    $fragments->add($child);
                }
            }
        }
        return $fragments;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_dataclass_object');

        // Associations
        $builder->addOneToManyField('attributes', DataclassAttribute::class, 'parent', null, null, ['sequence' => 'ASC']);
    }

    protected function fragmentValue($fragment, Collection $properties = null)
    {
        if ($properties === null || $properties->isEmpty() || !$fragment instanceof Fragment) {
            return null;
        }
        $data = [];
        foreach ($this->attributes as $attribute) {
            $data[$attribute->name()] = $properties->get($attribute->name())->value();
        }
        if ($this->entity) {
            $data = $this->entity::fromArray($data);
        }
        if ($data === $this->emptyValue()) {
            return null;
        }
        return $data;
    }

    protected function serializeFragment(Fragment $fragment, Collection $properties = null)
    {
        if ($this->dataclass === 'dating') {
            $this->crash();
        }
        if ($properties === null || $properties->isEmpty()) {
            return null;
        }
        $data = [];
        foreach ($this->attributes as $attribute) {
            if ($property = $properties->get($attribute->name())) {
                $data[$attribute->name()] = $property->serialize();
            } else {
                $data[$attribute->name()] = null;
            }
        }
        return $data;
    }

    protected function hydrateFragment($data, Fragment $fragment, Vocabulary $vocabulary = null) : void
    {
    }
}
