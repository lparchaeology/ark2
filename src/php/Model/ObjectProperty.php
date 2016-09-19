<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/ObjectProperty.php
*
* ARK Model ObjectProperty
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/ObjectProperty.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

class ObjectProperty extends Property
{
    use ObjectTrait;

    private $graphRoot = '';

    protected function __construct(Database $db, string $id)
    {
        parent::__construct($db, $id);
    }

    protected function loadConfig(array $config)
    {
        parent::loadConfig($config);
        $this->typeCode = ($this->format() == 'object' ? $this->id : $this->format());
    }

    private function getProperties()
    {
        $properties = Property::getAllObject($this->db, $this->typeCode);
        foreach ($properties as $property) {
            if ($property['graph_root']) {
                $this->graphRoot = $property['property'];
            }
        }
        return $properties;
    }

    public function definition(int $reference = Schema::ReferenceSchema)
    {
        if (!$reference || $this->format() != 'object' || ($reference && $this->format() == 'object')) {
            $definition = parent::definition(Schema::FullSchema);
            $definition['properties'] = array();
            foreach ($this->properties($this->schemaId) as $property) {
                $definition['properties'][$property->id()] = $property->definition($reference);
            }
            $definition['required'] = $this->required($this->schemaId);
            $definition['additionalProperties'] = false;
        } else {
            $definition = parent::definition($reference);
        }
        return $definition;
    }

    public function data(Item $item, string $lang)
    {
        $data = array();
        // TODO Graph/chain data!
        foreach ($this->properties($this->schemaId) as $property) {
            $data[$property->id()] = $property->data($item, $lang);
        }
        if ($this->maxItems() != 1) {
            return array($data);
        }
        return $data;
    }

}
