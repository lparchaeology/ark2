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

namespace ARK\Api;

use ARK\Model\Item;
use NilPortugues\Api\Mappings\JsonApiMapping;

class SiteMapping implements JsonApiMapping
{
    public function getClass()
    {
        return Item::class;
    }

    public function getAlias($item = null)
    {
        return $item->module()->type();
    }

    public function getAliasedProperties() {
        return [
            'author' => 'author',
            'title' => 'headline',
            'content' => 'body',
        ];
    }

    public function getHideProperties(){
        return [];
    }

    public function getIdProperties() {
        return [
            'id',
        ];
    }

    public function getUrls()
    {
        return [
            'self' => $item->path(),
        ];
    }

    public function getRelationships()
    {
        $relationships = array();
        foreach ($item->submodules() as $submodule) {
            $relationships[$submodule->type()] = function (Item $item) {
                $paths['self'] = new Link('/relationships/'.$submodule->type());
                $paths['related'] = new Link('/'.$submodule->type());
                return ToManyRelationship::create()
                    ->setLinks(new Links($item->path(), $paths))
                    ->setData($item[$submodule->type()], new ItemResourceTransformer());
            };
        }
        foreach ($item->relationships() as $relationship) {
            $relationships[$relationship->type()] = function (Item $item) {
                $paths['self'] = new Link('/relationships/'.$relationship->type());
                $paths['related'] = new Link('/'.$relationship->type());
                ToManyRelationship::create()
                    ->setLinks(new Links($item->path(), $paths))
                    ->setData($item[$relationship->type()], new ItemResourceTransformer());
            };
        }
        return $relationships;
    }

    public function getRequiredProperties()
    {
        return [];
    }

    public function getAttributes(Item $item)
    {
        $attributes = array();
        foreach ($item->properties() as $property) {
            $attributes[$property->id()] = function (Item $item) {
                return $item->attribute($property);
            };
        }
        return $attributes;
    }

    public function getRelationships(Item $item)
    {
    }
}
