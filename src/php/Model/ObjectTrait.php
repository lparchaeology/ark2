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
    private $schema = null;

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

    private function getProperties($schemaId)
    {
        return Property::getAllSchema($this->db, $schemaId, $this->typeCode);
    }

    private function loadProperties($schemaId)
    {
        $properties = $this->getProperties($schemaId);
        $this->properties[$schemaId] = array();
        $this->required[$schemaId] = array();
        $this->definitions[$schemaId] = array();
        foreach ($properties as $id => $config) {
            $property = $config['property'];
            $this->properties[$schemaId][$config['modtype']][] = $property;
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

    public function properties($schemaId, $modtype = null)
    {
        if ($this->properties === null || !isset($this->properties[$schemaId]) || $this->properties[$schemaId] === null) {
            $this->loadProperties($schemaId);
        }
        $properties = (isset($this->properties[$schemaId][$this->typeCode]) ? $this->properties[$schemaId][$this->typeCode] : array());
        if ($modtype && $modtype != $this->typeCode && isset($this->properties[$schemaId][$modtype])) {
            return array_merge($properties, $this->properties[$schemaId][$modtype]);
        }
        return $properties;
    }

    public function required($schemaId, $modtype = null)
    {
        if ($this->required === null || !isset($this->required[$schemaId]) || $this->required[$schemaId] === null) {
            $this->loadProperties($schemaId);
        }
        $required = (isset($this->required[$schemaId][$this->typeCode]) ? $this->required[$schemaId][$this->typeCode] : array());
        if ($modtype && $modtype != $this->typeCode && isset($this->required[$schemaId][$modtype])) {
            return array_merge($required[$schemaId], $this->required[$schemaId][$modtype]);
        }
        return $required;
    }

    public function definitions($schemaId)
    {
        if ($this->definitions === null || !isset($this->definitions[$schemaId]) || $this->definitions[$schemaId] === null) {
            $this->loadProperties($schemaId);
        }
        return $this->definitions[$schemaId];
    }

    public function schema(Item $item, $reference = Schema::ReferenceSchema)
    {
        if ($item && $item->schemaId()) {
            $schemaId = $item->schemaId();
        } else {
            $schemaId = $this->schemaId;
        }
        if (isset($this->schema[$schemaId][$reference])) {
            return $this->schema[$schemaId][$reference];
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
        $schema['required'] = $this->required($this->typeCode);
        $schema['additionalProperties'] = false;
        if ($this->modtypes($schemaId)) {
            $anyof = array();
            foreach ($this->modtypes($schemaId) as $modtype) {
                $subschema = array();
                $subschema['properties'] = array();
                $subschema['properties'][$modtype]['enum'] = array($modtype);
                foreach ($this->properties($schemaId, $modtype) as $property) {
                    $subschema['properties'][$property->id()] = $property->subschema($reference);
                }
                if (isset($this->required[$modtype])) {
                    $subschema['required'] = $this->required[$modtype];
                }
                $anyof[] = $subschema;
            }
            if ($anyof) {
                $schema['anyOf'] = $anyof;
            }
        }
        $this->schema[$reference] = $schema;
        return $schema;
    }

    public function data(Item $item, $lang)
    {
        $data = null;
        foreach ($this->properties($item->schemaId(), $item->modtype()) as $property) {
            $data[$property->id()] = $property->data($item, $lang);
        }
        return $data;
    }



}
