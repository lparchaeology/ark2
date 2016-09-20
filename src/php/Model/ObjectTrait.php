<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/Object.php
*
* ARK Model Object
*
* PHP version 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Heritage LLP.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Model/Object.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

trait ObjectTrait
{
    private $modtypes = null;
    private $properties = null;
    private $required = null;
    private $definitions = null;
    private $schemas = null;

    public function modtypes()
    {
        if ($this->modtypes === null) {
            $this->modtypes = array();
            $modtypes = $this->db->getModtypes($this->id, $this->schemaId);
            foreach ($modtypes as $modtype) {
                $this->modtypes[] = $modtype['modtype'];
            }
        }
        return $this->modtypes;
    }

    private function loadProperties(string $schemaId)
    {
        if (isset($this->properties[$schemaId])) {
            return;
        }
        $properties = Property::getAllSchema($this->db, $schemaId, $this->typeCode);
        $this->properties[$schemaId] = array();
        $this->required[$schemaId] = array();
        $this->definitions[$schemaId] = array();
        foreach ($properties as $id => $config) {
            $property = $config['property'];
            $this->properties[$schemaId][$config['modtype']][$id] = $property;
            if ($config['required']) {
                $this->required[$schemaId][$config['modtype']][] = $id;
            }
            if ($property->type() == 'object') {
                $this->definitions[$schemaId] = array_merge($this->definitions[$schemaId], $property->definitions($schemaId));
            }
            if ($property->format() != 'object') {
                if ($property->type() == 'object') {
                    $this->definitions[$schemaId][$property->format()] = $property->definition();
                } else {
                    $this->definitions[$schemaId][$property->format()] = $property->definition(Schema::FullSchema);
                }
            }
        }
    }

    public function properties(string $schemaId, string $modtype = null)
    {
        $this->loadProperties($schemaId);
        $properties = (isset($this->properties[$schemaId][$this->typeCode]) ? array_values($this->properties[$schemaId][$this->typeCode]) : array());
        if ($modtype && $modtype != $this->typeCode && isset($this->properties[$schemaId][$modtype])) {
            return array_merge($properties, array_values($this->properties[$schemaId][$modtype]));
        }
        return $properties;
    }

    public function property(string $schemaId, string $modtype = null, string $property)
    {
        $this->loadProperties($schemaId);
        if (isset($this->properties[$schemaId][$this->typeCode][$property])) {
            return $this->properties[$schemaId][$this->typeCode][$property];
        }
        if (isset($this->properties[$schemaId][$modtype][$property])) {
            return $this->properties[$schemaId][$modtype][$property];
        }
        return null;
    }

    public function required(string $schemaId, string $modtype = null)
    {
        $this->loadProperties($schemaId);
        $required = (isset($this->required[$schemaId][$this->typeCode]) ? $this->required[$schemaId][$this->typeCode] : array());
        if ($modtype && $modtype != $this->typeCode && isset($this->required[$schemaId][$modtype])) {
            return array_merge($required, $this->required[$schemaId][$modtype]);
        }
        return $required;
    }

    public function definitions(string $schemaId)
    {
        $this->loadProperties($schemaId);
        return $this->definitions[$schemaId];
    }

    public function schema(string $schemaId, int $reference = Schema::ReferenceSchema)
    {
        if (isset($this->schemas[$schemaId][$reference])) {
            return $this->schemas[$schemaId][$reference];
        }
        $schema['$schema'] = 'http://json-schema.org/draft-04/schema#';
        $schema['schema_id'] = $schemaId;
        if ($reference) {
            $schema['definitions'] = $this->definitions($schemaId);
        }
        $schema['type'] = 'object';
        $schema['properties'] = array();
        foreach ($this->properties($schemaId, $this->typeCode) as $property) {
            $schema['properties'][$property->id()] = $property->subschema($reference);
        }
        $schema['required'] = $this->required($schemaId);
        $schema['additionalProperties'] = false;
        if ($this->modtypes($schemaId)) {
            $anyof = array();
            foreach ($this->modtypes($schemaId) as $modtype) {
                $subschema = array();
                $subschema['properties'] = array();
                $subschema['properties'][$modtype]['enum'] = array($modtype);
                if (isset($this->properties[$schemaId][$modtype])) {
                    foreach ($this->properties[$schemaId][$modtype] as $property) {
                        $subschema['properties'][$property->id()] = $property->subschema($reference);
                    }
                    if (isset($this->required[$modtype])) {
                        $subschema['required'] = $this->required[$modtype];
                    }
                    $anyof[] = $subschema;
                }
            }
            if ($anyof) {
                $schema['anyOf'] = $anyof;
            }
        }
        $this->schemas[$reference] = $schema;
        return $schema;
    }
}
