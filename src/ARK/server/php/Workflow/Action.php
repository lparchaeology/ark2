<?php

/**
 * ARK Workflow Action.
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

use ARK\Actor\Actor;
use ARK\Message\Notification;
use ARK\Model\Item;
use ARK\Model\KeywordTrait;
use ARK\Model\Schema;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Vocabulary\Term;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Action
{
    use KeywordTrait;

    protected $schma;
    protected $event;
    protected $action = '';
    protected $agent = '';
    protected $defaultPermission = false;
    protected $defaultAgency = false;
    protected $defaultCondition = false;
    protected $defaultAllowence = false;
    protected $enabled = true;
    protected $permissions;
    protected $allowances;
    protected $agencies;
    protected $conditions;
    protected $notifications;
    protected $updates;
    protected $groups;

    public function __construct()
    {
        $this->permissions = new ArrayCollection();
        $this->allowances = new ArrayCollection();
        $this->agencies = new ArrayCollection();
        $this->conditions = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->updates = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function schema() : Schema
    {
        return $this->schma;
    }

    public function name() : string
    {
        return $this->action;
    }

    public function event() : Term
    {
        return $this->event;
    }

    public function agent() : Actor
    {
        return $this->agent;
    }

    public function enabled() : bool
    {
        return $this->enabled;
    }

    public function isUpdate() : bool
    {
        return !$this->updates->isEmpty();
    }

    public function meetsConditions(Item $item) : bool
    {
        if ($this->conditions->isEmpty()) {
            return Condition::PASS;
        }

        // Sort the groups
        if ($this->groups === null) {
            foreach ($this->conditions as $condition) {
                $this->groups[$condition->group()][] = $condition;
            }
        }
        // AND within a group, OR between groups, Condition never abstains
        $vote = Condition::FAIL;
        foreach ($this->groups as $group => $conditions) {
            foreach ($conditions as $condition) {
                $vote = $condition->isGranted($item);
                if ($vote === Condition::FAIL) {
                    $continue;
                }
            }
            if ($vote === Condition::PASS) {
                return true;
            }
        }
        return $this->defaultCondition;
    }

    public function hasPermission(Actor $actor, Item $item) : bool
    {
        // TODO Check permissions!
        return $this->defaultPermission;
    }

    public function isAllowed(Actor $actor) : bool
    {
        if ($this->allowances->isEmpty()) {
            return $this->defaultAllowence;
        }
        foreach ($this->allowances as $allow) {
            $vote = $allow->isAllowed($actor);
            if ($vote !== Allow::ABSTAIN) {
                return $vote === Allow::GRANT;
            }
        }
        return $this->defaultAllowence;
    }

    public function hasAgency(Actor $actor, Item $item) : bool
    {
        // Check if Actor is one of the permitted agents
        foreach ($this->agencies as $agency) {
            $vote = $agency->isGranted($actor, $item);
            if ($vote !== Agency::ABSTAIN) {
                return $vote === Agency::GRANT;
            }
        }
        return $this->defaultAgency;
    }

    public function isGranted(Actor $actor, Item $item, $attribute = null) : bool
    {
        // TODO Sort out Permissions vs Allowances
        //dump('ACTION : '.$this->action);
        //dump('Allowed = '.(string) $this->isAllowed($actor));
        //dump('Agency = '.(string) $this->hasAgency($actor, $item));
        //dump('Conditions = '.(string) $this->meetsConditions($item));
        if ($attribute) {
            if (is_string($attribute)) {
                $attribute = $item->property($attribute)->attribute();
            }
            return $this->isAllowed($actor)
                && ($this->hasAgency($actor, $item) || $actor->hasPermission($attribute->readPermission()))
                && $this->meetsConditions($item);
        }
        return $this->isAllowed($actor)
            && $this->hasAgency($actor, $item)
            && $this->meetsConditions($item);
    }

    public function notify(Item $item) : Collection
    {
        $recipients = new ArrayCollection();
        foreach ($this->notifications as $notify) {
            $recipients->add($notify->recipient($item));
        }
        return $recipients;
    }

    public function apply(Actor $actor, Item $item, Actor $subject = null) : void
    {
        if ($this->isGranted($actor, $item)) {
            // Create Event
            $event = new Event($actor, $this, $item);
            ORM::persist($event);
            // Apply Updates
            foreach ($this->updates as $update) {
                $update->apply($actor, $item, $subject);
            }
            // Trigger Actions
            // Send Notifications
            $recipients = $this->notify($item);
            if ($recipients) {
                $notification = new Notification($actor, $recipients, $event);
                ORM::persist($notification);
            }
        }
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_action');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('schma', Schema::class);
        $builder->addStringKey('action', 30);

        // Fields
        $builder->addStringField('agent', 30);
        $builder->addField('enabled', 'boolean');
        $builder->addField('defaultAllowence', 'boolean', [], 'default_allowance');
        $builder->addField('defaultAgency', 'boolean', [], 'default_agency');
        $builder->addField('defaultCondition', 'boolean', [], 'default_condition');
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addCompositeManyToOneField(
            'event',
            Term::class,
            [
                ['column' => 'event_vocabulary', 'reference' => 'concept'],
                ['column' => 'event_term', 'reference' => 'term'],
            ]
        );
        $builder->addCompositeOneToMany(
            'allowances',
            Allow::class,
            'action',
            [
                ['column' => 'schma', 'nullable' => true],
                ['column' => 'action', 'nullable' => true],
            ]
        );
        $builder->addCompositeOneToMany(
            'agencies',
            Agency::class,
            'action',
            [
                ['column' => 'schma', 'nullable' => true],
                ['column' => 'action', 'nullable' => true],
            ]
        );
        $builder->addCompositeOneToMany(
            'conditions',
            Condition::class,
            'action',
            [
                ['column' => 'schma', 'nullable' => true],
                ['column' => 'action', 'nullable' => true],
            ]
        );
        $builder->addCompositeOneToMany(
            'notifications',
            Notify::class,
            'action',
            [
                ['column' => 'schma', 'nullable' => true],
                ['column' => 'action', 'nullable' => true],
            ]
        );
        $builder->addCompositeOneToMany(
            'updates',
            Update::class,
            'action',
            [
                ['column' => 'schma', 'nullable' => true],
                ['column' => 'action', 'nullable' => true],
            ]
        );
    }
}
