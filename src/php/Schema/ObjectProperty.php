<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/ObjectProperty.php
*
* ARK Schema ObjectProperty
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/ObjectProperty.php
* @since      2.0
*
*/

namespace ARK\Schema;

class ObjectProperty extends Property
{
    private $_properties = array();
    private $_required = array();
    private $_graphRoot = '';

    private function _loadConfig($config)
    {
        parent::_loadConfig($config);
        foreach ($config['properties'] as $property) {
            $this->_properties[] = Property::property($property);
            if ($property['required']) {
                $this->_required[] = $property['property'];
            }
            if ($property['graph_root']) {
                $this->_graphRoot = $property['property'];
            }
        }
    }

    public function properties()
    {
        return $this->_properties;
    }

    public function required()
    {
        return $this->_required;
    }

    public function toSchema()
    {
        $object['type'] = 'object';
        $object['properties'] = array();
        foreach ($this->properties() as $property) {
            $object['properties'][$this->id()] = $property->toSchema();
        }
        $object['required'] = $this->required();
        $object['additionalProperties'] = false;
        $schema[$this->id()] = $property;
        return $schema;
    }

}
