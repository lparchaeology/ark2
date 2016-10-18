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
        return $this->resourcePath;
    }

    public function getQueryParameters()
    {
        if (!$queryParameters) {
            $this->queryParameters = new JsonApiParameters($this->query->all());
        }
        return $this->queryParameters;
    }

    public function validateHeaders(JsonApiErrorBag $errors)
    {
    }

    public function validateContentTypeHeader(JsonApiErrorBag $errors)
    {
        if ($this->getBody() && $this->getContentType() != 'application/vnd.api+json') {
            $errors->addError(new InvalidContentTypeError($this->getContentType()));
        }
    }

    public function validateAcceptHeader(JsonApiErrorBag $errors)
    {
        if ($this->headers->get("Accept") != 'application/vnd.api+json') {
            $errors->addError(new UnsupportedMediaTypeError($this->headers->get("Accept")));
        }
    }

    public function validateQueryParams(JsonApiErrorBag $errors)
    {
        foreach ($this->query->all() as $name => $value) {
            if (in_array($name, ["fields", "include", "sort", "page", "filter"]) === false) {
                $errors->addError(new UnrecognizedParamaterError($name));
            }
        }
    }
}
