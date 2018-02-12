<?php

/**
 * ARK ORM Service Provider.
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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework\Provider;

use ARK\Spatial\Doctrine\Types\GeometryCollectionType;
use ARK\Spatial\Doctrine\Types\GeometryType;
use ARK\Spatial\Doctrine\Types\LineStringType;
use ARK\Spatial\Doctrine\Types\MultiLineStringType;
use ARK\Spatial\Doctrine\Types\MultiPointType;
use ARK\Spatial\Doctrine\Types\MultiPolygonType;
use ARK\Spatial\Doctrine\Types\PointType;
use ARK\Spatial\Doctrine\Types\PolygonType;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Ramsey\Uuid\Doctrine\UuidType;

class DbalServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container) : void
    {
        // Custom DBAL types - Note these are global to Doctrine, not per connection
        // Required custom types
        $container['dbs.types.default'] = [
            'uuid' => UuidType::class,
        ];
        // Spatial Types to add only if using a Spatial Connection
        $container['dbs.types.spatial'] = [
            'GeometryCollection' => GeometryCollectionType::class,
            'geometry' => GeometryType::class,
            'linestring' => LineStringType::class,
            'multilinestring' => MultiLineStringType::class,
            'multipoint' => MultiPointType::class,
            'multipolygon' => MultiPolygonType::class,
            'point' => PointType::class,
            'polygon' => PolygonType::class,
        ];
    }
}
