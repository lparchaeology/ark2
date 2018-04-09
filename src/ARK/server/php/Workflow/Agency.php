<?php

/**
 * ARK Workflow Action.
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
use ARK\Security\Actor;

class Agency
{
    public const GRANT = true;
    public const DENY = false;
    public const ABSTAIN = null;

    protected $schma = '';
    protected $actionName = '';
    protected $action;
    protected $class = '';
    protected $attributeName = '';
    protected $attribute;
    protected $grp = 0;
    protected $operator = 'is';
    protected $condition;
    protected $conditionAttribute;
    protected $conditionOperator;
    protected $conditionValue;
    protected $conditionActor;

    public function group() : int
    {
        return $this->grp;
    }

    public function operator() : string
    {
        return $this->operator;
    }

    public function attribute() : ?SchemaAttribute
    {
        return $this->attribute;
    }

    public function condition() : ?Condition
    {
        if ($this->condition === null && $this->conditionValue !== null) {
            $this->condition = new Condition($this->conditionAttribute, $this->conditionOperator, $this->conditionValue);
        }
        return $this->condition;
    }

    public function conditionOperator() : ?string
    {
        if ($this->conditionActor !== null) {
            return $this->conditionOperator;
        }
        return null;
    }

    public function conditionAttribute() : ?SchemaAttribute
    {
        if ($this->conditionActor !== null) {
            return $this->conditionAttribute;
        }
        return null;
    }

    public function isGranted(Actor $actor, Item $item) : ?bool
    {
        $value = $item->value($this->attributeName);
        if (!$value instanceof Actor) {
            return self::DENY;
        }
        $isAgent = ($value === $actor || $actor->isAgentFor($value));
        $isGranted = true;
        if ($this->condition()) {
            $isGranted = $this->condition()->isMet($item);
        } elseif ($this->conditionActor !== null) {
            $conditionValue = $item->value($this->conditionAttribute->name());
            $isConditionActor = false;
            if ($conditionValue instanceof Actor) {
                $isConditionActor = ($conditionValue === $actor || $actor->isAgentFor($conditionValue));
            }
            $isGranted = ($this->conditionOperator === 'not' ? !$isConditionActor : $isConditionActor);
        }
        if ($this->operator === 'not' && $isAgent && $isGranted) {
            return self::DENY;
        }
        if ($isAgent && $isGranted) {
            return self::GRANT;
        }
        return self::ABSTAIN;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_agency');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('schma', 30);
        $builder->addMappedStringKey('action', 'actionName', 30);
        $builder->addStringKey('class', 30);
        $builder->addMappedStringKey('attribute', 'attributeName', 30);
        $builder->addKey('grp', 'integer');

        // Fields
        $builder->addStringField('operator', 10);
        $builder->addMappedStringField('condition_operator', 'conditionOperator', 10);
        $builder->addMappedStringField('condition_value', 'conditionValue', 4000);
        $builder->addMappedField('condition_actor', 'conditionActor', 'boolean');

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
                ['column' => 'class'],
                ['column' => 'attribute'],
            ]
        );
        $builder->addCompositeManyToOneField(
            'conditionAttribute',
            SchemaAttribute::class,
            [
                ['column' => 'schma'],
                ['column' => 'class'],
                ['column' => 'condition_attribute', 'reference' => 'attribute'],
            ]
        );
    }
}
