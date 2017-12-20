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

use ARK\Model\Attribute;
use ARK\Model\ItemPropertyMarkingStore;
use ARK\ORM\ORM;
use Symfony\Component\Workflow\Exception\InvalidArgumentException;
use Symfony\Component\Workflow\Registry as SymfonyRegistry;
use Symfony\Component\Workflow\StateMachine;
use Symfony\Component\Workflow\Workflow;

class Registry extends SymfonyRegistry
{
    public function get($subject, $workflowName = null) : Workflow
    {
        $workflow = null;
        try {
            $workflow = parent::get($subject, $workflowName);
        } catch (InvalidArgumentException $e) {
            $workflow = ORM::find(Workflow::class, $workflowName);
            if (!$workflow) {
                throw new InvalidArgumentException(sprintf('Unable to find a workflow for class "%s".', get_class($subject)));
            }
            $this->add($workflow, get_class($subject));
        }
        return $workflow;
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
}
