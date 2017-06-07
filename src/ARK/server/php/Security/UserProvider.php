<?php

/**
 * ARK Security User Provider
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

namespace ARK\Security;

use ARK\ORM\ORM;
use ARK\Security\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    // UserProviderInterface
    public function loadUserByUsername($username)
    {
        $user = $this->findByUsername($username);
        if (!$user) {
            $user = $this->findByEmail($username);
        }
        if (!$user) {
            throw new UsernameNotFoundException("User $username not found.");
        }
        dump($user);
        return $user;
    }

    // UserProviderInterface
    public function refreshUser(UserInterface $user)
    {
        return $this->findUser($user->id());
    }

    // UserProviderInterface
    public function supportsClass($class)
    {
        return ($class === User::class) || is_subclass_of($class, User::class);
    }

    public function findUser($id)
    {
        return ORM::find(User::class, $id);
    }

    public function findByUsername($username)
    {
        return ORM::findOneBy(User::class, ['username' => $username]);
    }

    public function findByEmail($email)
    {
        return ORM::findOneBy(User::class, ['email' => $email]);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return ORM::findBy(User::class, $criteria, $orderBy, $limit, $offset);
    }
}
