<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/ItemResourceTransformer.php
*
* JSON:API Item Resource Transformer
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/ItemResourceTransformer.php
* @since      2.0
*/

namespace ARK\Api\JsonApi\Serializer;

use ARK\Model\Item;
use Tobscure\JsonApi\AbstractSerializer;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Relationship;

class ItemSerializer extends AbstractSerializer
{
    public function getType($item)
    {
        return $item->module()->type();
    }

    public function getId($item)
    {
        return $item->id();
    }

    public function getMeta($item)
    {
        return [];
    }

    public function getAttributes($item, array $fields = null)
    {
        $attributes = [];
        foreach ($item->properties() as $property) {
            if (!$fields or in_array($property->id(), $fields)) {
                $attributes[$property->id()] = $item->attribute($property);
            }
        }
        return $attributes;
    }

    public function getLinks($item)
    {
        return [];
        // TODO Need proper URI path
        return ['self' => $item->path()];
    }

    public function getRelationship($item, $name)
    {
        foreach ($item->submodules() as $submodule) {
            if ($submodule->type() == $name) {
                return new Relationship(new Collection($submodule->items(), new ItemSerializer()));
            }
        }
        foreach ($item->relationships() as $relationship) {
            if ($relationship->type() == $name) {
                return new Relationship(new Collection($relationship->items(), new ItemSerializer()));
            }
        }
    }

    public function getRelationships($item)
    {
        $relationships = array();
        foreach ($item->submodules() as $submodule) {
            $relationships[] = new Relationship(new Collection($submodule->items(), new ItemSerializer()));
        }
        foreach ($item->relationships() as $relationship) {
            $relationships[] = new Relationship(new Collection($relationship->items(), new ItemSerializer()));
        }
        return $relationships;
    }
}
