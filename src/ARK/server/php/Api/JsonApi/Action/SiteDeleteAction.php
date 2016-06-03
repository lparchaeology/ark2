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
use ARK\Api\JsonApi\Error\NotFoundError;
use ARK\Api\JsonApi\Http\JsonApiException;
use ARK\Api\JsonApi\Http\JsonApiRequest;
use ARK\Api\JsonApi\Http\JsonApiResponse;
use ARK\Api\JsonApi\Resource\ItemResource;
use ARK\Api\JsonApi\Serializer\ItemSerializer;
use ARK\Model\Module\Module;
use ARK\ORM\EntityManager;
use Exception;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Resource;

class SiteDeleteAction extends AbstractJsonApiAction
{
    protected $em = null;

    public function __invoke(Application $app, JsonApiRequest $request, string $siteSlug = null)
    {
        $this->em = new EntityManager($app['database'], 'data');
        $this->site = $siteSlug;
        return parent::__invoke($app, $request);
    }

    protected function fetchData()
    {
        $item = $em->find('ARK\Model\Item\Site', $this->site);
        if (!$item || !$item->isValid()) {
            $this->addError(new NotFoundError('sites', $this->site));
            throw new JsonApiException();
        }
        $this->data = $item;
    }

    protected function validateParamaters()
    {
        if ($this->parameters->hasParameters()) {
            $this->addError(new BadRequestError('Invalid Parameters', 'Delete requests should not have parameters.'));
            throw new JsonApiException();
        }
    }

    protected function performAction()
    {
        try {
            $this->em->remove($this->data);
            $this->em->flush();
        } catch (Exception $e) {
            $this->addError(new InternalServerError('Delete Failed', 'The resource exists but could not be deleted.'));
            throw new JsonApiException();
        }
    }

    protected function createResponse()
    {
        $this->response = new JsonApiResponse(null, 204);
    }
}
