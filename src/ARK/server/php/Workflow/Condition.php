<?php

/**
 * ARK Workflow Condition
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

namespace ARK\Workflow;

use ARK\Entity\Actor;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ClassMetadata;
use ARK\Security\RBAC\Role;
use ARK\Workflow\Action;
use ARK\Workflow\Permission;
use ARK\Model\Schema\SchemaAttribute;
use ARK\Model\Item;

class Condition
{
    protected $action = null;
    protected $attribute = null;
    protected $operation = 'eq';
    protected $grp = 0;
    protected $value = '';

    public function isGranted(Item $item)
    {
        $property = $item->property($this->attribute->name());
        $isValue = ($property->value() == $this->value);
        if ($this->operation == 'not') {
            $isValue = !$isvalue;
        }
        return ($isValue ? Permission::GRANT : Permission::DENY);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_condition');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('action', Action::class);
        $builder->addManyToOneKey('attribute', SchemaAttribute::class);
        $builder->addKey('grp', 'integer');

        // Fields
        $builder->addStringField('operation', 10);
        $builder->addStringField('value', 4000);
    }
}
