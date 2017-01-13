<?php

/**
 * ARK Schema Format Attribute
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

use ARK\Schema\Attribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Vocabulary\Vocabulary;

class FormatAttribute extends Attribute
{
    protected $parent = null;
    protected $sequence = 0;
    protected $root = false;

    public function parent()
    {
        return $this->parent;
    }

    public function sequence()
    {
        return $this->sequence;
    }

    public function isRoot()
    {
        return $this->root;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_format_attribute');

        // Key
        $builder->addManyToOneKey('parent', 'Format', 'parent', 'format', false);
        $builder->addStringKey('attribute', 30);

        // Attributes
        $builder->addField('sequence', 'integer');
        $builder->addField('root', 'boolean');
    }}
