<?php

/**
 * ARK Model Schema Property
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

namespace ARK\Model\Schema;

use ARK\Model\Attribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Vocabulary\Term;

class SchemaAttribute extends Attribute
{
    protected $schma = null;
    protected $type = '';
    protected $visibility = 'restricted';
    protected $visibilityTerm = null;
    protected $read = null;
    protected $update = null;

    public function schema()
    {
        return $this->schma;
    }

    public function type()
    {
        return $this->type;
    }

    public function visibility()
    {
        if ($this->visibilityTerm === null) {
            $this->visibilityTerm = ORM::find(Term::class, ['concept' => 'core.visibility', 'term' => $this->visibility]);
        }
        return $this->visibilityTerm;
    }

    public function readPermission()
    {
        if ($this->read) {
            return $this->read;
        }
        return $this->schma->readPermission();
    }

    public function updatePermission()
    {
        if ($this->update) {
            return $this->update;
        }
        return $this->schma->updatePermission();
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_schema_attribute');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('schma', 'ARK\Model\Schema');
        $builder->addStringKey('type', 30);
        $builder->addStringKey('attribute', 30);

        // Attributes
        $builder->addStringField('visibility', 30);

        // Associations
        $builder->addPermissionField('read', 'view');
        $builder->addPermissionField('update', 'edit');
    }
}
