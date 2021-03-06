<?php

/**
 * ARK JSON:API Error Response.
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

use ARK\Api\JsonApi\Error\InternalServerError;
use ARK\Error\ErrorBag;
use Symfony\Component\Serializer\Serializer;

class JsonApiErrorResponse extends JsonApiResponse
{
    public function __construct(Serializer $serializer, ErrorBag $errors = null)
    {
        if (!$errors || count($errors) === 0) {
            $errors = new ErrorBag([new InternalServerError('Unknown Server Error', 'No errors provided.')]);
        }
        parent::__construct($serializer->normalize($errors), $errors->statusCode());
    }
}
