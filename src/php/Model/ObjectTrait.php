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
    private $subtypes = null;
    private $properties = null;
    private $required = null;
    private $definitions = null;
    private $schema = null;

    public function subtypes()
    {
        if ($this->subtypes === null) {
            $this->subtypes = array();
            $subtypes = $this->db->getModtypes($this->id, $this->schemaId);
            foreach ($subtypes as $subtype) {
                $this->subtypes[] = $subtype['modtype'];
            }
        }
        return $this->subtypes;
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
            $this->properties[$config['subtype']][] = $property;
            if ($config['required']) {
                $this->required[$config['subtype']][] = $id;
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

    public function properties($subtype = null)
    {
        if ($this->properties === null) {
            $this->loadProperties();
        }
        $properties = (isset($this->properties[$this->typeCode]) ? $this->properties[$this->typeCode] : array());
        if ($subtype && $subtype != $this->typeCode && isset($this->properties[$subtype])) {
            return array_merge($properties, $this->properties[$subtype]);
        }
        return $properties;
    }

    public function required($subtype = null)
    {
        if ($this->required === null) {
            $this->loadProperties();
        }
        $required = (isset($this->required[$this->typeCode]) ? $this->required[$this->typeCode] : array());
        if ($subtype && $subtype != $this->typeCode && isset($this->required[$subtype])) {
            return array_merge($required, $this->required[$subtype]);
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
        if ($this->subtypes()) {
            $anyof = array();
            foreach ($this->subtypes() as $subtype) {
                $subschema = array();
                $subschema['properties'] = array();
                $subschema['properties'][$subtype]['enum'] = array($subtype);
                foreach ($this->properties($subtype) as $property) {
                    $subschema['properties'][$property->id()] = $property->subschema($reference);
                }
                if (isset($this->required[$subtype])) {
                    $subschema['required'] = $this->required[$subtype];
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
        foreach ($this->properties($item->subtype()) as $property) {
            $data[$property->id()] = $property->data($item, $lang);
        }
        return $data;
    }



}
