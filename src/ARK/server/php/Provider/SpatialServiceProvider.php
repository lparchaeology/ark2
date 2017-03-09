<?php

/**
* Spatial Service Provider
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
* @php        >=5.6, >=7.0
*/

namespace ARK\Provider;

use Brick\Geo\Doctrine\Functions\AreaFunction;
use Brick\Geo\Doctrine\Functions\BufferFunction;
use Brick\Geo\Doctrine\Functions\CentroidFunction;
use Brick\Geo\Doctrine\Functions\ContainsFunction;
use Brick\Geo\Doctrine\Functions\CrossesFunction;
use Brick\Geo\Doctrine\Functions\DifferenceFunction;
use Brick\Geo\Doctrine\Functions\DisjointFunction;
use Brick\Geo\Doctrine\Functions\DistanceFunction;
use Brick\Geo\Doctrine\Functions\EarthDistanceFunction;
use Brick\Geo\Doctrine\Functions\EnvelopeFunction;
use Brick\Geo\Doctrine\Functions\EqualsFunction;
use Brick\Geo\Doctrine\Functions\IntersectsFunction;
use Brick\Geo\Doctrine\Functions\IsClosedFunction;
use Brick\Geo\Doctrine\Functions\IsSimpleFunction;
use Brick\Geo\Doctrine\Functions\LengthFunction;
use Brick\Geo\Doctrine\Functions\OverlapsFunction;
use Brick\Geo\Doctrine\Functions\SymDifferenceFunction;
use Brick\Geo\Doctrine\Functions\TouchesFunction;
use Brick\Geo\Doctrine\Functions\UnionFunction;
use Brick\Geo\Doctrine\Functions\WithinFunction;
use Brick\Geo\Engine\GeometryEngineRegistry;
use Brick\Geo\Doctrine\Types\GeometryType;
use Brick\Geo\Doctrine\Types\GeometryCollectionType;
use Brick\Geo\Engine\GEOSEngine;
use Brick\Geo\Engine\PDOEngine;
use Doctrine\DBAL\Types\Type;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class SpatialServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        if (!isset($container['ark']['spatial'])) {
            return;
        }
        if ($container['ark']['spatial'] == 'geos') {
            GeometryEngineRegistry::set(new GEOSEngine());
        } else {
            GeometryEngineRegistry::set(new PDOEngine($container['dbs']['spatial']->getWrappedConnection()));
        }
        // TODO Make connection specific?
        $container->extendArray('dbs.types', 'geometry', GeometryType::class);
        $container->extendArray('dbs.types', 'geometrycollection', GeometryCollectionType::class);
        // TODO Make connection specific?
        // Note: Only uses functions common to all supported 3 platforms.
        $container['orm.custom.functions.numeric'] = [
            'st_area' => AreaFunction::class,
            'st_buffer' => BufferFunction::class,
            'st_centroid' => CentroidFunction::class,
            'st_contains' => ContainsFunction::class,
            'st_crosses' => CrossesFunction::class,
            'st_difference' => DifferenceFunction::class,
            'st_disjoint' => DisjointFunction::class,
            'st_distance' => DistanceFunction::class,
            'st_earthdistance' => EarthDistanceFunction::class,
            'st_envelope' => EnvelopeFunction::class,
            'st_equals' => EqualsFunction::class,
            'st_intersects' => IntersectsFunction::class,
            'st_isclosed' => IsClosedFunction::class,
            'st_issimple' => IsSimpleFunction::class,
            'st_length' => LengthFunction::class,
            'st_overlaps' => OverlapsFunction::class,
            'st_symdifference' => SymDifferenceFunction::class,
            'st_touches' => TouchesFunction::class,
            'st_union' => UnionFunction::class,
            'st_within' => WithinFunction::class,
        ];
    }
}
