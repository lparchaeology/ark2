<?php

/**
 * ARK JSON:API Action
 *
 * Copyright (C) 2017  L - P : Heritage LLP.
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Api\JsonApi\Action;

use ARK\Api\JsonApi\Http\JsonApiRequest;
use ARK\Api\JsonApi\Http\JsonApiResponse;
use ARK\Api\JsonApi\JsonApiException;
use ARK\Api\JsonApi\Resource\ItemResource;
use ARK\Api\JsonApi\Serializer\ItemSerializer;
use ARK\Framework\Application;
use ARK\Http\Error\NotFoundError;
use ARK\Model\Module\Module;
use ARK\ORM\EntityManager;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Resource;

class SiteListAction extends AbstractJsonApiAction
{
    public function __invoke(Application $app, JsonApiRequest $request)
    {
        return parent::__invoke($app, $request);
    }

    protected function fetchData()
    {
        $em = new EntityManager($this->app['database'], 'data');
        $this->data = $em->findAll('ARK\Model\Item\Site');
    }

    protected function createResponse()
    {
        //$resource = new ItemResource($this->data, $this->parameters, $this->app['serializer']);
        //$document = new Document($resource);
        //$this->response = new JsonApiResponse($document);
        $uri = $this->request->getSchemeAndHttpHost().$this->request->getBaseUrl().$this->request->getPathInfo();
        $jsonapi['jsonapi']['version'] = '1.0';
        foreach ($this->data as $item) {
            $resource['type'] = $item->schema()->resource();
            $resource['id'] = $item->id();
            $resource['links']['self'] = $uri.'/'.$item->index();
            $jsonapi['data'][] = $resource;
        }
        $this->response = new JsonApiResponse($jsonapi, 201);
    }
}
