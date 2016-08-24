<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Module.php
*
* ARK Schema Module
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Module.php
* @since      2.0
*
*/

namespace ARK\Schema;

use ARK\Database\Database;

class Module
{
    private $_db = '';
    private $_module = '';
    private $_modtype = '';
    private $_itemkey = '';
    private $_itemno = '';
    private $_table = '';
    private $_keyword = '';
    private $_modtypes = '';
    private $_properties = array();
    private $_required = array();
    private $_definitions = array();
    private $_schema = array();

    public function __construct(Database $db, $schema, $module)
    {
        $mod = $db->getModule($module);
        $this->_module = $module;
        $this->_modtype = $mod['modtype'];
        $this->_itemkey = $mod['itemkey'];
        $this->_itemno = $mod['itemno'];
        $this->_table = $mod['tbl'];
        $this->_keyword = $mod['keyword'];
        $modtypes = $db->getModtypes($schema, $module);
        foreach ($modtypes as $modtype) {
            $this->_modtypes[] = $modtype['modtype'];
        }
        $properties = $db->getSchemaStructure($schema, $module);
        foreach ($properties as $property) {
            $this->_properties[$property['modtype']][] = Property::property($db, $property['property'], $schema);
            if ($property['required']) {
                $this->_required[$property['modtype']][] = $property['property'];
            }
        }
    }

    public function module()
    {
        return $this->_module;
    }

    public function modtype()
    {
        return $this->_modtype;
    }

    public function itemkey()
    {
        return $this->_itemkey;
    }

    public function itemno()
    {
        return $this->_itemno;
    }

    public function table()
    {
        return $this->_table;
    }

    public function keyword()
    {
        return $this->_keyword;
    }

    public function modtypes()
    {
        return $this->_modtypes;
    }

    public function properties($modtype)
    {
        return array_merge($this->_properties[$this->_module], $this->_properties[$modtype]);
    }

    public function required($modtype)
    {
        return array_merge($this->_required[$this->_module], $this->_required[$modtype]);
    }

    public function definitions()
    {
        if (!$this->_definitions) {
            $modtypes = array_merge(array($this->_module), $this->_modtypes);
            foreach ($modtypes as $modtype) {
                foreach ($this->_properties[$modtype] as $property) {
                    if ($property->type() == 'object') {
                        $this->_definitions = array_merge($this->_definitions, $property->definitions());
                    }
                    if ($property->format() != 'object') {
                        if ($property->type() == 'object') {
                            $this->_definitions[$property->format()] = $property->definition();
                        } else {
                            $this->_definitions[$property->format()] = $property->definition(Schema::FullSchema);
                        }
                    }
                }
            }
        }
        return $this->_definitions;
    }

    public function schema($reference = Schema::ReferenceSchema)
    {
        if (isset($this->_schema[$reference])) {
            return $this->_schema[$reference];
        }
        $schema['$schema'] = 'http://json-schema.org/draft-04/schema#';
        if ($reference) {
            $schema['definitions'] = $this->definitions();
        }
        $schema['type'] = 'object';
        $schema['properties'] = array();
        foreach ($this->_properties[$this->_module] as $property) {
            $schema['properties'][$property->id()] = $property->subschema($reference);
        }
        $schema['required'] = $this->_required[$this->_module];
        $schema['additionalProperties'] = false;
        if ($this->_modtype) {
            $anyof = array();
            foreach ($this->_modtypes as $modtype) {
                $subschema = array();
                $subschema['properties'] = array();
                $subschema['properties'][$this->_modtype]['enum'] = array($modtype);
                foreach ($this->_properties[$modtype] as $property) {
                    $subschema['properties'][$property->id()] = $property->subschema($reference);
                }
                if (isset($this->_required[$modtype])) {
                    $subschema['required'] = $this->_required[$modtype];
                }
                $anyof[] = $subschema;
            }
            $schema['anyOf'] = $anyof;
        }
        $this->_schema[$reference] = $schema;
        return $schema;
    }

}
