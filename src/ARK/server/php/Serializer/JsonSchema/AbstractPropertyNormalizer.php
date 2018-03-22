<?php

/**
 * ARK JSON Schema Abstract Property Normalizer
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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

namespace ARK\Serializer\JsonSchema;

use ARK\Model\Attribute;
use ARK\Model\Dataclass\Dataclass;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

abstract class AbstractPropertyNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    public function normalize($attribute, $format = null, array $context = [])
    {
        if (isset($context['definitions'])) {
            return $this->definitions($attribute);
        }
        return $this->property($attribute);
    }

    protected function pointer(/*string*/ $definition)
    {
        return "#/definitions/".$definition;
    }

    protected function reference(/*string*/ $definition)
    {
        return ['$ref' => $this->pointer($definition)];
    }

    abstract protected function definition(Attribute $attribute);

    protected function definitions(Attribute $attribute)
    {
        return [$attribute->type() => $this->definition($attribute)];
    }

    protected function attributes(Attribute $attribute)
    {
        $attributes = $this->reference($attribute->type());
        if ($attribute->defaultValue() !== null) {
            $attributes['default'] = $attribute->default();
        }
        if ($attribute->hasAllowedValues()) {
            $attributes['allowedValues'] = array_keys($attribute->allowedValues());
        }
        return $attributes;
    }

    protected function property(Dataclass $attribute)
    {
        $schema = [];
        if ($attribute->keyword()) {
            $schema['title'] = $attribute->keyword().'.title';
            $schema['description'] = $attribute->keyword().'.description';
        }
        if ($attribute->hasMultipleOccurrences()) {
            $schema['type'] = 'array';
            $schema['items'] = $this->attributes($attribute);
            $schema['additionalItems'] = $attribute->additionalValues();
            if ($attribute->minimumOccurrences() > 0) {
                $schema['minItems'] = $attribute->minimumOccurrences();
            }
            if ($attribute->maximumOccurrences() > 1) {
                $schema['maxItems'] = $attribute->maximumOccurrences();
            }
            $schema['uniqueItems'] = $attribute->uniqueValues();
        } else {
            $schema = array_merge($schema, $this->attributes($property));
        }
        return $schema;
    }
}
