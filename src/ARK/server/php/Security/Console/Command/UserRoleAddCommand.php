<?php

/**
 * ARK User Command.
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

namespace ARK\Security\Console\Command;

use ARK\Actor\Actor;
use ARK\ARK;
use ARK\Framework\Console\Command\AbstractCommand;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use ARK\Workflow\Role;

class UserRoleAddCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('user:role:add')
             ->setDescription('Add a user role')
             ->addOptionalArgument('username', 'The username to add a role to');
    }

    protected function doExecute() : void
    {
        $username = $this->input->getArgument('username');
        $user = Service::security()->user($username);
        if ($user) {
            $roles = [];
            foreach (ORM::findAll(Role::class) as $role) {
                $roles[$role->id()] = $role;
            }
            $role = $this->askChoice('Please choose a new user role', array_keys($roles));
            $role = $roles[$role];
            $actor = ORM::find(Actor::class, $user->id());
            $actorRole = Service::security()->createActorRole($actor, $role);
            ORM::flush();
            $this->write('SUCCESS: User role added');
        } else {
            $this->write('FAILURE: User does not exist!');
        }
    }

    protected function doInteract() : void
    {
        $this->askArgument('username', 'Please enter the username to add a role to');
    }
}
