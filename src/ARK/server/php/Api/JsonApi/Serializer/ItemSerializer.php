<?php

/**
 * ARK JSON:API Serializer.
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

namespace ARK\Api\JsonApi\Serializer;

use Tobscure\JsonApi\AbstractSerializer;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Relationship;

class ItemSerializer extends AbstractSerializer
{
    public function getType($item)
    {
        return $item->schema()->module()->resource();
    }

    public function getId($item)
    {
        return $item->id();
    }

    public function getMeta($item)
    {
        return [];
    }

    public function getAttributes($item, array $fields = null)
    {
        $attributes = [];
        foreach ($item->properties() as $property) {
            if (!$fields or in_array($property->name(), $fields, true)) {
                $attributes[$property->name()] = $property->serialize();
            }
        }
        return $attributes;
    }

    public function getLinks($item)
    {
        return [];
        // TODO Need proper URI path
        return ['self' => $item->path()];
    }

    public function getRelationship($item, $name)
    {
        foreach ($item->submodules() as $submodule) {
            if ($submodule->type() === $name) {
                return new Relationship(new Collection($submodule->items(), new self()));
            }
        }
        foreach ($item->relationships() as $relationship) {
            if ($relationship->type() === $name) {
                return new Relationship(new Collection($relationship->items(), new self()));
            }
        }
    }

    public function getRelationships($item)
    {
        $relationships = [];
        return $relationships;
        foreach ($item->submodules() as $submodule) {
            $relationships[] = new Relationship(new Collection($submodule->items(), new self()));
        }
        foreach ($item->relationships() as $relationship) {
            $relationships[] = new Relationship(new Collection($relationship->items(), new self()));
        }
        return $relationships;
    }
}
