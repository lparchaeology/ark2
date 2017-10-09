<?php

/**
 * ARK Workflow Registry.
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
use ARK\Actor\Person;
use ARK\Model\Attribute;
use ARK\Model\Item;
use ARK\Model\ItemPropertyMarkingStore;
use ARK\Model\Schema;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use ARK\Workflow\Exception\WorkflowException;
use ARK\Workflow\Security\ActorUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Workflow\Exception\InvalidArgumentException;
use Symfony\Component\Workflow\Registry as SymfonyRegistry;
use Symfony\Component\Workflow\StateMachine;
use Symfony\Component\Workflow\Workflow;

class Registry extends SymfonyRegistry
{
    protected $actions = [];

    public function actor(User $user = null) : ?Actor
    {
        if ($user === null) {
            $user = Service::security()->user();
        }
        if (!$user instanceof User) {
            return ORM::find(Actor::class, 'anonymous');
        }
        $au = ORM::findOneBy(ActorUser::class, ['user' => $user->id()]);
        return $au ? $au->actor() : null;
    }

    public function user(Actor $actor) : ?User
    {
        $au = ORM::findOneBy(ActorUser::class, ['actor' => $actor->id()]);
        return $au ? $au->user() : null;
    }

    public function schemaActions(Schema $schema) : Collection
    {
        $this->init($schema->name());
        return $this->actions[$schema->name()];
    }

    public function updateActions(Actor $actor, Item $item) : Collection
    {
        $schema = $item->schema()->name();
        $this->init($schema);
        $actions = new ArrayCollection();
        foreach ($this->actions[$schema] as $action) {
            try {
                if ($action->isUpdate() && $action->isGranted($actor, $item)) {
                    $actions[$action->name()] = $action;
                }
            } catch (WorkflowException $e) {
                // noop
                //dump($e->getMessage());
            }
        }
        return $actions;
    }

    public function actions(Actor $actor, Item $item) : Collection
    {
        $schema = $item->schema()->name();
        $this->init($schema);
        $actions = new ArrayCollection();
        foreach ($this->actions[$schema] as $action) {
            try {
                if ($action->isGranted($actor, $item)) {
                    $actions[$action->name()] = $action;
                }
            } catch (WorkflowException $e) {
                // noop
            }
        }
        return $actions;
    }

    public function actors(Actor $actor, Item $item) : Collection
    {
        $schema = $item->schema()->name();
        $this->init($schema);
        // TODO Fiter the list!!! Probably only museum staff?
        $actors = ORM::findAll(Person::class);
        return $actors;
    }

    public function mode(Actor $actor, Item $item) : string
    {
        if ($this->can($actor, 'edit', $item)) {
            return 'edit';
        }
        try {
            $action = $this->action($item->schema()->name(), 'view');
            if ($action && ($item->visibility()->name() === 'public' || $action->isAllowed($actor))) {
                return 'view';
            }
        } catch (WorkflowException $e) {
            // noop
        }
        return 'deny';
    }

    public function can(Actor $actor, $action, Item $item, $attribute = null) : bool
    {
        //dump('Workflow::can('.$actor->id().' '.$action.' '.$item->schema()->module()->id().')');
        if (is_string($action)) {
            $action = $this->action($item->schema()->name(), $action);
        }
        if ($action instanceof Action) {
            try {
                return $action->isGranted($actor, $item, $attribute);
            } catch (WorkflowException $e) {
                // noop
            }
        }
        return false;
    }

    public function apply(Actor $actor, string $action, Item $item, Actor $subject = null) : void
    {
        $action = $this->action($item->schema()->name(), $action);
        if ($action) {
            $action->apply($actor, $item, $subject);
        }
    }

    public function getStateMachine(Attribute $attribute) : StateMachine
    {
        if (!$attribute->hasVocabulary() || !$attribute->vocabulary() || !$attribute->vocabulary()->hasTransitions()) {
            throw new InvalidArgumentException(sprintf('Unable to find transitions for attribute "%s".', $attribute->name()));
        }
        $definition = $attribute->vocabulary()->transitions($concept);
        $markingStore = new ItemPropertyMarkingStore($attribute);
        $machine = new StateMachine($definition, $markingStore);
        return $machine;
    }

    public function get($subject, $workflowName = null) : Workflow
    {
        $workflow = null;
        try {
            $workflow = parent::get($subject, $workflowName);
        } catch (InvalidArgumentException $e) {
            if (!$workflow = ORM::find(Workflow::class, $workflowName)) {
                throw new InvalidArgumentException(sprintf('Unable to find a workflow for class "%s".', get_class($subject)));
            }
            $this->add($workflow, get_class($subject));
        }
        return $workflow;
    }

    protected function init(string $schema) : void
    {
        if (isset($this->actions[$schema])) {
            return;
        }
        $this->actions[$schema] = new ArrayCollection();
        $actions = ORM::findBy(Action::class, ['schma' => $schema]);
        foreach ($actions as $action) {
            $this->actions[$schema][$action->name()] = $action;
        }
    }

    private function action(string $schema, string $action) : ?Action
    {
        $this->init($schema);
        return $this->actions[$schema][$action] ?? null;
    }
}
