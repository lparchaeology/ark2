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

    public function getAliasedProperties($item = null)
    {
        $attributes = array();
        foreach ($item->properties() as $property) {
            $attributes[$property->id()] = $property->id();
        }
        return $attributes;
    }

    public function getHideProperties($item = null)
    {
        return [];
    }

    public function getIdProperties($item = null)
    {
        return [
            'id',
        ];
    }

    public function getUrls($item = null)
    {
        return [
            'self' => $item->path(),
        ];
    }

    public function getRelationships($item = null)
    {
        $relationships = array();
        foreach ($item->submodules() as $submodule) {
            $relationships[$submodule->type()]['self'] = '/relationships/'.$submodule->type();
            $relationships[$submodule->type()]['related'] = '/'.$submodule->type();
        }
        foreach ($item->relationships() as $relationship) {
            $relationships[$relationship->type()]['self'] = '/relationships/'.$relationship->type();
            $relationships[$relationship->type()]['related'] = '/'.$relationship->type();
        }
        return $relationships;
    }

    public function getRequiredProperties($item = null)
    {
        return $item->required();
    }
}
