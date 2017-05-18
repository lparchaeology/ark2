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

    public function loadUserByUsername($username)
    {
        $user = $this->findUser($username);
        if (!$user) {
            throw new UsernameNotFoundException("User $username not found.");
        }
        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        return $this->getUser($user->getId());
    }

    public function supportsClass($class)
    {
        return ($class === User::class) || is_subclass_of($class, User::class);
    }

    public function findUser($id)
    {
        return ORM::find(User::class, $id);
    }

    public function findUsername($username)
    {
        $user = null;
        if (strpos($username, '@') !== false) {
            $user = ORM::findOneBy(User::class, ['email' => $username]);
        }
        if (!$user) {
            $user = ORM::findOneBy(User::class, ['username' => $username]);
        }
        return $user;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return ORM::findBy(User::class, $criteria, $orderBy, $limit, $offset);
    }

    public function save(User $user) {
        ORM::persist($user);
        ORM::flush();
    }

    public function delete(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
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

    public function getEmptyUser() {
        $userClass = $this->getUserClass();

        return new $userClass();
    }

    public function create($email, $plainPassword, $name = null, $roles = array()) {
        $user = $this->getEmptyUser();
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

    protected function getEncoder(UserInterface $user)
    {
        return $this->app['security.encoder_factory']->getEncoder($user);
    }

    public function encodeUserPassword(User $user, $password)
    {
        $encoder = $this->getEncoder($user);

        return $encoder->encodePassword($password, $user->getSalt());
    }

    public function setUserPassword(User $user, $password)
    {
        $user->setPassword($this->encodeUserPassword($user, $password));

        return $this;
    }

    public function validatePasswordStrength(User $user, $password)
    {
        return call_user_func($this->getPasswordStrengthValidator(), $user, $password);
    }

    public function getPasswordStrengthValidator()
    {
        if (!is_callable($this->passwordStrengthValidator)) {
            return function(User $user, $password) {
                if (empty($password)) {
                    return 'Password cannot be empty.';
                }

                return null;
            };
        }

        return $this->passwordStrengthValidator;
    }

    public function setPasswordStrengthValidator($callable)
    {
        if (!is_callable($callable)) {
            throw new \InvalidArgumentException('Password strength validator must be Callable.');
        }

        $this->passwordStrengthValidator = $callable;

        return $this;
    }
}
