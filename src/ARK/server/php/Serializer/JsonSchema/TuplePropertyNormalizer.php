<?php

/**
 * ARK JSON Schema Tuple Property Normalizer.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Serializer\JsonSchema;

use ARK\Model\Attribute;
use ARK\Model\Dataclass\ItemDataclass;
use ARK\Model\Dataclass\SpatialDataclass;
use ARK\Model\Dataclass\TextDataclass;

class TuplePropertyNormalizer extends ObjectPropertyNormalizer
{
    public function supportsNormalization($attribute, $format = null)
    {
        $class = get_class($attribute->dataclass());
        return $class === TextDataclass::class || $class === SpatialDataclass::class || $class === ItemDataclass::class;
    }

    protected function definition(Attribute $attribute)
    {
        $definition['type'] = 'array';
        foreach ($attribute->properties() as $prop) {
            $definition['items'][] = $this->attributes($prop);
        }
        $definition['additionalItems'] = $attribute->additionalValues();
        if ($attribute->minimumOccurrences() > 0) {
            $definition['minItems'] = $attribute->minimumOccurrences();
        }
        if ($attribute->maximumOccurrences() > 1) {
            $definition['maxItems'] = $attribute->maximumOccurrences();
        }
        $definition['uniqueItems'] = $attribute->uniqueValues();
        return $definition;
    }
}
