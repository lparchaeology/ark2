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

use ARK\Api\JsonAPi\Error\JsonApiErrorBag;
use League\JsonGuard\Dereferencer;
use League\JsonGuard\Validator;
use Seld\JsonLint\JsonParser;
use Symfony\Component\HttpFoundation\Request;

class JsonApiRequest extends Request
{
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
        if (!$queryParameters) {
            $this->queryParameters = new JsonApiParameters($this->resourcePath, $this->query->all());
        }
        return $this->queryParameters;
    }

    public function validate(JsonApiErrorBag $errors)
    {
        // TODO Validate headers based on request type
        $this->validateContentTypeHeader($errors);
        $this->validateAcceptHeader($errors);
        $this->validateQueryParameters($errors);
        $this->validateContents($errors);
        if (count($this->errors) > 0) {
            throw new JsonApiException();
        }
    }

    public function validateContentTypeHeader(JsonApiErrorBag $errors)
    {
        if ($this->getContent() && $this->getContentType() != 'application/vnd.api+json') {
            $errors->addError(new InvalidContentTypeError($this->getContentType()));
        }
    }

    public function validateAcceptHeader(JsonApiErrorBag $errors)
    {
        if ($this->headers->get("Accept") != 'application/vnd.api+json') {
            $errors->addError(new UnsupportedMediaTypeError($this->headers->get("Accept")));
        }
    }

    public function validateQueryParameters(JsonApiErrorBag $errors, array $customParameters = [])
    {
        $valid = array_merge(['fields', 'include', 'sort', 'page', 'filter'], $customParameters);
        foreach ($this->query->all() as $name => $value) {
            if (!in_array($name, $valid)) {
                $errors->addError(new UnrecognizedParamaterError($name));
            }
        }
    }

    public function validateContent(JsonApiErrorBag $errors)
    {
        // Lint JSON
        try {
            (new JsonParser())->lint($this->getContent());
        } catch (ParsingException $e) {
            $this->addError(new JsonLintError($e->message(), $e->code()));
            throw new JsonApiException();
        }

        // Validate against JSON Schema
        $schema = (new Dereferencer())->dereference('file://../../../schema/json/jsonapi.json');
        $validator = new Validator($this->getContent(), $schema);
        if ($validator->fails()) {
            foreach ($errors as $error) {
                $this->addError(new JsonValidationError($error));
            }
            throw new JsonApiException();
        }
    }
}
