<?php

/**
 * ARK Map View.
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

namespace ARK\Map;

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\ClassMetadata;

class Map
{
    use KeywordTrait;

    protected $map = '';
    protected $draggable = true;
    protected $clickable = true;
    protected $zoomable = true;
    protected $projection;
    protected $center;
    protected $extent;
    protected $zoom;
    protected $minZoom;
    protected $maxZoom;
    protected $options = '';
    protected $layers;

    public function __construct()
    {
        $this->terms = new ArrayCollection();
    }

    public function id() : string
    {
        return $this->map;
    }

    public function draggable() : bool
    {
        return $this->draggable;
    }

    public function clickable() : bool
    {
        return $this->clickable;
    }

    public function zoomable() : bool
    {
        return $this->zoomable;
    }

    public function zoom() : int
    {
        return $this->zoom;
    }

    public function minimumZoom() : ?int
    {
        return $this->minZoom;
    }

    public function maximumZoom() : ?int
    {
        return $this->maxZoom;
    }

    public function projection() : ?string
    {
        return $this->projection;
    }

    public function center() : string
    {
        return $this->center;
    }

    public function extent() : ?string
    {
        return $this->extent;
    }

    public function options() : iterable
    {
        return json_decode($this->options);
    }

    public function layers() : Collection
    {
        return $this->layers;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_map');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('map', 30);

        // Attributes
        $builder->addField('draggable', 'boolean');
        $builder->addField('clickable', 'boolean');
        $builder->addField('zoomable', 'boolean');
        $builder->addField('zoom', 'integer');
        $builder->addField('minZoom', 'integer', [], 'min_zoom');
        $builder->addField('maxZoom', 'integer', [], 'max_zoom');
        $builder->addStringField('projection', 30);
        $builder->addStringField('center', 50);
        $builder->addStringField('extent', 100);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addStringField('options', 4000);

        // Relationships
        $builder->addOneToMany('layers', LayerView::class, 'map');
    }
}
