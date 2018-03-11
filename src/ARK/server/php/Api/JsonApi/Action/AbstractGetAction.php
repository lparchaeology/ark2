<?php

/**
 * ARK JSON:API Action.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
 *
 * This file is part of ARK, the Archaeological Recording Kit.
 *
 * ARK is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ARK is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ARK.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     John Layt <j.layt@lparchaeology.com>
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Api\JsonApi\Action;

use ARK\Api\JsonApi\Error\NotFoundError;
use ARK\Api\JsonApi\Http\JsonApiResponse;
use ARK\Api\JsonApi\JsonApiException;
use ARK\Api\JsonApi\Resource\ItemResource;
use ARK\ORM\ORM;
use ARK\Service;
use Tobscure\JsonApi\Document;

class AbstractGetAction extends AbstractJsonApiAction
{
    protected $id;
    protected $class;
    protected $resource;

    protected function fetchData() : void
    {
        $item = ORM::find($this->class, $this->id);
        if (!$item) {
            $this->addError(new NotFoundError($this->resource, $this->id));
            throw new JsonApiException();
        }
        $this->data = $item;
    }

    protected function customParameters()
    {
        return ['schema'];
    }

    protected function createResponse() : void
    {
        $resource = new ItemResource($this->data, $this->parameters, Service::serializer());
        $document = new Document($resource);
        $this->response = new JsonApiResponse($document);
    }
}
