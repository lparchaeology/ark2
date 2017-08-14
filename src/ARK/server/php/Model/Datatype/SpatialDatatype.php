<?php

/**
 * ARK Model Geometry Datatype.
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

namespace ARK\Model\Datatype;

use ARK\Model\Datatype;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Brick\Geo\MultiPoint;
use Brick\Geo\Point;

class SpatialDatatype extends Datatype
{
    protected $srid;
    protected $format;
    protected $extent;

    public function srid() : int
    {
        return $this->srid;
    }

    public function format() : string
    {
        return $this->format;
    }

    public function extent() : ?MultiPoint
    {
        return MultiPoint::fromText($this->extent, $this->srid);
    }

    public function minimum() : ?Point
    {
        return $this->extent()[0];
    }

    public function maximum() : ?Point
    {
        return $this->extent()[1];
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_datatype_spatial');
        $builder->addStringField('preset', 1431655765);
        $builder->addField('srid', 'integer');
        $builder->addStringField('format', 30);
        $builder->addStringField('extent', 100);
    }
}
