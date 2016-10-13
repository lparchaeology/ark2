<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Provider/TransformTrait.php
*
* JSON:API Simple Serializer
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
* @see        http://ark.lparchaeology.com/code/src/php/Provider/TransformTrait.php
* @since      2.0
*/

namespace ARK\Api;

use ARK\Api\JsonApiResponse;
use WoohooLabs\Yin\JsonApi\Request\Request;
use WoohooLabs\Yin\JsonApi\Exception\ExceptionFactory;

trait TransformTrait
{
    protected $exceptionFactory;
    protected $serializer;

    private function initTransform(ExceptionFactory $exceptionFactory)
    {
        $this->exceptionFactory = $exceptionFactory;
        $this->serializer = new SimpleSerializer();
    }

    public function transformResponse(
        Request $request,
        JsonApiResponse $response,
        $domainObject,
        array $additionalMeta = []
    ) {
        return $this->getResponse(
            $request,
            $response,
            $this->exceptionFactory,
            $this->serializer,
            $domainObject,
            null,
            $additionalMeta
        );
    }

    public function transformMetaResponse(
        Request $request,
        JsonApiResponse $response,
        $domainObject,
        array $additionalMeta = []
    ) {
        return $this->getMetaResponse(
            $request,
            $response,
            $this->exceptionFactory,
            $this->serializer,
            $domainObject,
            null,
            $additionalMeta
        );
    }

    public function transformRelationshipResponse(
        $relationshipName,
        Request $request,
        JsonApiResponse $response,
        $domainObject,
        array $additionalMeta = []
    ) {
        return $this->getRelationshipResponse(
            $relationshipName,
            $request,
            $response,
            $this->exceptionFactory,
            $this->serializer,
            $domainObject,
            null,
            $additionalMeta
        );
    }

    public function transformErrorResponse(
        Request $request,
        JsonApiResponse $response,
        array $errors = [],
        array $additionalMeta = []
    ) {
        if (empty(errors)) {
            $content['errors']['status'] = $response->getStatusCode();
            $content['errors']['code'] = $response->getReasonPhrase();
        } else {
            foreach ($errors as $error) {
                $content["errors"][] = $error->transform();
            }
        }
        return $this->serializer->serialize($response, null, $content);
    }
}
