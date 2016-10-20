<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonApi/ItemResource.php
*
* JSON:API Item Resource
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApi/ItemResource.php
* @since      2.0
*/

namespace ARK\Api;

use ARK\Model\Item;
use ARK\Api\JsonApi\JsonApiParameters;
use Tobscure\JsonApi\Resource;

class ItemResource extends Resource
{
    protected $paramaters;

    public function __construct(Item $item, ItemSerializer $serializer, JsonApiParameters $parameters = null)
    {
        $this->data = $item;
        $this->serializer = $serializer;
        if ($paramaters) {
            $this->setParameters($parameters);
        }
    }

    public function setParamaters(JsonApiParameters $paramaters)
    {
        $this->paramaters = $paramaters;
        $this->includes = $parameters->getIncludedRelationships();
        $this->fields = $parameters->getIncludedFields();
        if ($parameters->includeSchema()) {
            $meta['schema'] = $this->data->schema();
        }
    }

    public function getParamaters()
    {
        return $this->paramaters;
    }
}
