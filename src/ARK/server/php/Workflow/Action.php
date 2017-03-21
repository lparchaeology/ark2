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

use ARK\Entity\Actor;
use ARK\Model\Item;
use ARK\Model\Schema;
use ARK\Model\Attribute;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ClassMetadata;
use ARK\Vocabulary\Term;
use ARK\Workflow\Agency;
use ARK\Workflow\Condition;
use ARK\Workflow\Permission;
use Doctrine\Common\Collections\ArrayCollection;

class Action
{
    use KeywordTrait;

    protected $schma = null;
    protected $event = null;
    protected $action = '';
    protected $agent = '';
    protected $defaultPermission = false;
    protected $defaultAgency = false;
    protected $defaultCondition = false;
    protected $enabled = true;
    protected $permissions = null;
    protected $agencies = null;
    protected $conditions = null;
    protected $groups = null;

    public function __construct()
    {
        $this->cells = new ArrayCollection();
    }

    public function schema()
    {
        return $this->schma;
    }

    public function name()
    {
        return $this->action;
    }

    public function event()
    {
        return $this->event;
    }

    public function agent()
    {
        return $this->agent;
    }

    public function enabled()
    {
        return $this->enabled;
    }

    public function meetsConditions(Item $item)
    {
        if ($this->conditions->isEmpty()) {
            return $this->defaultCondition;
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

    public function hasPermission(Actor $actor)
    {
        foreach ($this->permissions as $permission) {
            $vote = $permission->isGranted($actor);
            if ($this->action == 'accession') {
                dump('vote');
                dump($permission->role()->id());
                dump($vote);
            }
            if ($vote !== Permission::ABSTAIN) {
                return ($vote === Permission::GRANT);
            }
        }
        if ($this->action == 'accession') {
            dump('default');
            dump($this->defaultPermission);
        }
        return $this->defaultPermission;
    }

    public function hasAgency(Actor $actor, Item $item)
    {
        // Check if Actor is one of the permitted agents
        $vote = Agency::GRANT;
        foreach ($this->agencies as $agency) {
            $vote = $agency->isGranted($actor, $item);
            if ($vote !== Agency::ABSTAIN) {
                return ($vote === Agency::GRANT);
            }
        }
        return $this->defaultAgency;
    }

    public function isGranted(Actor $actor, Item $item)
    {
        if ($this->action == 'accession') {
            dump('Action : '.$this->action);
            dump($this->permissions);
            dump($this->hasPermission($actor));
            dump($this->agencies);
            dump($this->hasAgency($actor, $item));
            dump($this->conditions);
            dump($this->meetsConditions($item));
        }
        return $this->hasPermission($actor) && $this->hasAgency($actor, $item) && $this->meetsConditions($item);
    }

    public function apply(Actor $actor, Item $item)
    {
        if (!$this->isGranted($actor, $item)) {
            return;
        }
    }

    public static function loadMetadata(ClassMetadata $metadata)
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
        $builder->addField('defaultPermission', 'boolean', [], 'default_permission');
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
            'permissions',
            Permission::class,
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
    }
}
