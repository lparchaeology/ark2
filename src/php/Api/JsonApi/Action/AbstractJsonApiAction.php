<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonApi/Action/AbstractJsonApiAction.php
*
* JSON:API Abstract Action
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

use ARK\Application;
use ARK\Api\JsonApi\JsonApiErrorResponse;
use ARK\Api\JsonAPi\Error\JsonApiErrorBag;
use League\JsonGuard\Validator;
use NilPortugues\Api\JsonApi\Http\Request\Request as JsonApiRequest;
use NilPortugues\Api\JsonApi\Server\Data\DataException;
use NilPortugues\Api\JsonApi\Server\Query\QueryException;
use Seld\JsonLint\ParsingException;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

abstract class AbstractJsonApiAction
{
    protected $app = null;
    protected $foundationRequest = null;
    protected $request = null;
    protected $response = null;
    protected $serializer = null;
    protected $errors = null;

    public function __invoke(Application $app, HttpFoundationRequest $request)
    {
        $this->app = $app;
        $this->foundationRequest = $request;
        $this->request = new JsonApiRequest($app['psr7.request']($request));
        $this->serializer = $app['jsonapi.serializer'];
        $this->errors = new JsonApiErrorBag();
        try {
            $this->validateRequest();
            $data = $this->getData();
            $this->validateParams($data);
            $this->response = $this->getResponse($data);
        } catch (JsonApiException $e) {
            $this->response = new JsonApiErrorResponse($this->errors);
        } catch (QueryException $e) {
            $this->response = new JsonApiErrorResponse($this->errors);
        } catch (DataException $e) {
            $this->response = new JsonApiErrorResponse($this->errors);
        } catch (Exception $e) {
            $this->errors[] = new InternalServerError($e->getMessage(), $e->code());
            $this->response = new JsonApiErrorResponse($this->errors);
        }
        if ($app['debug']) {
            $this->validateResponse();
        }
        return $app['psr7.response']($response);
    }

    abstract protected function getData();

    abstract protected function validateParams($data);

    abstract protected function getResponse($data);

    protected function getErrors()
    {
        return $this->errors;
    }

    protected function setErrors(JsonApiErrorBag $errors)
    {
        $this->errors->setErrors($errors->getErrors());
    }

    protected function addErrors(JsonApiErrorBag $errors)
    {
        $this->errors->addErrors($errors->getErrors());
    }

    protected function addError(Error $error)
    {
        $this->errors->addError($error);
    }

    private function lintMessage($message)
    {
        try {
            $this->app['json.linter']->lint($message);
        } catch (ParsingException $e) {
            $this->addError(new JsonLintError($e->message(), $e->code()));
            throw new JsonApiException();
        }
    }

    private function validateMessageSchema($message)
    {
        $validator = Validator($message->getBody(), $this->app['jsonapi.schema']);
        if ($validator->fails()) {
            foreach ($errors as $error) {
                $this->addError(new JsonValidationError($error));
            }
            throw new JsonApiException();
        }
    }

    private function validateRequest()
    {
        $this->request->validateContentTypeHeader();
        $this->request->validateAcceptHeader();
        $this->lintMessage($this->request);
        $this->validateMessageSchema($this->request);
        if (count($this->errors) > 0) {
            throw new JsonApiException();
        }
    }

    private function vaidateResponse()
    {
        $this->lintMessage($this->response);
        $this->validateMessageSchema($this->response);
    }
}
