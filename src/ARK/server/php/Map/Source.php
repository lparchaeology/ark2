<?php

/**
 * ARK Map Source
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
use Doctrine\ORM\Mapping\ClassMetadata;

class Source
{
    use KeywordTrait;

    protected $source = '';
    protected $type = '';
    protected $subtype = '';
    protected $format = '';
    protected $viewClass = '';
    protected $ticket = '';
    protected $ticketExpiry = null;
    protected $options = '';

    public function id()
    {
        return $this->source;
    }

    public function type()
    {
        return $this->type;
    }

    public function subtype()
    {
        return $this->subtype;
    }

    public function format()
    {
        return $this->format;
    }

    public function viewClass()
    {
        return $this->viewClass;
    }

    public function ticket()
    {
        return $this->ticket;
    }

    public function ticketExpiry()
    {
        return $this->ticketExpiry;
    }

    public function options()
    {
        return json_decode($this->options);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_map_source');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('source', 30);

        // Attributes
        $builder->addStringField('type', 30);
        $builder->addStringField('subtype', 30);
        $builder->addStringField('format', 30);
        $builder->addStringField('viewClass', 100, 'view_class');
        $builder->addStringField('ticket', 100);
        $builder->addField('ticketExpiry', 'timestamp');
        $builder->addStringField('options', 4000);
        KeywordTrait::buildKeywordMetadata($builder);
    }
}
