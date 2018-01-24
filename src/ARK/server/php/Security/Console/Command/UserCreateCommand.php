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

use ARK\Actor\Person;
use ARK\ARK;
use ARK\Console\Command\AbstractCommand;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;
use ARK\Workflow\Role;

class UserCreateCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('user:create')
             ->setDescription('Create a new user')
             ->addOptionalArgument('username', 'The username to create');
    }

    protected function doExecute() : void
    {
        $username = $this->input->getArgument('username');
        $email = $this->askQuestion("Please enter the user's email");
        $fullname = $this->askQuestion("Please enter the user's full name");
        $password = $this->askPassword($username);
        $roles = [];
        foreach (ORM::findAll(Role::class) as $role) {
            $roles[$role->id()] = $role;
        }
        $role = $this->askChoice('Please choose a default user role', array_keys($roles));
        $role = $roles[$role];

        $user = Service::security()->createUser($username, $email, $password, $fullname);
        $user->setLevel($role->level());

        $actor = new Person();
        $actor->setId($username);
        $actor->property('email')->setValue($email);
        $actor->property('fullname')->setValue($fullname);
        ORM::persist($actor);

        Service::security()->createActorRole($actor, $role);
        Service::security()->registerUser($user, $actor);

        $this->write('SUCCESS: User created');
    }

    protected function doInteract() : void
    {
        $this->askArgument('username', 'Please enter the username to create');
    }
}
