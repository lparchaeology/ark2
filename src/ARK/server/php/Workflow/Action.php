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

use ARK\Model\Item;
use ARK\Model\Schema;
use ARK\Model\Attribute;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ClassMetadata;
use ARK\Vocabulary\Term;
use ARK\Workflow\Agent;
use ARK\Workflow\Permission;
use Doctrine\Common\Collections\ArrayCollection;

class Action
{
    use KeywordTrait;

    protected $schma = null;
    protected $action = '';
    protected $agent = '';
    protected $defaultPermission = false;
    protected $enabled = true;
    protected $permissions = null;
    protected $agents = null;
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

    public function action()
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

    public function isPossible(Item $item)
    {
        if ($this->conditions->isEmpty()) {
            return true;
        }
        // Sort the groups
        if ($this->groups === null) {
            foreach ($this->conditions as $condition) {
                $this->groups[$condition->group()][] = $condition;
            }
        }
        // AND within a group, OR between groups, Condition never abstains
        $vote = Permission::DENY;
        foreach ($this->groups as $group => $conditions) {
            foreach ($conditions as $condition) {
                $vote = $condition->isGranted($item);
                if ($vote === Permission::DENY) {
                    $continue;
                }
            }
            if ($vote === Permission::GRANT) {
                $continue;
            }
        }
        return ($vote === Permission::GRANT);
    }

    public function isPermitted(Actor $actor)
    {
        $vote = Permission::GRANT;
        foreach ($this->permissions as $permission) {
            $vote = $permission->isGranted($actor);
            if ($vote === Permission::DENY) {
                return false;
            }
            if ($vote === Permission::GRANT) {
                return true;
            }
        }
        return ($vote === Permission::GRANT);
    }

    public function isGranted(Actor $actor, Item $item)
    {
        // Check if Actor's role is permitted
        $vote = Permission::GRANT;
        foreach ($this->permissions as $permission) {
            $vote = $permission->isGranted($actor);
            if ($vote === Permission::DENY) {
                return false;
            }
            if ($vote === Permission::GRANT) {
                continue;
            }
        }
        if ($vote !== Permission::GRANT) {
            return false;
        }

        // Check if Actor is one of the permitted agents
        foreach ($this->agents as $agent) {
            $vote = $agent->isGranted($actor, $item);
            if ($vote === Permission::DENY) {
                return false;
            }
            if ($vote === Permission::GRANT) {
                continue;
            }
        }

        // Check if Item Conditions are met
        if ($this->groups === null) {
            foreach ($this->conditions as $condition) {
                $this->groups[$condition->group()][] = $condition;
            }
        }
        // AND within a group, OR between groups
        $vote = Permission::GRANT;
        foreach ($this->groups as $group => $conditions) {
            foreach ($conditions as $condition) {
                $vote = $condition->isGranted($item);
                if ($vote === Permission::DENY) {
                    $continue;
                }
            }
            if ($vote === Permission::GRANT) {
                $continue;
            }
        }

        return ($vote === Permission::ABSTAIN ? $this->defaultPermission : $vote);
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
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addCompoundManyToOneField('event', Term::class, ['event_vocabulary' => 'concept', 'event_term' => 'term']);
        $builder->addOneToMany('permissions', Permission::class, ['schma', 'action']);
        $builder->addOneToMany('agents', Agent::class, ['schma', 'action']);
        $builder->addOneToMany('conditions', Condition::class, ['schma', 'action']);
    }
}
