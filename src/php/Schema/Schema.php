<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Schema.php
*
* ARK Schema Schema
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Schema.php
* @since      2.0
*
*/

namespace ARK\Schema;

use ARK\Database\Database;

class Schema extends ObjectProperty
{
    private $_db = '';
    private $_module = '';
    private $_modtype = '';
    private $_modtypes = '';
    private $_config = '';
    private $_mod = '';

    public function __construct(Database $db, $module)
    {
        $config = $db->getObject($module, 'schema');
        $config['properties'] = $db->getObjectProperties($module);
        $this->_config = $config;
        parent::_loadConfig($db, $config);
        $mod = $db->getModule($module);
        $this->_mod = $mod;
        $this->_module = $module;
        $this->_modtype = $mod['modtype'];
        $modtypes = $db->getModtypes($module);
        foreach ($modtypes as $modtype) {
            $this->_modtypes[] = $modtype['modtype'];
        }
        $this->_valid = true;
    }

    public function toSchema()
    {
        $schema['$module'] = $this->_module;
        $schema['$config'] = $this->_config;
        $schema['$mod'] = $this->_mod;
        $schema['$schema'] = 'http://json-schema.org/draft-04/schema#';
        $schema = array_merge($schema, parent::toSchema());
        if ($this->_modtype) {
            $anyof = array();
            foreach ($this->_modtypes as $modtype) {
                $subschema = array();
                $subschema['properties'][$this->_modtype]['enum'] = array($this->_modtype);
                $subschema['required'] = array($this->_modtype);
                $anyof[] = $subschema;
            }
            $schema['anyOf'] = $anyof;
        }
        return $schema;
    }

}
