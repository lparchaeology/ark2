<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/AApi/JsonApi/Action/AbstractJsonApiAction.php
*
* JSON:API Abstract Get Action
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApi/Action/AbstractJsonApiAction.php
* @since      2.0
*/

namespace ARK\Api\JsonApi\Action;

use NilPortugues\Api\JsonApi\Http\Response\Response;
use NilPortugues\Api\JsonApi\Server\Query\QueryObject;
use NilPortugues\Api\JsonApi\Server\Query\QueryException;

abstract class AbstractGetAction extends AbstractJsonApiAction
{
    protected $fields = null;
    protected $included = null;

    protected function validateParams($data)
    {
        $this->fields = $this->request->getFields();
        $this->included = $this->request->getIncluded();
        QueryObject::validateQueryParamsTypes($this->serializer, $this->fields, 'Fields', $this->errorBag);
        QueryObject::validateIncludeParams($this->serializer, $this->included, 'include', $this->errorBag);
        if ($this->errorBag->count() > 0) {
            throw new QueryException();
        }
    }

    protected function getResponse($data)
    {
        return new Response($this->serializer->serialize($this->data, $this->fields, $this->included));
    }
}
