<?php

/**
 * ARK Model Module JsonSchema Normalizer.
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

use ARK\Model\Module\Module;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

class SchemaNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    private $schemas = [];

    public function supportsNormalization($schema, $format = null)
    {
        return get_class($schema) === Schema::class;
    }

    public function normalize($schema, $format = null, array $context = [])
    {
        if (isset($this->schemas[$schema->name()])) {
            return $this->schemas[$schema->name()];
        }
        $schema['$schema'] = 'http://json-schema.org/draft-04/schema#';
        $schema['schema_id'] = $schema->name();
        $schema['definitions'] = [];
        $context['definitions'] = true;
        $classes = array_merge([$schema->module->id()], $schema->subclassNames());
        foreach ($classes as $class) {
            foreach ($schema->attributes($class, false) as $attribute) {
                $schema['definitions'] =
                    array_merge($schema['definitions'], $this->serializer->normalize($attribute, $format, $context));
            }
        }
        unset($context['definitions']);
        $schema['type'] = 'object';
        $schema['properties'] = [];
        foreach ($schema->attributes($schema->module->id(), false) as $attribute) {
            $schema['properties'][$attribute->name()] = $this->serializer->normalize($attribute, $format, $context);
            if ($attribute->isRequired()) {
                $schema['required'] = $attribute->name();
            }
        }
        $schema['additionalProperties'] = false;
        $anyof = [];
        foreach ($schema->subclassNames() as $class) {
            $subschema = null;
            foreach ($schema->attributes($class, false) as $attribute) {
                $subschema['properties'][$attribute->name()] =
                    $this->serializer->normalize($attribute, $format, $context);
                if ($attribute->isRequired()) {
                    $subschema['required'] = $attribute->name();
                }
            }
            if ($subschema) {
                $subschema['properties'][$class]['enum'] = [$class];
                $schema['anyOf'][] = $subschema;
            }
        }
        $this->schemas[$schema->name()] = $schema;
        return $schema;
    }
}
