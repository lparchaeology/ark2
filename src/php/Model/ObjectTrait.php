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

    private function getProperties()
    {
        return Property::getAllSchema($this->db, $this->schemaId, $this->typeCode);
    }

    private function loadProperties()
    {
        $properties = $this->getProperties();
        $this->properties = array();
        $this->required = array();
        $this->definitions = array();
        foreach ($properties as $id => $config) {
            $property = $config['property'];
            $this->properties[$config['modtype']][] = $property;
            if ($config['required']) {
                $this->required[$config['modtype']][] = $id;
            }
            if ($property->type() == 'object') {
                $this->definitions = array_merge($this->definitions, $property->definitions());
            }
            if ($property->format() != 'object') {
                if ($property->type() == 'object') {
                    $this->definitions[$property->format()] = $property->definition();
                } else {
                    $this->definitions[$property->format()] = $property->definition(Schema::FullSchema);
                }
            }
        }
    }

    public function properties($modtype = null)
    {
        if ($this->properties === null) {
            $this->loadProperties();
        }
        $properties = (isset($this->properties[$this->typeCode]) ? $this->properties[$this->typeCode] : array());
        if ($modtype && $modtype != $this->typeCode && isset($this->properties[$modtype])) {
            return array_merge($properties, $this->properties[$modtype]);
        }
        return $properties;
    }

    public function required($modtype = null)
    {
        if ($this->required === null) {
            $this->loadProperties();
        }
        $required = (isset($this->required[$this->typeCode]) ? $this->required[$this->typeCode] : array());
        if ($modtype && $modtype != $this->typeCode && isset($this->required[$modtype])) {
            return array_merge($required, $this->required[$modtype]);
        }
        return $required;
    }

    public function definitions()
    {
        if ($this->definitions === null) {
            $this->loadProperties();
        }
        return $this->definitions;
    }

    public function schema($reference = Schema::ReferenceSchema)
    {
        if (isset($this->schema[$reference])) {
            return $this->schema[$reference];
        }
        $schema['$schema'] = 'http://json-schema.org/draft-04/schema#';
        $schema['schema_id'] = $this->schemaId;
        if ($reference) {
            $schema['definitions'] = $this->definitions();
        }
        $schema['type'] = 'object';
        $schema['properties'] = array();
        foreach ($this->properties($this->typeCode) as $property) {
            $schema['properties'][$property->id()] = $property->subschema($reference);
        }
        $schema['required'] = $this->required($this->typeCode);
        $schema['additionalProperties'] = false;
        if ($this->modtypes()) {
            $anyof = array();
            foreach ($this->modtypes() as $modtype) {
                $subschema = array();
                $subschema['properties'] = array();
                $subschema['properties'][$modtype]['enum'] = array($modtype);
                foreach ($this->properties($modtype) as $property) {
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
        foreach ($this->properties($item->modtype()) as $property) {
            $data[$property->id()] = $property->data($item, $lang);
        }
        return $data;
    }



}
