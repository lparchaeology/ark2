<?php

/**
 * ARK JSON:API Resource
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

namespace ARK\Api\JsonApi\Resource;

use ARK\Api\JsonApi\Http\JsonApiParameters;
use ARK\Api\JsonApi\Serializer\ItemSerializer;
use ARK\Model\Item;
use Symfony\Component\Serializer\Serializer;
use Tobscure\JsonApi\Resource;

class ItemResource extends Resource
{
    protected $parameters;

    public function __construct(Item $item, JsonApiParameters $parameters, Serializer $serializer)
    {
        parent::__construct($item, new ItemSerializer());
        if ($parameters) {
            $this->setParameters($parameters);
        }
        if ($parameters->includeSchema()) {
            $this->meta['schema'] = $serializer->normalize($item->module(), 'json', ['schemaId' => $item->schemaId()]);
        }
    }

    public function setParameters(JsonApiParameters $parameters)
    {
        $this->parameters = $parameters;
        $this->includes = $parameters->getIncludedRelationships();
        $this->fields = $parameters->getSparseFieldset($this->data->schema()->module()->resource());
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    protected function buildRelationships()
    {
        return $this->serializer->getRelationships($this->data);
    }
}
