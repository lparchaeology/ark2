<?php

/**
 * ARK Workflow Condition.
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
 */

namespace ARK\Workflow;

use ARK\Model\Item;
use ARK\Model\LocalText;
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Vocabulary\Term;

class Condition
{
    protected $schma = '';
    protected $actionName = '';
    protected $action;
    protected $class = '';
    protected $attributeName = '';
    protected $attribute;
    protected $operator = 'is';
    protected $grp = 0;
    protected $value = '';

    public function __construct(SchemaAttribute $attribute, string $operator, string $value)
    {
        $this->attribute = $attribute;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function group() : int
    {
        return $this->grp;
    }

    public function isMet(Item $item) : bool
    {
        $value = $item->value($this->attribute->name());
        if ($value instanceof Term) {
            $value = $value->name();
        }
        if ($value instanceof LocalText) {
            $value = $value->content();
        }
        if ($this->operator === 'is') {
            return $value === $this->value;
        }
        if ($this->operator === 'not') {
            return $value !== $this->value;
        }
        if ($this->attribute->dataclass()->datatype()->isNumeric()) {
            $lhs = $this->attribute->dataclass()->datatype()->cast($value);
            $rhs = $this->attribute->dataclass()->datatype()->cast($this->value);
        } elseif ($this->attribute->hasMultipleOccurrences() || $this->attribute->dataclass()->hasMultipleValues()) {
            $lhs = count($value);
            $rhs = (int) $this->value;
        } else {
            $lhs = $value;
            $rhs = $this->value;
        }
        switch ($this->operator) {
            case 'eq':
                // TODO weak comparison!!!
                return $lhs == $rhs;
            case 'ne':
                // TODO weak comparison!!!
                return $lhs != $rhs;
            case 'gt':
                return $lhs > $rhs;
            case 'ge':
                return $lhs >= $rhs;
            case 'lt':
                return $lhs < $rhs;
            case 'le':
                return $lhs <= $rhs;
        }
        return false;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_condition');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('schma', 30);
        $builder->addStringKey('actionName', 30, 'action');
        $builder->addStringKey('class', 30);
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
                ['column' => 'class'],
                ['column' => 'attribute'],
            ]
        );
    }
}
