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

namespace ARK\Security\Console\Command;

use ARK\ARK;
use ARK\Console\Command\AbstractCommand;
use ARK\ORM\ORM;
use ARK\Security\User;
use ARK\Service;

class UserDisableCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('user:disable')
             ->setDescription('Disable a user')
             ->addOptionalArgument('username', 'The username to disable');
    }

    protected function doExecute() : void
    {
        $username = $this->input->getArgument('username');
        $user = Service::security()->userProvider()->loadUserByUsername($username);
        if ($user) {
            $user->disable();
            ORM::flush($user);
            $this->write('SUCCESS: User disabled');
        } else {
            $this->write('FAILURE: User does not exist!');
        }
    }

    protected function doInteract() : void
    {
        $this->askArgument('username', 'Please enter the username to disabled');
    }
}
