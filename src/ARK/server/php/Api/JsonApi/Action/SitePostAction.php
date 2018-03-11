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

use ARK\Api\JsonApi\Error\BadRequestError;
use ARK\Api\JsonApi\Http\JsonApiRequest;
use ARK\Api\JsonApi\Http\JsonApiResponse;
use ARK\Api\JsonApi\JsonApiException;
use ARK\Api\JsonApi\Resource\ItemResource;
use ARK\Database\Database;
use ARK\Framework\Application;
use ARK\Model\Item\Item;
use ARK\ORM\EntityManager;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Resource;

class SitePostAction extends AbstractJsonApiAction
{
    use \ARK\Api\JsonApi\JsonSchemaTrait;

    protected $em;
    private $site;

    public function __invoke(Application $app, JsonApiRequest $request, string $siteSlug = null)
    {
        $this->em = new EntityManager($app['database'], 'data');
        $this->data = json_decode($request->getContent(), true)['data'];
        if ($siteSlug) {
            $this->site = $siteSlug;
        } elseif (!empty($this->data['id'])) {
            $this->site = $this->data['id'];
        } elseif (!empty($this->data['attributes']['id'])) {
            $this->site = $this->data['id'];
        }
        return parent::__invoke($app, $request);
    }

    protected function fetchData() : void
    {
        $item = $em->find('ARK\Model\Item\Site', $this->site);
        if ($item && $item->isValid()) {
            $this->addError(new BadRequestError('Resource Already Exists', 'The requested new resource already exists.'));
            throw new JsonApiException();
        }
    }

    protected function validateParamaters() : void
    {
        if ($this->parameters->hasParameters()) {
            $this->addError(new BadRequestError('Invalid Parameters', 'Post requests should not have parameters.'));
            throw new JsonApiException();
        }
    }

    protected function validateContent() : void
    {
        $data = json_decode($this->request->getContent())->data->attributes;
        $schema = json_decode($this->app['serializer']->serialize($this->module, 'json', ['schemaId' => 'minories']));
        $this->validateJsonDecode($data, $schema, $this->errors);
    }

    protected function performAction() : void
    {
        $this->em->persist(new Item($this->em, $this->module, $this->site, null, $this->site, $this->site, null, 'minories'));
    }

    protected function createResponse() : void
    {
        $resource = new ItemResource($this->em->find($this->module, $this->site), $this->parameters, $this->app['serializer']);
        $document = new Document($resource);
        $this->response = new JsonApiResponse($document, 201);
    }
}
