<?php

/**
 * ARK User Command.
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

namespace DIME\Console\Command;

use ARK\Security\Actor;
use ARK\Security\Person;
use ARK\ARK;
use ARK\Console\Command\AbstractCommand;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use ARK\Workflow\Role;
use DIME\Entity\Museum;

class DimeRoleAdminCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('dime:role:admin')
             ->setDescription('Make a actor a DIME admin')
             ->addOptionalArgument('actor', 'The actor to make an admin');
    }

    protected function doExecute() : void
    {
        $actor = $this->input->getArgument('actor');
        $actor = Person::find($actor);
        if ($actor) {
            $role = Role::find('admin');
            $museums = Museum::findAll();
            foreach ($museums as $museum) {
                if (!$actor->isAgentFor($museum)) {
                    $this->write('  Add museum '.$museum->id());
                    Service::security()->createActorRole($actor, $role, $museum);
                }
            }
            ORM::flush();
            $this->write('SUCCESS: Admin role added');
        } else {
            $this->write('FAILURE: Actor does not exist!');
        }
    }

    protected function doInteract() : void
    {
        $this->askArgument('actor', 'Please enter the actor to make an admin');
    }
}
