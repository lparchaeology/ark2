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

use ARK\Actor\Actor;
use ARK\Model\Item;
use ARK\Model\Schema\SchemaAttribute;
use ARK\Model\LocalText;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ClassMetadata;
use ARK\Workflow\Action;
use ARK\Workflow\Permission;
use ARK\Workflow\Role;
use ARK\Vocabulary\Term;

class Condition
{
    const PASS = true;
    const FAIL = false;

    protected $schma = '';
    protected $actionName = '';
    protected $action = null;
    protected $type = '';
    protected $attributeName = '';
    protected $attribute = null;
    protected $operator = 'is';
    protected $grp = 0;
    protected $value = '';

    public function group()
    {
        return $this->grp;
    }

    public function isGranted(Item $item)
    {
        $value = $item->value($this->attribute->name());
        if ($value instanceof Term) {
            $value = $value->name();
        }
        if ($value instanceof LocalText) {
            $value = $value->content();
        }
        if ($this->operator == 'not') {
            return ($value !== $this->value ? self::PASS : self::FAIL);
        }
        return ($value === $this->value ? self::PASS : self::FAIL);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_condition');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('schma', 30);
        $builder->addStringKey('actionName', 30, 'action');
        $builder->addStringKey('type', 30);
        $builder->addStringKey('attributeName', 30, 'attribute');
        $builder->addKey('grp', 'integer');

        // Fields
        $builder->addStringField('operator', 10);
        $builder->addStringField('value', 4000);

        // Associations
        $builder->addCompositeManyToOneField(
            'action',
            Action::class,
            [
                ['column' => 'schma', 'nullable' => true],
                ['column' => 'action', 'nullable' => true],
            ],
            'conditions'
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
