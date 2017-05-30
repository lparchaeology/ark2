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

namespace ARK\Security;

use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Security\Account;
use ARK\Security\Validator\PasswordStrength;
use DateTime;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Mapping\ClassMetadata as ValidatorMetadata;

class User implements AdvancedUserInterface, Serializable
{
    protected $id = null;
    protected $username = '';
    protected $email = '';
    protected $password = null;
    protected $name = '';
    protected $level = 'ROLE_ANON';
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
    protected $accounts = null;

    public function __construct($id, $username = null, $email = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->accounts = new ArrayCollection();
    }

    public function id()
    {
        return $this->id;
    }

    // UserInterface
    public function getUsername()
    {
        return $this->username;
    }

    public function username()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function email()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    // UserInterface
    public function getPassword()
    {
        return $this->password;
    }

    public function password()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = Service::security()->encodePassword($password);
    }

    // UserInterface
    public function getSalt()
    {
        return null;
    }

    public function name()
    {
        return $this->name;
    }

    public function displayName()
    {
        // TODO translate
        return $this->getName() ?: Service::translate('User ' . $this->id);
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function isVerified()
    {
        return $this->verified;
    }

    public function verify()
    {
        $this->verified = true;
    }

    // AdvancedUserInterface
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
    }

    public function isLocked()
    {
        return $this->locked;
    }

    // AdvancedUserInterface
    public function isAccountNonLocked()
    {
        return !$this->isLocked();
    }

    public function lock()
    {
        $this->locked = true;
    }

    public function unlock()
    {
        $this->locked = false;
    }

    public function isExpired()
    {
        // TODO Check is UTC?
        if (!$this->expired && $this->expiresAt instanceof DateTime && $this->expiresAt->getTimestamp() < time()) {
            $this->expire();
        }
        return $this->expired;
    }

    // AdvancedUserInterface
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
        // TODO Check is UTC?
        if ($date->getTimestamp() < time()) {
            $this->expire();
            return;
        }
        $this->expired = false;
        $this->expiresAt = $date;
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

    // AdvancedUserInterface
    public function isCredentialsNonExpired()
    {
        return !$this->areCredentialsExpired();
    }

    public function expireCredentials()
    {
        $this->credentialsExpired = true;
        $this->credentialsExpireAt = null;
    }

    public function expireCredentialsAt(DateTime $date)
    {
        // TODO Check is UTC?
        if ($date->getTimestamp() < time()) {
            $this->expireCredentials();
            return;
        }
        $this->credentialsExpireAt = $date;
    }

    // UserInterface
    public function eraseCredentials()
    {
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

    public function lastLogin()
    {
        return $this->lastLogin;
    }

    public function setLastLogin(DateTime $time = null)
    {
        $this->lastLogin = $time;
        return $this;
    }

    public function level()
    {
        return $this->level;
    }

    public function levels()
    {
        return $this->levels;
    }

    private function initLevels()
    {
        if ($this->levels !== null) {
            return;
        }
        if ($this->level == 'ROLE_ANON' || !$this->level) {
            $this->levels = ['ROLE_ANON'];
        }
        if ($this->level == 'ROLE_USER') {
            $this->levels = ['ROLE_ANON', 'ROLE_USER'];
        }
        if ($this->level == 'ROLE_ADMIN') {
            $this->levels = ['ROLE_ANON', 'ROLE_USER', 'ROLE_ADMIN'];
        }
        if ($this->level == 'ROLE_SYSADMIN') {
            $this->levels = ['ROLE_ANON', 'ROLE_USER', 'ROLE_ADMIN', 'ROLE_SYSADMIN'];
        }
    }

    // UserInterface
    public function getRoles()
    {
        $this->initLevels();
        return $this->levels;
    }

    public function hasLevel($level)
    {
        $this->initLevels();
        return in_array($level, $this->levels);
    }

    public function setLevel($level)
    {
        $this->level = $level;
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
        return (string) $this->username();
    }

    public static function loadValidatorMetadata(ValidatorMetadata $metadata)
    {
        $metadata->addConstraint(new UniqueEntity('username'));
        $metadata->addPropertyConstraints('username', [
            new NotBlank(),
            new Regex("/^[a-zA-Z0-9]{3,30}$/us")
        ]);

        $metadata->addConstraint(new UniqueEntity('email'));
        $metadata->addPropertyConstraints('email', [
            new NotBlank(),
            new Email()
        ]);

        $metadata->addPropertyConstraints('_password', [
            new NotBlank(['groups' => ['full']]),
            new Length(['min' => 8, 'groups' => ['full']]),
            new PasswordStrength(2)
        ]);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_security_user');

        // Key
        $builder->addKey('id', 'integer', 'user');

        // Attributes
        $builder->addStringField('username', 100);
        $builder->addStringField('email', 100);
        $builder->addStringField('password', 255);
        $builder->addStringField('name', 100);
        $builder->addStringField('level', 30);
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

        // Relationships
        $builder->addManyToMany('accounts', Account::class, 'ark_auth_account');
    }
}
