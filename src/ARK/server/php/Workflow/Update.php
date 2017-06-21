<?php

/**
 * ARK Workflow Notification
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
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Vocabulary\Term;
use ARK\Workflow\Action;
use ARK\Workflow\Role;

class Update
{
    protected $schma = '';
    protected $actionName = '';
    protected $action = null;
    protected $type = '';
    protected $attributeName = '';
    protected $attribute = null;
    protected $subject = null;
    protected $actor = null;
    protected $clear = null;
    protected $term = '';

    public function apply(Actor $actor, Item $item, Actor $subject = null)
    {
        if ($this->actor) {
            $item->property($this->attributeName)->setValue($actor);
        } elseif ($this->subject) {
            $item->property($this->attributeName)->setValue($subject);
        } elseif ($this->clear) {
            $item->property($this->attributeName)->setValue($this->attribute->nullValue());
        } elseif ($this->term) {
            $term = ORM::findOneBy(Term::class, ['concept' => $this->attribute->vocabulary()->concept(), 'term' => $this->term]);
            $item->property($this->attributeName)->setValue($term);
        }
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_update');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('schma', 30);
        $builder->addStringKey('actionName', 30, 'action');
        $builder->addStringKey('type', 30);
        $builder->addStringKey('attributeName', 30, 'attribute');

        $builder->addStringField('actor', 'boolean');
        $builder->addStringField('subject', 'boolean');
        $builder->addStringField('clear', 'boolean');
        $builder->addStringField('term', 30);

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
                ['column' => 'type'],
                ['column' => 'attribute'],
            ]
        );
    }
}
