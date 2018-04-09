<?php

/**
 * ARK JSON Schema String Property Normalizer.
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
use ARK\Model\Dataclass\StringDataclass;

class StringPropertyNormalizer extends AbstractPropertyNormalizer
{
    public function supportsNormalization($attribute, $format = null)
    {
        return $attribute->dataclass() instanceof StringDataclass;
    }

    protected function definition(Attribute $attribute)
    {
        $definition['type'] = 'string';
        $dataclass = $attribute->dataclass();
        if ($dataclass->minimumLength() > 0) {
            $definition['min_length'] = $dataclass->minimumLength();
        }
        if ($dataclass->maximumLength() > 0) {
            $definition['max_length'] = $dataclass->maximumLength();
        }
        if ($dataclass->pattern()) {
            $definition['pattern'] = $dataclass->pattern();
        }
        if ($dataclass->format() && $dataclass->format() !== 'text') {
            $definition['format'] = $dataclass->type();
        }
        return $definition;
    }
}
