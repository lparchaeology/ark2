<?php

/**
 * ARK Map Layer.
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
 * @php        >=5.6, >=7.0
 */

namespace ARK\Map;

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class Layer implements LayerInterface
{
    use KeywordTrait;

    protected $source;
    protected $layer = '';
    protected $sourceName = '';
    protected $url = '';
    protected $options = '';
    protected $optionsArray;
    protected $parameters = '';
    protected $parametersArray;

    public function id()
    {
        return ['source' => $this->source->id(), 'layer' => $this->layer];
    }

    public function source() : Source
    {
        return $this->source;
    }

    public function name() : string
    {
        return $this->layer;
    }

    public function sourceName() : string
    {
        return $this->sourceName;
    }

    public function url() : string
    {
        return $this->url;
    }

    public function options() : iterable
    {
        if ($this->optionsArray === null) {
            $this->optionsArray = json_decode($this->options, true);
        }
        return $this->optionsArray;
    }

    public function parameters() : iterable
    {
        if ($this->parametersArray === null) {
            $this->parametersArray = json_decode($this->parameters, true);
        }
        return $this->parametersArray;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_map_layer');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('source', Source::class);
        $builder->addStringKey('layer', 30);

        // Attributes
        $builder->addMappedStringField('source_name', 'sourceName', 50);
        $builder->addStringField('url', 2000);
        $builder->addStringField('options', 4000);
        $builder->addStringField('parameters', 4000);
        KeywordTrait::buildKeywordMetadata($builder);
    }
}
