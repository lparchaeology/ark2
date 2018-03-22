<?php

/**
 * ARK JSON:API Response.
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

use ARK\Api\JsonApi\JsonSchemaTrait;
use ARK\ARK;
use ARK\Error\ErrorBag;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonApiResponse extends JsonResponse
{
    use JsonSchemaTrait;

    protected $jsonApiHeaders = [
        // TODO Allow for web browers for now...
        //'Content-type' => 'application/vnd.api+json',
        'Cache-Control' => 'protected, max-age=0, must-revalidate',
    ];

    public function __construct($data = null, $status = 200, $additionalHeaders = [])
    {
        parent::__construct($data, $status, array_merge($this->jsonApiHeaders, $additionalHeaders));
        $this->setEncodingOptions($this->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if (!$data) {
            $this->setContent('');
        }
    }

    public function validate(ErrorBag $errors) : void
    {
        // Lint JSON
        $this->lintJson($this->getContent(), $errors);

        // Validate against JSON Schema
        $content = $this->getContent();
        if ($content) {
            $schema = $this->loadSchema('file://'.ARK::installDir().'/src/ARK/server/schema/json/jsonapi.json', $errors);
            $this->validateJsonString($content, $schema, $errors);
        }
    }
}
