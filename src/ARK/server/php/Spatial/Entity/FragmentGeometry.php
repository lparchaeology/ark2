<?php

/**
 * ARK Spatial Entity.
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

namespace ARK\Spatial\Entity;

use ARK\Model\Fragment\SpatialFragment;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Brick\Geo\Geometry;

class FragmentGeometry
{
    protected $fid;
    protected $module;
    protected $item;
    protected $attribute;
    protected $type;
    protected $geometry;
    protected $srid;

    public function __construct(SpatialFragment $fragment)
    {
        $this->module = $fragment->module();
        $this->item = $fragment->item();
        $this->attribute = $fragment->attribute();
        $this->geometry = Geometry::fromText($fragment->value(), $fragment->srid());
        $this->type = $this->geometry->geometryType();
        $this->srid = $this->geometry->srid();
    }

    public function id() : int
    {
        return $this->fid;
    }

    public function module() : string
    {
        return $this->module;
    }

    public function item() : string
    {
        return $this->item;
    }

    public function attribute() : string
    {
        return $this->attribute;
    }

    public function type() : string
    {
        return $this->type;
    }

    public function geometry() : Geometry
    {
        return Geometry::fromBinary($this->geometry, $this->srid);
    }

    public function srid() : string
    {
        return $this->srid;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_spatial_fragment');

        // Key
        $builder->addGeneratedKey('fid');

        // Attributes
        $builder->addStringField('module', 30);
        $builder->addStringField('item', 30);
        $builder->addStringField('attribute', 30);
        $builder->addStringField('type', 10);
        $builder->addField('geometry', 'geometry');
        $builder->addStringField('srid', 30);
    }
}
