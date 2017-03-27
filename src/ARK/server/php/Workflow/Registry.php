<?php

/**
 * ARK Workflow Registry
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
use ARK\Model\Attribute;
use ARK\Model\Item;
use ARK\Model\Schema;
use ARK\ORM\ORM;
use ARK\Workflow\ItemPropertyMarkingStore;
use Symfony\Component\Workflow\Exception\InvalidArgumentException;
use Symfony\Component\Workflow\Registry as SymfonyRegistry;
use Symfony\Component\Workflow\StateMachine;
use Symfony\Component\Workflow\Workflow;

class Registry extends SymfonyRegistry
{
    protected $actions = [];

    protected function init($schema)
    {
        if (isset($this->actions[$schema])) {
            return;
        }
        $this->actions[$schema] = [];
        $this->actions[$schema] = ORM::findBy(Action::class, ['schma' => $schema]);
    }

    public function schemaActions(Schema $schema)
    {
        $this->init($schema->name());
        return $this->actions[$schema->name()];
    }

    public function actions(Actor $actor, Item $item)
    {
        $schema = $item->schema()->name();
        $this->init($schema);
        $actions = [];
        foreach ($this->actions[$schema] as $action) {
            if ($action->isGranted($actor, $item)) {
                dump('granted');
                $actions[$action->name()] = $action;
            } else {
                dump('denied');
            }
        }
        return $actions;
    }

    public function can(Actor $actor, $action, Item $item)
    {
        if ($action = $this->action($item->schema()->name(), $action)) {
            return $action->isGranted($actor, $item);
        }
        return false;
    }

    public function apply(Actor $actor, $action, Item $item)
    {
        if ($action = $this->action($item->schema()->name(), $action)) {
            return $action->apply($actor, $item);
        }
        return false;
    }

    private function action($schema, $action)
    {
        $this->init($schema);
        if (isset($this->actions[$schema][$action])) {
            return $this->actions[$schema][$action];
        }
        return null;
    }

    public function getAttributeWorkflow(Attribute $attribute)
    {
        if (!$attribute->hasVocabulary() || !$attribute->vocabulary()) {
            throw new InvalidArgumentException(sprintf('Unable to find a workflow for attribute "%s".', $attribute->name()));
        }
        $definition = $attribute->vocabulary()->workflow($concept);
        $markingStore = new ItemPropertyMarkingStore($attribute);
        $workflow = new StateMachine($definition, $markingStore);
        return $workflow;
    }

    public function get($subject, $workflowName = null)
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
}
