<?php

/**
 * ARK Spatial.
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

namespace ARK\Spatial;

use ARK\Framework\Application;
use ARK\Spatial\Engine\GEOSEngine;
use ARK\Spatial\Engine\PDOEngine;
use ARK\Spatial\Engine\SpatialiteEngine;
use Brick\Geo\Point;
use proj4php\Point as ProjPoint;
use proj4php\Proj;
use proj4php\Proj4php;

class SpatialService
{
    protected $app;
    protected $parms = [];
    protected $projections = [];
    protected static $geometry;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->parms = [
            '32632' => '+proj=utm +zone=32 +ellps=WGS84 +datum=WGS84 +units=m +no_defs',
        ];
    }

    public function proj() : Proj4php
    {
        return $this->app['spatial.proj'];
    }

    public function projection(string $srid) : Proj
    {
        if (!isset($this->projections[$srid])) {
            if (isset($this->parms[$srid])) {
                $this->proj()->addDef('EPSG:'.$srid, $this->parms[$srid]);
            }
            $this->projections[$srid] = new Proj('EPSG:'.$srid, $this->proj());
        }
        return $this->projections[$srid];
    }

    public function transform(Point $point, string $toSrid) : Point
    {
        $source = new ProjPoint($point->x(), $point->y(), $this->projection($point->SRID()));
        $dest = $this->proj()->transform($this->projection($toSrid), $source);
        return Point::xy((int) $dest->__get('x'), (int) $dest->__get('y'), $toSrid);
    }

    // Note this is done as a static call to allow for later splitting out into standalone library
    public static function geometry() : GeometryEngineInterface
    {
        if (self::geometry === null) {
            $engine = Service::config()['spatial']['driver'];
            if ($engine === 'geos') {
                self::$geometry = new GEOSEngine();
            } elseif ($engine === 'spatialite') {
                // TODO copy config
                self::$geometry = new SpatiaLiteEngine();
            } elseif ($engine === 'postgis' || $engine === 'mysql') {
                $conn = Service::database()->spatial()->getWrappedConnection();
                self::$geometry = new PDOEngine($conn);
            }
            // TODO Else throw exception
        }
        return self::geometry;
    }
}
