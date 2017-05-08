<?php

/**
 * ARK Model Object Format
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

namespace ARK\Model\Format;

use ARK\Model\Format;
use ARK\Model\Format\FormatAttribute;
use ARK\Model\Fragment;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Vocabulary\Vocabulary;
use Doctrine\Common\Collections\ArrayCollection;

class ObjectFormat extends Format
{
    protected $attributes = null;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
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

    public function nullValue()
    {
        foreach ($this->attributes as $attribute) {
            $data[$attribute->name()] = $attribute->format()->nullValue();
        }
        return $data;
    }

    protected function fragmentValue($fragment, ArrayCollection $properties = null)
    {
        if ($properties === null || $properties->isEmpty()) {
            return null;
        }
        $data = [];
        foreach ($this->attributes as $attribute) {
            $data[$attribute->name()] = $properties->get($attribute->name())->value();
        }
        if ($data = $this->nullValue()) {
            return null;
        }
        return $data;
    }

    protected function serializeFragment(Fragment $fragment, ArrayCollection $properties = null)
    {
        if ($properties === null || $properties->isEmpty()) {
            return null;
        }
        $data = [];
        foreach ($this->attributes as $attribute) {
            $data[$attribute->name()] = $properties->get($attribute->name())->serialize();
        }
        return $data;
    }

    protected function hydrateFragment($data, Fragment $fragment, Vocabulary $vocabulary = null)
    {
        $fragment->setValue('');
        if (!is_array($data)) {
            return;
        }
        foreach ($data as $key => $value) {
            $attribute = $this->attribute($key);
        }
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_format_object');

        // Associations
        $builder->addOneToMany('attributes', FormatAttribute::class, 'parent');
    }
}
