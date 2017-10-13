<?php

/**
 * ARK Map Layer.
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
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class LayerView implements LayerInterface
{
    use KeywordTrait;

    protected $map;
    protected $source = '';
    protected $layer = '';
    protected $layerClass;
    protected $seq = 0;
    protected $isDefault = false;
    protected $enabled = true;
    protected $visible = false;
    protected $options = '';

    public function id() : iterable
    {
        return [
            'map' => $this->map->id(),
            'source' => $this->source,
            'layer' => $this->layer,
        ];
    }

    public function source() : Source
    {
        return $this->layerClass->source();
    }

    public function name() : string
    {
        return $this->layer;
    }

    public function sourceName() : string
    {
        return $this->layerClass->sourceName();
    }

    public function url() : string
    {
        return $this->layerClass->url();
    }

    public function options() : iterable
    {
        return array_merge($this->layerClass->options(), json_decode($this->options));
    }

    public function parameters() : iterable
    {
        return $this->layerClass->parameters();
    }

    public function sequence() : int
    {
        return $this->seq;
    }

    public function isDefault() : bool
    {
        return $this->isDefault;
    }

    public function isEnabled() : bool
    {
        return $this->enabled;
    }

    public function isVisible() : bool
    {
        return $this->visible;
    }

    public function keyword() : string
    {
        return $this->keyword ? $this->keyword : $this->layerClass->keyword();
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_map_legend');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('map', Map::class);
        $builder->addStringKey('source', 30);
        $builder->addStringKey('layer', 30);

        // Attributes
        $builder->addCompositeManyToOneField(
            'layerClass',
            Layer::class,
            [
                ['column' => 'source', 'nullable' => false],
                ['column' => 'layer', 'nullable' => false],
            ]
        );
        $builder->addField('seq', 'integer');
        $builder->addMappedField('is_default', 'isDefault', 'boolean');
        $builder->addField('enabled', 'boolean');
        $builder->addField('visible', 'boolean');
        $builder->addStringField('options', 4000);
        KeywordTrait::buildKeywordMetadata($builder);
    }
}
