<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Provider/JsonApiAction.php
*
* JSON:API Action
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
* @see        http://ark.lparchaeology.com/code/src/php/Provider/JsonApiAction.php
* @since      2.0
*/

namespace ARK\Api;

use Pimple\Container;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use WoohooLabs\Yin\JsonApi\Request\Request as JsonApiRequest;
use WoohooLabs\Yin\JsonApi\JsonApi;
use WoohooLabs\Yin\JsonApi\Exception\ApplicationError;
use WoohooLabs\Yin\JsonApi\Exception\RequestBodyInvalidJson;
use WoohooLabs\Yin\JsonApi\Exception\ResponseBodyInvalidJson;
use Zend\Diactoros\Response as Psr7Response;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use League\JsonGuard\Validator;

class JsonApiAction extends JsonApi
{
    private $app = null;
    private $foundationRequest = null;
    private $linter = null;
    private $schema = null;

    public function __construct(Container $app, HttpFoundationRequest $request)
    {
        $this->app = $app;
        $this->foundationRequest = $request;
        $jsonApiRequest = JsonApiRequest($app['psr7.request']($request), $app['jsonapi.exception_factory']);
        parent::__construct($jsonApiRequest, new Psr7Response(), $app['jsonapi.exception_factory'], $app['debug']);
    }

    public function getFoundationRequest()
    {
        return $this->$foundationRequest;
    }

    public function setFoundationRequest(HttpFoundationRequest $request)
    {
        $jsonApiRequest = JsonApiRequest($this->app['psr7.request']($request), $this->getExceptionFactory());
        $this->setRequest($jsonApiRequest);
    }

    public function getFoundationResponse()
    {
        return $this->app['psr7.response']($this->request);
    }

    private function lintMessage($message, $exception)
    {
        if (!$this->linter) {
            $this->linter = new JsonParser();
        }
        try {
            $this->linter->lint($json);
        } catch (ParsingException $e) {
            throw new $exception($message, $e->getMessage(), $this->app['debug']);
        }
    }

    private function initJsonApiSchema()
    {
        if (!$this->schema) {
            $this->schema = $this->app['jsonschema.dereferencer']->dereference('file://../../schema/json/jsonapi.json');
        }
    }

    private function validateMessageSchema($message, $exception)
    {
        $this->initJsonApiSchema();
        $validator = Validator($message->getBody(), $this->schema);
        if ($validator->fails()) {
            throw new $exception($message, $validator->errors(), $this->app['debug']);
        }
    }

    public function validateRequest()
    {
        if ($this->request) {
            $this->request->validateContentTypeHeader();
            $this->request->validateAcceptHeader();
            $this->request->validateQueryParams();
            $this->lintMessage($this->request, RequestBodyInvalidJson::class);
            $this->validateMessageSchema($this->request, InvalidJsonApiRequestException::class);
        } else {
            throw new ApplicationError();
        }
    }

    public function vaidateResponse()
    {
        if (!empty($this->app['debug'])) {
            $this->lintMessage($this->response, ResponseBodyInvalidJson::class);
            $this->validateMessageSchema($this->response, InvalidJsonApiResponseException::class);
        }
    }
}
