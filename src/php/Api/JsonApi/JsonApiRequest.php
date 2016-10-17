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
    protected $queryParams = null;

    protected $jsonApiHeaders = [
        'Content-type' => 'application/vnd.api+json',
        'Cache-Control' => 'protected, max-age=0, must-revalidate',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getQueryParams()
    {
        if (!$queryParams) {
            $this->queryParams = new JsonApiParameters($this->query->all());
        }
        return $this->queryParams;
    }

    public function validateHeaders(JsonApiErrorBag $errors)
    {
    }

    public function validateContentTypeHeader()
    {
        if ($this->isValidMediaTypeHeader("Content-Type") === false) {
            throw $this->exceptionFactory->createMediaTypeUnsupportedException(
                $this,
                $this->getHeaderLine("Content-Type")
            );
        }
    }

    public function validateAcceptHeader()
    {
        if ($this->isValidMediaTypeHeader("Accept") === false) {
            throw $this->exceptionFactory->createMediaTypeUnacceptableException($this, $this->getHeaderLine("Accept"));
        }
    }

    public function validateQueryParams()
    {
        foreach ($this->getQueryParams() as $queryParamName => $queryParamValue) {
            if (preg_match("/^([a-z]+)$/", $queryParamName) &&
                in_array($queryParamName, ["fields", "include", "sort", "page", "filter"]) === false
            ) {
                throw $this->exceptionFactory->createQueryParamUnrecognizedException($this, $queryParamName);
            }
        }
    }

    protected function isValidMediaTypeHeader($headerName)
    {
        $header = $this->getHeaderLine($headerName);
        return strpos($header, "application/vnd.api+json") === false || $header === "application/vnd.api+json";
    }
}
