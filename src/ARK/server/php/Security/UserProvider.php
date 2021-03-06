<?php

/**
 * ARK Security User Provider.
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

namespace ARK\Security;

use ARK\ORM\ORM;
use Doctrine\Common\Collections\Collection;
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

    public function findUser(string $id) : ?User
    {
        return ORM::find(User::class, $id);
    }

    public function findByUsername(string $username) : ?User
    {
        return ORM::findOneBy(User::class, ['username' => $username]);
    }

    public function findByEmail(string $email) : ?User
    {
        return ORM::findOneBy(User::class, ['email' => $email]);
    }

    public function findByVerificationToken(string $token) : ?User
    {
        if ($token) {
            return ORM::findOneBy(User::class, ['verificationToken' => $token]);
        }
        return null;
    }

    public function findByResetToken(string $token) : ?User
    {
        if ($token) {
            return ORM::findOneBy(User::class, ['passwordRequestToken' => $token]);
        }
        return null;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null) : Collection
    {
        return ORM::findBy(User::class, $criteria, $orderBy, $limit, $offset);
    }
}
