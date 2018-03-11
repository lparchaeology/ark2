<?php

/**
 * ARK JSON Schema Tuple Property Normalizer
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

use ARK\Model\Property\Property;
use ARK\Model\Property\TupleProperty;

class TuplePropertyNormalizer extends ObjectPropertyNormalizer
{
    public function supportsNormalization($property, $format = null)
    {
        $class = get_class($property);
        return ($class === TextProperty::class || $class === GeometryProperty::class || $class === ItemProperty::class);
    }

    protected function definition(Property $property)
    {
        $definition['type'] = 'array';
        foreach ($property->properties() as $prop) {
            $definition['items'][] = $this->attributes($prop);
        }
        $definition['additionalItems'] = $property->additionalValues();
        if ($property->minimumOccurrences() > 0) {
            $definition['minItems'] = $property->minimumOccurrences();
        }
        if ($property->maximumOccurrences() > 1) {
            $definition['maxItems'] = $property->maximumOccurrences();
        }
        $definition['uniqueItems'] = $property->uniqueValues();
        return $definition;
    }
}
