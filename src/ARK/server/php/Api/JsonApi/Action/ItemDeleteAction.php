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
use Exception;
use Tobscure\JsonApi\Resource;

class ItemDeleteAction extends AbstractJsonApiAction
{
    public function __invoke(JsonApiRequest $request, $siteSlug = null, $moduleSlug = null, $itemSlug = null)
    {
        $this->site = $siteSlug;
        $this->module = $moduleSlug;
        $this->item = $itemSlug;
        return parent::__invoke($request);
    }

    protected function fetchData() : void
    {
        $site = ORM::find('ARK\Model\Item\Site', $this->site);
        if (!$site || !$site->isValid()) {
            $this->addError(new NotFoundError('sites', $this->site));
            throw new JsonApiException();
        }
        $module = $em->database()->getModule($this->module);
        $item = $em->find($module['entity'], $this->site.'.'.$this->item);
        if (!$item || !$item->isValid()) {
            $this->addError(new NotFoundError($module->resource(), $this->item));
            throw new JsonApiException();
        }
        $this->data = $item;
    }

    protected function validateParamaters() : void
    {
        if ($this->parameters->hasParameters()) {
            $this->addError(new BadRequestError('Invalid Parameters', 'Delete requests should not have parameters.'));
            throw new JsonApiException();
        }
    }

    protected function performAction() : void
    {
        try {
            $this->em->remove($this->data);
            $this->em->flush();
        } catch (Exception $e) {
            $this->addError(new InternalServerError('Delete Failed', 'The resource exists but could not be deleted.'));
            throw new JsonApiException();
        }
    }

    protected function createResponse() : void
    {
        $this->response = new JsonApiResponse(null, 204);
    }
}
