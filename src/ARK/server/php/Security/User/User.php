<?php

/**
 * ARK User
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Security\User;

use ARK\VersionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Serializable;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class User implements AdvancedUserInterface, Serializable
{
    use VersionTrait;

    const ROLE_DEFAULT = 'ROLE_ANON';

    protected $username = null;
    protected $usernameCanonical = null;
    protected $email = null;
    protected $emailCanonical = null;
    protected $password = null;
    protected $plainPassword = null;
    protected $enabled = false;
    protected $verified = false;
    protected $locked = false;
    protected $expired = false;
    protected $expiresAt = null;
    protected $credentialsExpired = false;
    protected $credentialsExpireAt = null;
    protected $roles = null;
    protected $accounts = null;
    protected $verificationToken = null;
    protected $verificationRequestedAt = null;
    protected $passwordResetToken = null;
    protected $passwordRequestedAt = null;
    protected $lastLogin = null;

    public function getUsername()
    {
        return $this->username;
    }

    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function getSalt()
    {
        return null;
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    public function getVerificationToken()
    {
        return $this->verificationToken;
    }

    public function getPasswordResetToken()
    {
        return $this->passwordResetToken;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function isVerified()
    {
        return $this->verified;
    }

    public function isLocked()
    {
        return $this->locked;
    }

    public function isExpired()
    {
        return ($this->expired || ($this->expiresAt && $this->expiresAt->getTimestamp() < time()));
    }

    public function areCredentialsExpired()
    {
        return ($this->credentialsExpired
            || ($this->credentialsExpireAt && $this->credentialsExpireAt->getTimestamp() < time()));
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('ROLE_SUPER_ADMIN');
    }

    public function isAccountNonExpired()
    {
        return !$this->isExpired();
    }

    public function isAccountNonLocked()
    {
        return !$this->isLocked();
    }

    public function isCredentialsNonExpired()
    {
        return !$this->areCredentialsExpired();
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function setUsernameCanonical($usernameCanonical)
    {
        $this->usernameCanonical = $usernameCanonical;
        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function setLastLogin(\DateTime $time = null)
    {
        $this->lastLogin = $time;
        return $this;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = (bool) $enabled;
        return $this;
    }

    public function setExpired($expired)
    {
        $this->expired = (bool) $expired;
        return $this;
    }

    public function setExpiresAt(\DateTime $date = null)
    {
        $this->expiresAt = $date;
        return $this;
    }

    public function setCredentialsExpireAt(\DateTime $date = null)
    {
        $this->credentialsExpireAt = $date;
        return $this;
    }

    public function setCredentialsExpired($boolean)
    {
        $this->credentialsExpired = $boolean;
        return $this;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function setLocked($locked)
    {
        $this->locked = $locked;
        return $this;
    }

    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
        return $this;
    }

    public function setPasswordRequestedAt(\DateTime $date = null)
    {
        $this->passwordRequestedAt = $date;
        return $this;
    }

    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    public function isPasswordRequestNonExpired($ttl)
    {
        return $this->getPasswordRequestedAt() instanceof \DateTime &&
               $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
    }

    public function getRoles()
    {
        if ($this->roles === null) {
            $this->roles[] = static::ROLE_DEFAULT;
        }
        return $this->roles;
    }

    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    public function setRoles(array $roles)
    {
        $this->roles = [];
        foreach ($roles as $role) {
            $this->addRole($role);
        }
        return $this;
    }

    public function addRole($role)
    {
        $role = strtoupper($role);
        if (!in_array($role, $this->getRoles(), true)) {
            $this->roles[] = $role;
        }
        return $this;
    }

    public function removeRole($role)
    {
        $role = strtoupper($role);
        if (isset($this->roles[$key])) {
            unset($this->roles[$key]);
        }
        return $this;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->usernameCanonical,
            $this->email,
            $this->emailCanonical,
            $this->password,
            $this->enabled,
            $this->locked,
            $this->expired,
            $this->expiresAt,
            $this->credentialsExpired,
            $this->credentialsExpireAt,
        ));
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        list(
            $this->id,
            $this->username,
            $this->usernameCanonical,
            $this->email,
            $this->emailCanonical,
            $this->password,
            $this->enabled,
            $this->locked,
            $this->expired,
            $this->expiresAt,
            $this->credentialsExpired,
            $this->credentialsExpireAt,
        ) = $data;
    }

    public function __toString()
    {
        return (string) $this->getUsername();
    }
}
