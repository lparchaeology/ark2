<?php

/**
 * ARK Console Command.
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

namespace ARK\Framework\Console\Command;

use ARK\ORM\ORM;
use ARK\Security\User;

class UserListCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('user:list')
            ->setDescription('List all users.');
    }

    protected function doExecute() : void
    {
        $users = ORM::findAll(User::class);
        $headers = ['ID', 'Name', 'Email', 'Status', 'Level', 'Roles'];
        $rows = [];
        foreach ($users as $user) {
            $roles = [];
            if ($user->actors()) {
                foreach ($user->actors() as $actor) {
                    foreach ($actor->roles() as $role) {
                        $roles[$role->role()->id()] = $role->role()->id();
                    }
                }
            }
            $roles = implode(', ', array_keys($roles));

            if ($user->isExpired()) {
                $status = 'Expired';
            } elseif ($user->isLocked()) {
                $status = 'Locked';
            } elseif (!$user->isEnabled()) {
                $status = 'Disabled';
            } elseif ($user->isVerified()) {
                $status = 'Verified';
            } else {
                $status = 'Enabled';
            }

            $rows[] = [$user->id(), $user->name(), $user->email(), $status, $user->level(), $roles];
        }
        $this->writeTable($headers, $rows);
    }
}
