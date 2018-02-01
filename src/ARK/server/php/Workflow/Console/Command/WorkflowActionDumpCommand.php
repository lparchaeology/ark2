<?php

/**
 * ARK Workflow Dump Command.
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

namespace ARK\Workflow\Console\Command;

use ARK\Console\Command\AbstractCommand;
use ARK\ORM\ORM;
use ARK\Workflow\Action;

class WorkflowActionDumpCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('workflow:action:dump')
            ->setDescription('Dump a Workflow Action')
            ->addOptionalArgument('action', 'The Action to dump');
    }

    protected function doExecute() : void
    {
        $compound = $this->getArgument('action');
        $parts = explode('.', $compound);
        $action = array_pop($parts);
        $schema = implode('.', $parts);
        $action = Action::find($schema, $action);

        $this->write('');
        $this->write('Action : '.$action->name());
        $this->write('');
        $this->write('Actionable       : '.($action->isActionable() ? 'Yes' : 'No'));
        $this->write('Updates          : '.($action->isUpdate() ? 'Yes' : 'No'));

        $this->write('');
        $this->write('Allowed Roles (any one required):');
        foreach ($action->allowances() as $allow) {
            $this->write('  '.$allow->operator().' '.$allow->role()->id());
        }
        $this->write('  otherwise '.($action->defaultAllowance() ? 'allow' : 'deny'));

        $this->write('');
        $this->write('Agency (any one required):');
        foreach ($action->agencies() as $agency) {
            $cond = '';
            if ($agency->condition()) {
                $condition = $agency->condition();
                $cond = ' and '.$condition->attribute()->name().' '.$condition->operator().' '.$condition->value();
            } elseif ($agency->conditionAttribute()) {
                $cond = ' and '.$agency->conditionOperator().' '.$agency->conditionAttribute()->name();
            }
            $this->write('  '.$agency->operator().' '.$agency->attribute()->name().$cond);
        }
        $this->write('  otherwise '.($action->defaultAgency() ? 'allow' : 'deny'));

        $this->write('');
        $this->write("Conditions ('and' within group, 'or' between groups):");
        if (count($action->conditions()) > 0) {
            foreach ($action->conditions() as $condition) {
                $this->write('  '.$condition->group().' '.$condition->attribute()->name().' '.$condition->operator().' '.$condition->value());
            }
        } else {
            $this->write('  None');
        }

        $this->write('');
    }

    protected function doInteract() : void
    {
        $actions = ORM::findAll(Action::class);
        foreach ($actions as $action) {
            $id = $action->schema()->id().'.'.$action->name();
            $ids[$id] = $id;
        }
        $action = $this->getArgument('action');
        if (!isset($ids[$action])) {
            $action = $this->askChoice('Please choose the action to dump', array_keys($ids));
            $this->setArgument('action', $action);
        }
    }
}
