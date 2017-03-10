<?php

/**
 * ARK Map Layer
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

use ARK\Map\LayerInterface;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class LayerView implements LayerInterface
{
    use KeywordTrait;

    protected $map = null;
    protected $source = '';
    protected $layer = '';
    protected $layerClass = null;
    protected $seq = 0;
    protected $isDefault = false;
    protected $enabled = true;
    protected $visible = false;
    protected $options = '';

    public function id()
    {
        return [
            'map' => $this->map->id(),
            'source' => $this->source,
            'layer' => $this->layer,
        ];
    }

    public function source()
    {
        return $this->layerClass->source();
    }

    public function name()
    {
        return $this->layer;
    }

    public function sourceName()
    {
        return $this->layerClass->sourceName();
    }

    public function url()
    {
        return $this->layerClass->url();
    }

    public function options()
    {
        return array_merge($this->layerClass->options(), json_decode($this->options));
    }

    public function parameters()
    {
        return $this->layerClass->parameters();
    }

    public function sequence()
    {
        return $this->seq;
    }

    public function isDefault()
    {
        return $this->isDefault;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function isVisible()
    {
        return $this->visible;
    }

    public function keyword()
    {
        return ($this->keyword ? $this->keyword : $this->layerClass->keyword());
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_map_legend');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('map', 'ARK\Map\Map');
        $builder->addStringKey('source', 30);
        $builder->addStringKey('layer', 30);

        // Attributes
        $builder->addCompositeManyToOneField(
            'layerClass',
            'ARK\Map\Layer',
            [
                ['column' => 'source', 'nullable' => false],
                ['column' => 'layer', 'nullable' => false],
            ]
        );
        $builder->addField('seq', 'integer');
        $builder->addField('isDefault', 'boolean', [], 'is_default');
        $builder->addField('enabled', 'boolean');
        $builder->addField('visible', 'boolean');
        $builder->addStringField('options', 4000);
        KeywordTrait::buildKeywordMetadata($builder);
    }
}
