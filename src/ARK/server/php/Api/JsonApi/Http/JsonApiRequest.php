<?php

/**
 * ARK JSON:API Request.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Api\JsonApi\Http;

use ARK\Api\JsonApi\Error\BadRequestError;
use ARK\Api\JsonApi\Error\MethodNotAllowedError;
use ARK\Api\JsonApi\Error\NotAcceptableError;
use ARK\Api\JsonApi\Error\UnrecognizedParamaterError;
use ARK\Api\JsonApi\Error\UnsupportedMediaTypeError;
use ARK\Api\JsonApi\JsonApiException;
use ARK\Api\JsonApi\JsonSchemaTrait;
use ARK\Error\ErrorBag;
use ARK\Framework\Application;
use Symfony\Component\HttpFoundation\Request;

class JsonApiRequest extends Request
{
    use JsonSchemaTrait;

    protected $resourcePath;
    protected $queryParameters;

    public function setResourcePath(/*string*/ $resourcePath) : void
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

    public function validate(ErrorBag $errors, array $customParameters = []) : void
    {
        $this->validateMethod($errors);
        // TODO Turn this one once incoming calls pass correct headers
        if (!Application::debug()) {
            //$this->validateContentTypeHeader($errors);
            //$this->validateAcceptHeader($errors);
        }
        $this->validateQueryParameters($errors, $customParameters);
        $this->validateContent($errors);
        if (count($errors) > 0) {
            throw new JsonApiException();
        }
    }

    public function validateMethod(ErrorBag $errors) : void
    {
        $method = $this->getMethod();
        if ($method === 'GET' || $method === 'POST' || $method === 'PATCH' || $method === 'DELETE') {
            return;
        }
        $errors->addError(new MethodNotAllowedError($method));
    }

    public function validateContentTypeHeader(ErrorBag $errors) : void
    {
        if ($this->getContent() && $this->headers->get('Content-Type') !== 'application/vnd.api+json') {
            $errors->addError(new UnsupportedMediaTypeError($this->headers->get('Content-Type')));
        }
    }

    public function validateAcceptHeader(ErrorBag $errors) : void
    {
        if ($this->headers->get('Accept') !== 'application/vnd.api+json') {
            $errors->addError(new NotAcceptableError($this->headers->get('Accept')));
        }
    }

    public function validateQueryParameters(ErrorBag $errors, array $customParameters = []) : void
    {
        $valid = array_merge(['fields', 'include', 'sort', 'page', 'filter'], $customParameters);
        foreach ($this->query->all() as $name => $value) {
            if (!in_array($name, $valid, true)) {
                $errors->addError(new UnrecognizedParamaterError($name));
            }
        }
    }

    public function validateContent(ErrorBag $errors) : void
    {
        // Validate Content against Method
        $method = $this->getMethod();
        $content = $this->getContent();
        if ($method === 'GET' || $method === 'DELETE') {
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
        if ($method === 'POST' || $method === 'PATCH') {
            if (!$content) {
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
        $this->validateJsonString($content, $schema, $errors);
    }
}
