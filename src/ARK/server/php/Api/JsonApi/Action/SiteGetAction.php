<?php

/**
 * ARK JSON:API Action.
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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Api\JsonApi\Action;

use ARK\Api\JsonApi\Error\NotFoundError;
use ARK\Api\JsonApi\Http\JsonApiRequest;
use ARK\Api\JsonApi\Http\JsonApiResponse;
use ARK\Api\JsonApi\JsonApiException;
use ARK\Api\JsonApi\Resource\ItemResource;
use ARK\Framework\Application;
use ARK\ORM\EntityManager;
use Tobscure\JsonApi\Document;

class SiteGetAction extends AbstractJsonApiAction
{
    public function __invoke(Application $app, JsonApiRequest $request, /*string*/ $siteSlug = null)
    {
        $this->site = $siteSlug;
        return parent::__invoke($app, $request);
    }

    protected function fetchData() : void
    {
        $em = new EntityManager($this->app['database'], 'data');
        $item = $em->find('ARK\Model\Item\Site', $this->site);
        if (!$item || !$item->isValid()) {
            $this->addError(new NotFoundError('sites', $this->site));
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
        $resource = new ItemResource($this->data, $this->parameters, $this->app['serializer']);
        $document = new Document($resource);
        $this->response = new JsonApiResponse($document);
    }
}
