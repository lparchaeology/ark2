<?php

/**
 * ARK Workflow Notification.
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

namespace ARK\Workflow;

use ARK\Model\Item;
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Security\Role;

class Notify
{
    protected $id;
    protected $schma = '';
    protected $actionName = '';
    protected $action;
    protected $class = '';
    protected $attributeName = '';
    protected $attribute;
    protected $roleName = '';
    protected $role;

    public function attribute() : ?SchemaAttribute
    {
        return $this->attribute;
    }

    public function role() : ?Role
    {
        return $this->role;
    }

    public function recipient(Item $item)
    {
        if ($this->attributeName) {
            return $item->value($this->attributeName);
        }
        if ($this->roleName) {
            return $this->role;
        }
        return null;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_notify');
        $builder->setReadOnly();

        // Key
        $builder->addGeneratedKey('id');

        // Attributes
        $builder->addStringField('schma', 30);
        $builder->addMappedStringField('action', 'actionName', 30);
        $builder->addStringField('class', 30);
        $builder->addMappedStringField('attribute', 'attributeName', 30);
        $builder->addMappedStringField('role', 'roleName', 30);

        // Associations
        $builder->addCompositeManyToOneField(
            'action',
            Action::class,
            [
                ['column' => 'schma', 'nullable' => true],
                ['column' => 'action', 'nullable' => true],
            ],
            'notifications'
        );
        $builder->addCompositeManyToOneField(
            'attribute',
            SchemaAttribute::class,
            [
                ['column' => 'schma'],
                ['column' => 'class'],
                ['column' => 'attribute'],
            ]
        );
        $builder->addManyToOneField('role', Role::class);
    }
}
