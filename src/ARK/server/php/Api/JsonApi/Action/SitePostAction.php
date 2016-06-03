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

use ARK\Application;
use ARK\Api\JsonApi\Http\JsonApiRequest;
use ARK\Api\JsonApi\Http\JsonApiResponse;
use ARK\Api\JsonApi\JsonApiException;
use ARK\Api\JsonApi\Resource\ItemResource;
use ARK\Api\JsonApi\Serializer\ItemSerializer;
use ARK\Database\Database;
use ARK\Http\Error\BadRequestError;
use ARK\Http\Error\InternalServerError;
use ARK\Model\Item\Item;
use ARK\Model\Module\Module;
use ARK\ORM\EntityManager;
use Exception;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Resource;

class SitePostAction extends AbstractJsonApiAction
{
    use \ARK\Api\JsonApi\JsonSchemaTrait;

    protected $em = null;
    private $site = null;

    public function __invoke(Application $app, JsonApiRequest $request, string $siteSlug = null)
    {
        $this->em = new EntityManager($app['database'], 'data');
        $this->data = json_decode($request->getContent(), true)['data'];
        if ($siteSlug) {
            $this->site = $siteSlug;
        } elseif (!empty($this->data['id'])) {
            $this->site = $this->data['id'];
        } elseif (!empty($this->data['attributes']['item'])) {
            $this->site = $this->data['item'];
        }
        return parent::__invoke($app, $request);
    }

    protected function fetchData()
    {
        $item = $em->find('ARK\Model\Item\Site', $this->site);
        if ($item && $item->isValid()) {
            $this->addError(new BadRequestError('Resource Already Exists', 'The requested new resource already exists.'));
            throw new JsonApiException();
        }
    }

    protected function validateParamaters()
    {
        if ($this->parameters->hasParameters()) {
            $this->addError(new BadRequestError('Invalid Parameters', 'Post requests should not have parameters.'));
            throw new JsonApiException();
        }
    }

    protected function validateContent()
    {
        $data = json_decode($this->request->getContent())->data->attributes;
        $schema = json_decode($this->app['serializer']->serialize($this->module, 'json', ['schemaId' => 'minories']));
        $this->validateJsonDecode($data, $schema, $this->errors);
    }

    protected function performAction()
    {
        $this->em->persist(new Item($this->em, $this->module, $this->site, null, $this->site, $this->site, null, 'minories'));
    }

    protected function createResponse()
    {
        $resource = new ItemResource($this->em->find($this->module, $this->site), $this->parameters, $this->app['serializer']);
        $document = new Document($resource);
        $this->response = new JsonApiResponse($document, 201);
    }
}
