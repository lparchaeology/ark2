<?php

/**
 * ARK Schema Fragment Type
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Schema;

use ARK\EnabledTrait;
use ARK\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\ClassMetadata;

class FragmentType
{
    use EnabledTrait;
    use KeywordTrait;

    protected $type = '';
    protected $formatClass = '';
    protected $table = '';
    protected $properties = null;

    public function __construct()
    {
        $this->properties = new Collection();
    }

    public function name()
    {
        return $this->type;
    }

    public function formatClass()
    {
        return $this->formatClass;
    }

    public function table()
    {
        return $this->table;
    }

    public function hasProperties()
    {
        return !$this->properties->isEmpty();
    }

    public function properties()
    {
        return $this->properties;
    }

    public function property($name)
    {
        foreach ($this->properties as $property) {
            if ($property->property() == $name || $property->field() == $name) {
                return $property;
            }
        }
        return null;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_fragment_type');
        $builder->addStringKey('type', 20);
        $builder->addStringField('formatClass', 100, 'format_class');
        $builder->addStringField('table', 50, 'tbl');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addOneToMany('properties', 'FragmentProperty', 'type');
        $builder->setReadOnly();
    }
}
