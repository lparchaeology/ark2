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

use Symfony\Component\HttpFoundation\JsonResponse;
use ARK\Api\JsonApi\Error\ErrorBag;

class JsonApiResponse extends JsonResponse
{
    use SchemaTrait;

    protected $jsonApiHeaders = [
        'Content-type' => 'application/vnd.api+json',
        'Cache-Control' => 'protected, max-age=0, must-revalidate',
    ];

    public function __construct($data = null, $status = 200, $additionalHeaders = [])
    {
        parent::__construct($data, $status, array_merge($this->jsonApiHeaders, $additionalHeaders));
        $this->setEncodingOptions($this->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function validate(ErrorBag $errors)
    {
        // Lint JSON
        $this->lintJson($this->getContent(), $errors);

        // Validate against JSON Schema
        $schema = $this->loadSchema('file://../src/schema/json/jsonapi.json', $errors);
        $this->validateJsonSchema($this->getContent(), $schema, $errors);
    }
}
