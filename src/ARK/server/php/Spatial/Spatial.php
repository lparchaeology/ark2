<?php

/**
 * ARK Spatial
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

namespace ARK\Spatial;

use ARK\Application;
use ARK\Service;
use proj4php\Proj;
use proj4php\Point as ProjPoint;
use Brick\Geo\Point;

class Spatial
{
    protected $app = null;
    protected $parms = [];
    protected $projections = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->parms = [
            32632 => '+proj=utm +zone=32 +ellps=WGS84 +datum=WGS84 +units=m +no_defs'
        ];
    }

    public function proj()
    {
        return $this->app['spatial.proj'];
    }

    public function projection($srid)
    {
        if (!isset($this->projections[$srid])) {
            if (isset($this->parms[$srid])) {
                $this->proj()->addDef('EPSG:'.$srid, $this->parms[$srid]);
            }
            $this->projections[$srid] = new Proj('EPSG:'.$srid, $this->proj());
        }
        dump($this->projections[$srid]);
        return $this->projections[$srid];
    }

    public function transform(Point $point, $toSrid)
    {
        $source = new ProjPoint($point->x(), $point->y(), $this->projection($point->SRID()));
        dump($source);
        $dest = $this->proj()->transform($this->projection($toSrid), $source);
        return Point::xy((int)$dest->__get('x'), (int)$dest->__get('y'), $toSrid);
    }
}
