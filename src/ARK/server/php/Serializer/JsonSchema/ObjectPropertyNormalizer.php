<?php

/**
 * ARK JSON Schema Object Property Normalizer.
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

class ObjectPropertyNormalizer extends AbstractPropertyNormalizer
{
    public function supportsNormalization($attribute, $format = null)
    {
        return $attribute->isStructure();
    }

    protected function definition(Attribute $attribute)
    {
        $definition['type'] = 'object';
        foreach ($attribute->properties() as $prop) {
            $definition['properties'][$prop->id()] = $this->reference($prop->id());
            if ($prop->required()) {
                $definition['required'][] = $prop->id();
            }
        }
        $definition['additionalProperties'] = false;
        return $definition;
    }

    protected function definitions(Attribute $attribute)
    {
        $definitions = [];
        foreach ($attribute->properties() as $sub) {
            $definitions = array_merge($definitions, $this->serializer->normalize($sub, null, ['definitions' => true]));
            $definitions[$sub->id()] = $this->serializer->normalize($sub);
        }
        $definitions[$attribute->format()] = $this->definition($attribute);
        return $definitions;
    }

    protected function attributes(Attribute $attribute)
    {
        return $this->reference($attribute->format());
    }
}
