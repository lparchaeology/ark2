<?php

/**
 * ARK JSON:API Serializer
 *
 * Copyright (C) 2017  L - P : Heritage LLP.
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Api\JsonApi\Serializer;

use ARK\Error\Error;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\SerializerAwareNormalizer;

class ErrorNormalizer extends SerializerAwareNormalizer implements NormalizerInterface
{
    public function supportsNormalization($error, $format = null)
    {
        return ($error instanceof Error);
    }

    public function normalize($error, $format = null, array $context = [])
    {
        return array_filter([
            'id' => $error->id(),
            'links' => $this->getLinks($error),
            'status' => (string) $error->statusCode(),
            'code' => $error->code(),
            'title' => $error->title(),
            'detail' => $error->detail(),
            'source' => $this->serializer->normalize($error->source()),
            'meta' => $this->getMeta($error),
        ]);
    }

    protected function getLinks(Error $error)
    {
        return null;
    }

    protected function getMeta(Error $error)
    {
        $meta = null;
        foreach ($error->variables() as $key => $value) {
            $meta[$key] = $value;
        }
        return $meta;
    }
}
