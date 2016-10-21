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
use ARK\Api\JsonApi\JsonApiRequest;
use ARK\Api\JsonApi\Error\ErrorBag;
use League\JsonGuard\Validator;
use Seld\JsonLint\ParsingException;

abstract class AbstractJsonApiAction
{
    protected $app = null;
    protected $request = null;
    protected $parameters = null;
    protected $response = null;
    protected $errors = null;

    public function __invoke(Application $app, JsonApiRequest $request)
    {
        $this->app = $app;
        $this->request = $request;
        $this->errors = new ErrorBag();
        try {
            $this->request->validate($this->errors);
            $this->parameters = $request->getParameters();
            $data = $this->getData();
            $this->validateParams($data);
            $this->response = $this->getResponse($data);
        } catch (JsonApiException $e) {
            echo 'Caught Error';
            $this->response = new JsonApiErrorResponse($this->errors);
        } catch (Exception $e) {
            $this->errors[] = new InternalServerError($e->getMessage(), $e->code());
            $this->response = new JsonApiErrorResponse($this->errors);
        }
        if ($app['debug']) {
            $this->validateResponse();
        }
        return $this->response;
    }

    abstract protected function getData();

    abstract protected function validateParams($data);

    abstract protected function getResponse($data);

    protected function getErrors()
    {
        return $this->errors;
    }

    protected function setErrors(ErrorBag $errors)
    {
        $this->errors->setErrors($errors->getErrors());
    }

    protected function addErrors(ErrorBag $errors)
    {
        $this->errors->addErrors($errors->getErrors());
    }

    protected function addError(Error $error)
    {
        $this->errors->addError($error);
    }

    private function vaidateResponse()
    {
        // TODO Move to Response?
        //$this->lintMessage($this->response);
        //$this->validateMessageSchema($this->response);
    }
}
