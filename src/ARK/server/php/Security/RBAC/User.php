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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Security\RBAC;

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Security\RBAC\Account;
use ARK\Security\RBAC\Role;
use ARK\Security\RBAC\User;
use DateTime;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;
use Serializable;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class User implements AdvancedUserInterface, Serializable
{
    use KeywordTrait;

    const ROLE_DEFAULT = 'ROLE_ANON';

    protected $user = null;
    protected $username = '';
    protected $usernameCanonical = '';
    protected $email = '';
    protected $emailCanonical = '';
    protected $password = null;
    protected $plainPassword = '';
    protected $name = '';
    protected $enabled = false;
    protected $verified = false;
    protected $locked = false;
    protected $expired = false;
    protected $expiresAt = null;
    protected $credentialsExpired = false;
    protected $credentialsExpireAt = null;
    protected $verificationToken = '';
    protected $verificationRequestedAt = null;
    protected $passwordRequestToken = '';
    protected $passwordRequestedAt = null;
    protected $lastLogin = null;
    protected $roles = null;
    protected $accounts = null;

    public function __construct($user)
    {
        $this->user = $user;
        $this->roles = new ArrayCollection();
        $this->accounts = new ArrayCollection();
    }

    public function id()
    {
        return $this->user;
    }

    public function getUsername()
    {
        return $this->username ?: $this->email;
    }

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getRealUsername()
    {
        return $this->username;
    }

    public function hasRealUsername()
    {
        return (bool) $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    public function getSalt()
    {
        return null;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDisplayName()
    {
        // TODO translate
        return $this->getName() ?: 'User ' . $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function isVerified()
    {
        return $this->verified;
    }

    public function verify()
    {
        $this->verified = true;
        return $this;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function enable()
    {
        $this->enabled = true;
        return $this;
    }

    public function disable()
    {
        $this->enabled = false;
        return $this;
    }

    public function isLocked()
    {
        return $this->locked;
    }

    public function isAccountNonLocked()
    {
        return !$this->isLocked();
    }

    public function lock()
    {
        $this->locked = true;
        return $this;
    }

    public function unlock()
    {
        $this->locked = false;
        return $this;
    }

    public function isExpired()
    {
        // TODO Check is UTC?
        if (!$this->expired && $this->expiresAt instanceof DateTime && $this->expiresAt->getTimestamp() < time()) {
            $this->expire();
        }
        return $this->expired;
    }

    public function isAccountNonExpired()
    {
        return !$this->isExpired();
    }

    public function expiresAt()
    {
        return $this->expiresAt;
    }

    public function expire()
    {
        $this->expired = true;
        $this->expiresAt = null;
        return $this;
    }

    public function expireAt(DateTime $date)
    {
        $this->expiresAt = $date;
        return $this;
    }

    public function areCredentialsExpired()
    {
        // TODO Check is UTC?
        if (!$this->credentialsExpired
            && $this->credentialsExpireAt instanceof DateTime
            && $this->credentialsExpireAt->getTimestamp() < time()) {
            $this->expireCredentials();
        }
        return $this->credentialsExpired;
    }

    public function isCredentialsNonExpired()
    {
        return !$this->areCredentialsExpired();
    }

    public function expireCredentials()
    {
        $this->credentialsExpired = $boolean;
        $this->credentialsExpireAt = null;
        return $this;
    }

    public function expireCredentialsAt(DateTime $date)
    {
        $this->credentialsExpireAt = $date;
        return $this;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function verificationToken()
    {
        // TODO Check if expired?
        return $this->verificationToken;
    }

    public function verificationRequestedAt()
    {
        return $this->verificationRequestedAt;
    }

    // TODO which way around? Do here or in command?
    public function requestVerification($token)
    {
        $this->verificationToken = $token;
        // TODO check is UTC
        $this->verificationRequestedAt = time();
        return $this;
    }

    public function isVerificationRequestExpired($ttl)
    {
        if ($this->verificationRequestedAt instanceof DateTime && $this->verificationRequestedAt->getTimestamp() + $ttl < time()) {
            $this->verificationToken = '';
            $this->verificationRequestedAt = null;
        }
        return $this->verificationToken === '';
    }

    public function passwordRequestToken()
    {
        return $this->passwordRequestToken;
    }

    public function passwordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    public function requestPassword($token)
    {
        $this->passwordRequestToken = $token;
        $this->passwordRequestedAt = time();
        return $this;
    }

    public function isPasswordRequestExpired($ttl)
    {
        if ($this->getPasswordRequestedAt instanceof DateTime && $this->getPasswordRequestedAt->getTimestamp() + $ttl < time()) {
            $this->passwordRequestToken = '';
            $this->getPasswordRequestedAt = null;
        }
        return $this->passwordRequestToken === '';
    }

    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    public function setLastLogin(DateTime $time = null)
    {
        $this->lastLogin = $time;
        return $this;
    }

    public function getRoles()
    {
        // TODO Do these need to be the string keys?
        return $this->roles;
    }

    public function roles()
    {
        return $this->roles;
    }

    public function hasRole(Role $role)
    {
        return $this->roles->contains($role);
    }

    public function addRoles(array $roles)
    {
        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }

    public function addRole(Role $role)
    {
        if (!$this->hasRole($role)) {
            $this->roles->add($role);
        }
    }

    public function removeRole(Role $role)
    {
        if ($this->hasRole($role)) {
            $this->roles->removeElement($role);
        }
    }

    public function accounts()
    {
        return $this->accounts;
    }

    public function hasAccount(Account $account)
    {
        return $this->accounts->contains($account);
    }

    public function addAccounts(array $accounts)
    {
        foreach ($accounts as $account) {
            $this->addAccount($account);
        }
    }

    public function addAccount(Account $account)
    {
        if (!$this->hasAccount($account)) {
            $this->accounts->add($account);
        }
    }

    public function removeAccount(Account $account)
    {
        if ($this->hasAccount($account)) {
            $this->accounts->removeElement($account);
        }
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->email,
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->email,
        ) = unserialize($serialized);
    }

    public function __toString()
    {
        return (string) $this->getUsername();
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_rbac_user');

        // Key
        $builder->addKey('user', 'integer');

        // Attributes
        $builder->addStringField('username', 100);
        $builder->addStringField('email', 100);
        $builder->addStringField('password', 255);
        $builder->addStringField('name', 100);
        $builder->addField('enabled', 'boolean');
        $builder->addField('verified', 'boolean');
        $builder->addField('locked', 'boolean');
        $builder->addField('expired', 'boolean');
        $builder->addField('expiresAt', 'datetime', [], 'expires_at');
        $builder->addField('credentialsExpired', 'boolean', [], 'credentials_expired');
        $builder->addField('credentialsExpireAt', 'datetime', [], 'credentials_expire_at');
        $builder->addStringField('verificationToken', 100, 'verification_token');
        $builder->addField('verificationRequestedAt', 'datetime', [], 'verification_requested_at');
        $builder->addStringField('passwordRequestToken', 100, 'password_request_token');
        $builder->addField('passwordRequestedAt', 'datetime', [], 'password_requested_at');
        $builder->addField('lastLogin', 'datetime', [], 'last_login');
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToMany('roles', User::class, 'ark_rbac_user_role');
        $builder->addManyToMany('accounts', Permission::class, 'ark_rbac_user_account');
    }
}
