<?php

/**
 * ARK Workflow Dump Command.
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

namespace ARK\Workflow\Console\Command;

use ARK\Console\Command\AbstractCommand;
use Symfony\Component\Workflow\Dumper\GraphvizDumper;
use Symfony\Component\Workflow\Dumper\StateMachineGraphvizDumper;

class WorkflowDumpCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('workflow:dump')
            ->setDescription('Dump a Workflow in GraphViz format')
            ->addOptionalArgument('name', 'The Workflow name');
    }

    protected function doExecute() : void
    {
        if ($workflow = ORM::find(Workflow::class, $name)) {
            if (get_class($workflow) === StateMachine::class) {
                $dumper = new StateMachineGraphvizDumper();
            } else {
                $dumper = new GraphvizDumper();
            }
            $this->write($dumper->dump($workflow->getDefinition()));
        } else {
            $this->write('Workflow not found!');
        }
    }

    protected function doInteract() : void
    {
        $this->askArgument('name', 'Please enter the workflow name to dump');
    }
}
