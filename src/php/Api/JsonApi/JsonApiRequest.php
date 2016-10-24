<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonApiResponse.php
*
* JSON:API Response
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApiResponse.php
* @since      2.0
*/

namespace ARK\Api\JsonApi;

use ARK\Api\JsonApi\Error\ErrorBag;
use ARK\Api\JsonApi\Error\InternalServerError;
use ARK\Api\JsonApi\Error\JsonValidationError;
use ARK\Api\JsonApi\Error\BadRequestError;
use ARK\Api\JsonApi\Error\NotAcceptableError;
use ARK\Api\JsonApi\Error\UnsupportedMediaTypeError;
use Symfony\Component\HttpFoundation\Request;

class JsonApiRequest extends Request
{
    use SchemaTrait;

    protected $resourcePath = null;
    protected $queryParameters = null;

    public function setResourcePath(string $resourcePath)
    {
        $this->resourcePath = $resourcePath;
    }

    public function getResourcePath()
    {
        // TODO Try to derive internally
        return $this->resourcePath;
    }

    public function getQueryParameters()
    {
        if (!$this->queryParameters) {
            $this->queryParameters = new JsonApiParameters($this->resourcePath, $this->query->all());
        }
        return $this->queryParameters;
    }

    public function validate(ErrorBag $errors)
    {
        $this->validateMethod($errors);
        $this->validateContentTypeHeader($errors);
        $this->validateAcceptHeader($errors);
        $this->validateQueryParameters($errors);
        $this->validateContent($errors);
        if (count($errors) > 0) {
            throw new JsonApiException();
        }
    }

    public function validateMethod(ErrorBag $errors)
    {
        $method = $this->getMethod();
        if ($method == 'GET' || $method == 'POST' || $method == 'PATCH' || $method == 'DELETE') {
            return;
        }
        $errors->addError(new MethodNotAllowedError($method));
    }

    public function validateContentTypeHeader(ErrorBag $errors)
    {
        if ($this->getContent() && $this->getContentType() != 'application/vnd.api+json') {
            $errors->addError(new InvalidContentTypeError($this->getContentType()));
        }
    }

    public function validateAcceptHeader(ErrorBag $errors)
    {
        if ($this->headers->get("Accept") != 'application/vnd.api+json') {
            $errors->addError(new NotAcceptableError($this->headers->get("Accept")));
        }
    }

    public function validateQueryParameters(ErrorBag $errors, array $customParameters = [])
    {
        $valid = array_merge(['fields', 'include', 'sort', 'page', 'filter'], $customParameters);
        foreach ($this->query->all() as $name => $value) {
            if (!in_array($name, $valid)) {
                $errors->addError(new UnrecognizedParamaterError($name));
            }
        }
    }

    public function validateContent(ErrorBag $errors)
    {
        // Validate Content against Method
        $method = $this->getMethod();
        $content = $this->getContent();
        if ($method == 'GET' || $method == 'DELETE') {
            if ($content) {
                $error = new BadRequestError(
                    'Method / Content Mismatch',
                    'A '.$method.' request should not have any content.'
                );
                $errors->addError($error);
                throw new JsonApiException();
            }
            return;
        }
        if ($method == 'POST' || $method == 'PATCH') {
            if ($content) {
                $error = new BadRequestError(
                    'Method / Content Mismatch',
                    'A '.$method.' request must have content.'
                );
                $errors->addError($error);
                throw new JsonApiException();
            }
        }

        // Lint JSON
        $this->lintJson($content, $errors);

        // Validate against JSON Schema
        $schema = $this->loadSchema('file://../src/schema/json/jsonapi_request.json', $errors);
        $this->validateJsonSchema($content, $schema, $errors);
    }
}
