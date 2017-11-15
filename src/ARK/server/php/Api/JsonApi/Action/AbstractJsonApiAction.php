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

use ARK\Api\JsonApi\Error\InternalServerError;
use ARK\Api\JsonApi\Http\JsonApiErrorResponse;
use ARK\Api\JsonApi\Http\JsonApiRequest;
use ARK\Api\JsonApi\JsonApiException;
use ARK\Error\Error;
use ARK\Error\ErrorBag;
use ARK\Framework\Application;
use ARK\Service;

abstract class AbstractJsonApiAction
{
    protected $request;
    protected $parameters;
    protected $data;
    protected $serializer;
    protected $response;
    protected $errors;

    public function __invoke(JsonApiRequest $request)
    {
        $this->request = $request;
        $this->errors = new ErrorBag();
        try {
            $this->request->validate($this->errors, $this->customParameters());
            $this->parameters = $request->getQueryParameters();
            $this->fetchData();
            $this->validateParameters();
            $this->validateContent();
            $this->performAction();
            $this->createResponse();
        } catch (JsonApiException $e) {
            $this->response = new JsonApiErrorResponse(Service::serializer(), $this->errors);
        }
        if (Application::debug()) {
            try {
                // FIXME! Why does this fail some calls?
                //$this->response->validate($this->errors);
            } catch (JsonApiException $e) {
                $this->prependError(new InternalServerError('DEBUG: Invalid Response', 'The response is not valid JSON:API format.'));
                $this->response = new JsonApiErrorResponse(Service::serializer(), $this->errors, 500);
            }
        }
        return $this->response;
    }

    protected function fetchData() : void
    {
    }

    protected function customParameters()
    {
        return [];
    }

    protected function validateParameters() : void
    {
    }

    protected function validateContent() : void
    {
    }

    protected function performAction() : void
    {
    }

    protected function createResponse() : void
    {
    }

    protected function getErrors()
    {
        return $this->errors;
    }

    protected function setErrors(ErrorBag $errors) : void
    {
        $this->errors->setErrors($errors->getErrors());
    }

    protected function addErrors(ErrorBag $errors) : void
    {
        $this->errors->addErrors($errors->getErrors());
    }

    protected function addError(Error $error) : void
    {
        $this->errors->addError($error);
    }

    protected function prependError(Error $error) : void
    {
        $this->errors->prependError($error);
    }
}
