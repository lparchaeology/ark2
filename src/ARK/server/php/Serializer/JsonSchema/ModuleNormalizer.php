<?php

/**
 * ARK Model Module JsonSchema Normalizer
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

class ModuleNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    private $schemas = [];

    public function supportsNormalization($module, $format = null)
    {
        return (get_class($module) === Module::class);
    }

    public function normalize($module, $format = null, array $context = [])
    {
        if (!isset($context['schemaId'])) {
            $context['schemaId'] = $module->id();
        }
        $schemaId = $context['schemaId'];
        if (isset($this->schemas[$schemaId])) {
            return $this->schemas[$schemaId];
        }
        $schema['$schema'] = 'http://json-schema.org/draft-04/schema#';
        $schema['schema_id'] = $schemaId;
        $schema['definitions'] = [];
        $context['definitions'] = true;
        $modtypes = array_merge([$module->id()], $module->modtypes($schemaId));
        foreach ($modtypes as $modtype) {
            foreach ($module->properties($schemaId, $modtype) as $property) {
                $schema['definitions'] =
                    array_merge($schema['definitions'], $this->serializer->normalize($property, $format, $context));
            }
        }
        unset($context['definitions']);
        $schema['type'] = 'object';
        $schema['properties'] = [];
        foreach ($module->properties($schemaId, $module->id(), false) as $property) {
            $schema['properties'][$property->id()] = $this->serializer->normalize($property, $format, $context);
        }
        $schema['required'] = $module->required($schemaId, $module->id(), false);
        $schema['additionalProperties'] = false;
        $anyof = [];
        foreach ($module->modtypes($schemaId) as $modtype) {
            $subschema = null;
            foreach ($module->properties($schemaId, $modtype, false) as $property) {
                $subschema['properties'][$property->id()] =
                    $this->serializer->normalize($property, $format, $context);
            }
            if ($subschema) {
                $subschema['properties'][$modtype]['enum'] = [$modtype];
                $required = $module->required($schemaId, $modtype, false);
                if ($required) {
                    $subschema['required'] = $required;
                }
                $schema['anyOf'][] = $subschema;
            }
        }
        $this->schemas[$schemaId] = $schema;
        return $schema;
    }
}
