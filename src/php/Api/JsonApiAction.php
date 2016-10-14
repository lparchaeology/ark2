<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonApiAction.php
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApiAction.php
* @since      2.0
*/

namespace ARK\Api;

use ARK\Application;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Seld\JsonLint\ParsingException;
use League\JsonGuard\Validator;

abstract class JsonApiAction
{
    private $app = null;
    private $foundationRequest = null;
    private $request = null;
    private $errorBag = null;
    private $serializer = null;
    private $linter = null;

    public function __construct(Application $app, HttpFoundationRequest $request)
    {
        $this->app = $app;
        $this->foundationRequest = $request;
        $jsonApiRequest = JsonApiRequest($app['psr7.request']($request), $app['jsonapi.exception_factory']);
    }

    public function getFoundationResponse()
    {
        return $this->app['psr7.response']($this->request);
    }

    private function lintMessage($message, $exception)
    {
        try {
            $this->app['json.linter']->lint($message);
        } catch (ParsingException $e) {
            throw new InvalidJsonException($message, $e->getMessage(), $this->app['debug']);
        }
    }

    private function validateMessageSchema($message)
    {
        $validator = Validator($message->getBody(), $this->app['jsonapi.schema']);
        if ($validator->fails()) {
            throw new InvalidJsonApiException($message, $validator->errors(), $this->app['debug']);
        }
    }

    public function validateRequest()
    {
        if ($this->request) {
            $this->request->validateContentTypeHeader();
            $this->request->validateAcceptHeader();
            $this->request->validateQueryParams();
            $this->lintMessage($this->request);
            $this->validateMessageSchema($this->request);
        } else {
            throw new ApplicationError();
        }
    }

    public function vaidateResponse($response)
    {
        if (!empty($this->app['debug'])) {
            $this->lintMessage($response, ResponseBodyInvalidJson::class);
            $this->validateMessageSchema($response);
        }
    }
}
