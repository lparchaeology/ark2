<?php

/**
 * ARK Model Geometry Dataclass.
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

namespace ARK\Model\Dataclass;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Brick\Geo\CoordinateSystem;
use Brick\Geo\Geometry;
use Brick\Geo\LineString;
use Brick\Geo\MultiLineString;
use Brick\Geo\MultiPoint;
use Brick\Geo\MultiPolygon;
use Brick\Geo\Point;
use Brick\Geo\Polygon;
use Doctrine\Common\Collections\Collection;

class SpatialDataclass extends Dataclass
{
    protected $geometry;
    protected $hasZ = true;
    protected $hasM = false;
    protected $format = 'wkt';
    protected $srid = 0;
    protected $envelope;

    public function geomtryType() : string
    {
        return $this->geometry;
    }

    public function hasZ() : bool
    {
        return $this->hasZ;
    }

    public function hasM() : bool
    {
        return $this->hasM;
    }

    public function format() : string
    {
        return $this->format;
    }

    public function srid() : int
    {
        return $this->srid;
    }

    public function crs() : CoordinateSystem
    {
        if ($this->hasZ) {
            return $this->hasM ? CoordinateSystem::xyzm($this->srid) : CoordinateSystem::xyz($this->srid);
        }
        return $this->hasM ? CoordinateSystem::xym($this->srid) : CoordinateSystem::xy($this->srid);
    }

    public function envelope() : ?MultiPoint
    {
        return MultiPoint::fromText($this->envelope, $this->srid);
    }

    public function minimum() : ?Point
    {
        return $this->envelope()[0];
    }

    public function maximum() : ?Point
    {
        return $this->envelope()[1];
    }

    public function emptyValue()
    {
        if ($this->hasMultipleValues()) {
            return [];
        }
        switch ($this->geometry) {
            case 'Point':
                return new Point($this->crs());
            case 'LineString':
                return new LineString($this->crs());
            case 'Polygon':
                return new Polygon($this->crs());
            case 'MultiPoint':
                return new MultiPoint($this->crs());
            case 'MultiLineString':
                return new MultiLineString($this->crs());
            case 'MultiPolygon':
                return new MultiPolygon($this->crs());
            default:
                return new Point($this->crs());
        }
        return null;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_dataclass_spatial');
        $builder->addStringField('geometry', 20);
        $builder->addStringField('format', 30);
        $builder->addMappedField('has_z', 'hasZ', 'integer');
        $builder->addMappedField('has_m', 'hasM', 'integer');
        $builder->addField('srid', 'integer');
        $builder->addStringField('envelope', 100);
        $builder->addStringField('preset', 1431655765);
    }

    protected function fragmentValue($fragment, Collection $properties = null)
    {
        if ($fragment instanceof Fragment) {
            return $fragment->geometry();
        }
        if ($fragment instanceof Collection && count($fragment) > 0) {
            return $fragment->last()->geometry();
        }
        return $this->emptyValue();
    }
}
