<?php

/**
 * Silex User Provider
 *
 *  Copyright 2016 by Simon Erhardt <hello@rootlogin.ch>
 *
 * This file is part of the silex user provider.
 *
 * The silex user provider is free software: you can redistribute
 * it and/or modify it under the terms of the Lesser GNU General Public
 * License version 3 as published by the Free Software Foundation.
 *
 * The silex user provider is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the Lesser GNU General Public
 * License along with the silex user provider.  If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * @license LGPL-3.0 <http://spdx.org/licenses/LGPL-3.0>
 */

namespace ARK\Security\User\Provider;

use ARK\ORM\ORM;
use ARK\Security\User;
use Silex\Application;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Doctrine\ORM\EntityManager;
use Saxulum\DoctrineOrmManagerRegistry\Doctrine\ManagerRegistry;

class UserProvider implements UserProviderInterface
{
    protected $app;
    protected $passwordStrengthValidator;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    // UserProviderInterface
    public function loadUserByUsername($username)
    {
        $user = $this->findByUsername($username);
        if (!$user) {
            throw new UsernameNotFoundException("User $username not found.");
        }
        return $user;
    }

    // UserProviderInterface
    public function refreshUser(UserInterface $user)
    {
        return $this->findUser($user->getId());
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

    public function findUsername($username)
    {
        return ORM::findOneBy(User::class, ['email' => $username]);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return ORM::findBy(User::class, $criteria, $orderBy, $limit, $offset);
    }

    public function validate(User $user)
    {
        $errors = $user->validate();

        // Ensure email address is unique.
        $duplicates = $this->findBy(array('email' => $user->getEmail()));
        if (!empty($duplicates)) {
            foreach ($duplicates as $dup) {
                if ($user->getId() && $dup->getId() == $user->getId()) {
                    continue;
                }
                $errors['email'] = 'An account with that email address already exists.';
            }
        }

        // Ensure username is unique or null.
        if($user->hasRealUsername()) {
            $duplicates = $this->findBy(array('username' => $user->getRealUsername()));
            if (!empty($duplicates)) {
                foreach ($duplicates as $dup) {
                    if ($user->getId() && $dup->getId() == $user->getId()) {
                        continue;
                    }
                    $errors['username'] = 'An account with that username already exists.';
                }
            }
        }

        // If username is required, ensure it is set.
        if ($this->isUsernameRequired && !$user->getRealUsername()) {
            $errors['username'] = 'Username is required.';
        }

        return $errors;
    }

    public function loginAsUser(User $user)
    {
        if (null !== ($current_token = Service::tokenStorage()->getToken())) {
            $providerKey = method_exists($current_token, 'getProviderKey') ? $current_token->getProviderKey() : $current_token->getSecret();
            $token = new UsernamePasswordToken($user, null, $providerKey);
            Service::tokenStorage()->setToken($token);
            $this->app['user'] = $user;
        }
    }

    public function create($email, $plainPassword, $name = null, $roles = array()) {
        $user = new User;
        $user->setEmail($email);

        if (!empty($plainPassword)) {
            $this->setUserPassword($user, $plainPassword);
        }

        if ($name !== null) {
            $user->setName($name);
        }
        if (!empty($roles)) {
            $user->setRoles($roles);
        }

        return $user;
    }

    public function registerUser($username, $email, $plainPassword, $name = null, $level = 'ROLE_USER')
    {
        $user = new User($username, $email);
        if ($this->isEmailConfirmationRequired) {
            $user->setEnabled(false);
            $user->setConfirmationToken($app['user.tokenGenerator']->generateToken());
        }
        $user->setPassword($plainPassword);
        ORM::persist($user);
        ORM::flush($user);

        if ($this->isEmailConfirmationRequired) {
            $this->sendConfirmationMessage($user);
        } else {
            $this->loginAsUser($user);
        }
    }

    protected function getGravatarUrl($email, $size = 80)
    {
        // See https://en.gravatar.com/site/implement/images/ for available options.
        return '//www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?s=' . $size . '&d=identicon';
    }
}
