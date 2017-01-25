<?php

/**
 * ARK View Field
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

namespace ARK\View;

use ARK\ORM\ClassMetadata;

class Field extends Element
{
    public function attribute()
    {
        return $this->attribute;
    }

    public function keyword()
    {
        if ($this->keyword) {
            return $this->keyword;
        }
        return $this->attribute()->keyword();
    }

    public function formOptions()
    {
        $options['label'] = $this->keyword();
        if ($this->attribute) {
            $name = $this->attribute->name();
            $options['field'] = $this;
            $options['mapped'] = false;
            //$options['property_path'] = "propertyArray[$name].value";
        }
        return $options;
    }

    public function formData($resource)
    {
        if ($resource && $this->attribute) {
            return $resource->property($this->attribute->name());
            ;
        }
        return null;
    }

    public function renderView($resource, array $options = [])
    {
        // FIXME Should probably have some way to use FormTypes here to render 'flat' compond values
        $value = 'FIXME: '.$this->element;
        if ($this->attribute->isAtomic()) {
            $value = $resource->property($this->attribute->name())->value();
        } elseif ($this->attribute->format()->isAtomic()) {
            $value = $resource->property($this->attribute->name())->value()[0];
        } elseif ($this->attribute->format()->type()->isAtomic()) {
            if ($this->attribute->format()->serializeAsObject()) {
                //
            } else {
                foreach ($this->attribute->format()->attributes() as $attribute) {
                    if ($attribute->isRoot()) {
                        $value = $resource->property($this->attribute->name())->value()[$attribute->name()];
                    }
                }
            }
        }
        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        }
        return $value;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
    }
}
