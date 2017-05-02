<?php

/**
 * ARK Workflow Action
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

use ARK\Actor\Actor;
use ARK\Model\Item;
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ClassMetadata;
use ARK\Workflow\Action;
use ARK\Workflow\Role;

class Agency
{
    const GRANT = true;
    const DENY = false;
    const ABSTAIN = null;

    protected $schma = '';
    protected $actionName = '';
    protected $action = null;
    protected $type = '';
    protected $attributeName = '';
    protected $attribute = null;
    protected $operator = 'is';

    public function isGranted(Actor $actor, Item $item)
    {
        $value = $item->property($this->attributeName)->value();
        $isAgent = (isset($value['item']) && $value['item'] == $actor->id()) ;
        if ($this->operator == 'not' && $isAgent) {
            return self::DENY;
        }
        if ($isAgent) {
            return self::GRANT;
        }
        return self::ABSTAIN;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_agency');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('schma', 30);
        $builder->addStringKey('actionName', 30, 'action');
        $builder->addStringKey('type', 30);
        $builder->addStringKey('attributeName', 30, 'attribute');

        // Fields
        $builder->addStringField('operator', 10);

        // Associations
        $builder->addCompositeManyToOneField(
            'action',
            Action::class,
            [
                ['column' => 'schma', 'nullable' => true],
                ['column' => 'action', 'nullable' => true],
            ],
            'agencies'
        );
        $builder->addCompositeManyToOneField(
            'attribute',
            SchemaAttribute::class,
            [
                ['column' => 'schma'],
                ['column' => 'type'],
                ['column' => 'attribute'],
            ]
        );
    }
}
