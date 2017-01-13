<?php

/**
 * ARK Schema Property
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
use ARK\Schema\Schema;
use ARK\Schema\SchemaSubtype;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class SchemaAttribute extends Attribute
{
    protected $schma = null;
    protected $subtypeName = '';
    protected $subtype = null;

    public function schema()
    {
        return $this->schma;
    }

    public function subtype()
    {
        if ($this->subtypeName) {
            return $this->subtype;
        }
        return null;
    }

    public function subtypeName()
    {
        return $this->subtypeName;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_schema_attribute');

        // Key
        $builder->addManyToOneKey('schma', Schema::class);
        $builder->addStringKey('subtypeName', 30, 'subtype');
        $builder->addStringKey('attribute', 30);

        // Associations
        $builder->addCompoundManyToOneField(
            'subtype',
            SchemaSubtype::class,
            [['column' => 'schma', 'nullable' => false], ['column' => 'subtype', 'nullable' => false]]
        );
    }
}
