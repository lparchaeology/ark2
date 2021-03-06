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
use ARK\ORM\ORM;
use ARK\Security\Actor;
use ARK\Vocabulary\Term;

class Update
{
    protected $schma;
    protected $actionName;
    protected $action;
    protected $class;
    protected $attributeName;
    protected $attribute;
    protected $subject;
    protected $actor;
    protected $clear;
    protected $term;
    protected $id;
    protected $source;

    public function attribute() : SchemaAttribute
    {
        return $this->attribute;
    }

    public function setToActor() : ?string
    {
        if ($this->actor) {
            return $this->id;
        }
        return null;
    }

    public function setToSubject() : ?bool
    {
        if ($this->subject) {
            return $this->subject;
        }
        return null;
    }

    public function setToClear() : ?bool
    {
        if ($this->clear) {
            return $this->clear;
        }
        return null;
    }

    public function setToTerm() : ?string
    {
        if ($this->term) {
            return $this->term;
        }
        return null;
    }

    public function setToSource() : ?string
    {
        if ($this->term) {
            return $this->term;
        }
        return null;
    }

    public function sourceAttribute() : ?SchemaAttribute
    {
        return $this->source;
    }

    public function apply(Actor $actor, Item $item, Actor $subject = null) : void
    {
        if ($this->actor) {
            $value = ($this->id ? ORM::find(Actor::class, $this->id) : $actor);
        } elseif ($this->subject) {
            $value = $subject;
        } elseif ($this->clear) {
            $value = $this->attribute->emptyValue();
        } elseif ($this->term) {
            $value = $this->attribute->vocabulary()->term($this->term);
        } elseif ($this->source) {
            $value = $item->value($this->source->name());
        }
        if (isset($value) || $this->clear) {
            $item->setValue($this->attributeName, $value);
        }
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_update');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('schma', 30);
        $builder->addMappedStringKey('action', 'actionName', 30);
        $builder->addStringKey('class', 30);
        $builder->addMappedStringKey('attribute', 'attributeName', 30);

        $builder->addField('actor', 'boolean');
        $builder->addField('subject', 'boolean');
        $builder->addField('clear', 'boolean');
        $builder->addStringField('term', 30);
        $builder->addStringField('id', 30);

        // Associations
        $builder->addCompositeManyToOneField(
            'action',
            Action::class,
            [
                ['column' => 'schma', 'nullable' => true],
                ['column' => 'action', 'nullable' => true],
            ],
            'updates'
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
            'source',
            SchemaAttribute::class,
            [
                ['column' => 'schma'],
                ['column' => 'class'],
                ['column' => 'source', 'reference' => 'attribute'],
            ]
        );
    }
}
