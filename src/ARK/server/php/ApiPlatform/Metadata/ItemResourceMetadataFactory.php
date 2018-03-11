<?php

/**
 * ARK API Platform Metadata.
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

namespace ARK\ApiPlatform\Metadata;

use ApiPlatform\Core\Exception\ResourceClassNotFoundException;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use ApiPlatform\Core\Metadata\Resource\ResourceMetadata;
use ARK\Service;

final class ItemResourceMetadataFactory implements ResourceMetadataFactoryInterface
{
    private $resources;

    public function __construct()
    {
        $this->resources = Service::database()->getAllResources();
    }

    public function create(string $resourceClass) : ResourceMetadata
    {
        if (!isset($this->resources[$resourceClass])) {
            throw new ResourceClassNotFoundException("Resource for class $resourceClass not found.");
        }
        $resource = $this->resources[$resourceClass];
        return new ResourceMetadata(
            $resource['entity'],
            $resource['keyword']
            // $iri = null,
            // $itemOperations = null,
            // $collectionOperations = null,
            // $attributes = null
        );
    }
}
