<?php

/**
 * ARK User.
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
use ARK\Security\Validator\PasswordStrength;
use ARK\Service;
use ARK\Workflow\Security\ActorUser;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ClassMetadata;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Mapping\ClassMetadata as ValidatorMetadata;

class User implements AdvancedUserInterface, Serializable
{
    protected $id;
    protected $username;
    protected $email;
    protected $password = '';
    protected $name;
    protected $level = 'ROLE_ANON';
    protected $levels;
    protected $enabled = false;
    protected $verified = false;
    protected $locked = false;
    protected $expired = false;
    protected $expiresAt;
    protected $credentialsExpired = false;
    protected $credentialsExpireAt;
    protected $verificationToken;
    protected $verificationRequestedAt;
    protected $passwordRequestToken;
    protected $passwordRequestedAt;
    protected $lastLogin;
    protected $accounts;
    protected $actors;

    public function __construct(string $id, string $username = null, string $email = null)
    {
        $this->id = $id;
        $this->username = ($username ?: $id);
        $this->email = $email;
        $this->accounts = new ArrayCollection();
    }

    public function __toString() : string
    {
        return (string) $this->username();
    }

    public function id() : string
    {
        return $this->id;
    }

    // UserInterface
    public function getUsername() : string
    {
        return $this->username;
    }

    public function username() : string
    {
        return $this->username;
    }

    public function setUsername(string $username) : void
    {
        $this->username = $username;
    }

    public function email() : string
    {
        return $this->email;
    }

    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    // UserInterface
    public function getPassword() : string
    {
        return $this->password;
    }

    public function password() : string
    {
        return $this->password;
    }

    public function setPassword(string $plainPassword) : void
    {
        $this->password = Service::security()->encodePassword($plainPassword);
    }

    // UserInterface
    public function getSalt() : ?string
    {
        return null;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function displayName() : string
    {
        return $this->name ?? $this->id;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function isVerified() : bool
    {
        return $this->verified;
    }

    public function verify() : void
    {
        $this->verified = true;
    }

    // AdvancedUserInterface
    public function isEnabled() : bool
    {
        return $this->enabled;
    }

    public function enable() : void
    {
        $this->expired = false;
        $this->expiresAt = null;
        $this->enabled = true;
    }

    public function disable() : void
    {
        $this->enabled = false;
    }

    public function isLocked() : bool
    {
        return $this->locked;
    }

    // AdvancedUserInterface
    public function isAccountNonLocked() : bool
    {
        return !$this->isLocked();
    }

    public function lock() : void
    {
        $this->locked = true;
    }

    public function unlock() : void
    {
        $this->locked = false;
    }

    public function isExpired() : bool
    {
        // TODO Check is UTC?
        if (!$this->expired && $this->expiresAt instanceof DateTime && $this->expiresAt->getTimestamp() < time()) {
            $this->expire();
        }
        return $this->expired;
    }

    // AdvancedUserInterface
    public function isAccountNonExpired() : bool
    {
        return !$this->isExpired();
    }

    public function expiresAt() : ?DateTime
    {
        return $this->expiresAt;
    }

    public function expire() : void
    {
        $this->expired = true;
        $this->expiresAt = null;
    }

    public function expireAt(DateTime $date) : void
    {
        // TODO Check is UTC?
        if ($date->getTimestamp() < time()) {
            $this->expire();
            return;
        }
        $this->expired = false;
        $this->expiresAt = $date;
    }

    public function areCredentialsExpired() : bool
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
    public function isCredentialsNonExpired() : bool
    {
        return !$this->areCredentialsExpired();
    }

    public function expireCredentials() : void
    {
        $this->credentialsExpired = true;
        $this->credentialsExpireAt = null;
    }

    public function expireCredentialsAt(DateTime $date) : void
    {
        // TODO Check is UTC?
        if ($date->getTimestamp() < time()) {
            $this->expireCredentials();
            return;
        }
        $this->credentialsExpireAt = $date;
    }

    // UserInterface
    public function eraseCredentials() : void
    {
    }

    public function verificationToken() : string
    {
        // TODO Check if expired?
        return $this->verificationToken;
    }

    public function verificationRequestedAt() : ?DateTime
    {
        return $this->verificationRequestedAt;
    }

    public function setVerificationRequested() : void
    {
        $this->verificationToken = Service::security()->generateToken();
        // TODO check is UTC
        $this->verificationRequestedAt = new DateTime();
    }

    public function isVerificationRequestExpired(int $ttl) : bool
    {
        if ($this->verificationRequestedAt instanceof DateTime && $this->verificationRequestedAt->getTimestamp() + $ttl < time()) {
            $this->verificationToken = '';
            $this->verificationRequestedAt = null;
        }
        return $this->verificationToken === '';
    }

    public function passwordRequestToken() : string
    {
        return $this->passwordRequestToken;
    }

    public function passwordRequestedAt() : ?DateTime
    {
        return $this->passwordRequestedAt;
    }

    public function setPasswordRequested() : void
    {
        $this->passwordRequestToken = Service::security()->generateToken();
        // TODO check is UTC
        $this->passwordRequestedAt = new DateTime();
    }

    public function isPasswordRequestExpired(int $ttl) : bool
    {
        if ($this->getPasswordRequestedAt instanceof DateTime && $this->getPasswordRequestedAt->getTimestamp() + $ttl < time()) {
            $this->passwordRequestToken = '';
            $this->getPasswordRequestedAt = null;
        }
        return $this->passwordRequestToken === '';
    }

    public function lastLogin() : ?DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(DateTime $time = null) : void
    {
        $this->lastLogin = $time;
    }

    public function level() : string
    {
        return $this->level;
    }

    public function levels() : iterable
    {
        $this->initLevels();
        return $this->levels;
    }

    // UserInterface
    public function getRoles() : iterable
    {
        $this->initLevels();
        return $this->levels;
    }

    public function hasLevel($level) : bool
    {
        $this->initLevels();
        return in_array($level, $this->levels, true);
    }

    public function setLevel(string $level) : void
    {
        $this->level = $level;
    }

    public function accounts() : iterable
    {
        return $this->accounts;
    }

    public function hasAccount(Account $account) : bool
    {
        return $this->accounts->contains($account);
    }

    public function addAccounts(iterable $accounts) : void
    {
        foreach ($accounts as $account) {
            $this->addAccount($account);
        }
    }

    public function addAccount(Account $account) : void
    {
        if (!$this->hasAccount($account)) {
            $this->accounts->add($account);
        }
    }

    public function removeAccount(Account $account) : void
    {
        if ($this->hasAccount($account)) {
            $this->accounts->removeElement($account);
        }
    }

    public function actors() : ?iterable
    {
        if ($this->actors === null) {
            $aus = ORM::findBy(ActorUser::class, ['user' => $this->id()]);
            foreach ($aus as $au) {
                if ($au->isEnabled()) {
                    $this->actors[] = $au->actor();
                }
            }
        }
        return $this->actors;
    }

    public function hasRole(Role $role) : bool
    {
        foreach ($this->actors() as $actor) {
            if ($actor->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    public function serialize() : string
    {
        return serialize([$this->id, $this->username, $this->email]);
    }

    public function unserialize($serialized) : void
    {
        list($this->id, $this->username, $this->email) = unserialize($serialized);
    }

    public static function loadValidatorMetadata(ValidatorMetadata $metadata) : void
    {
        $metadata->addConstraint(new UniqueEntity('username'));
        $metadata->addPropertyConstraints('username', [
            new NotBlank(),
            new Regex('/^[a-zA-Z0-9]{3,30}$/us'),
        ]);

        $metadata->addConstraint(new UniqueEntity('email'));
        $metadata->addPropertyConstraints('email', [
            new NotBlank(),
            new Email(),
        ]);

        $metadata->addPropertyConstraints('_password', [
            new NotBlank(['groups' => ['full']]),
            new Length(['min' => 8, 'groups' => ['full']]),
            new PasswordStrength(2),
        ]);
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_security_user');

        // Key
        $builder->addStringKey('id', 30, 'user');

        // Attributes
        $builder->addStringField('username', 30);
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

    private function initLevels() : void
    {
        if ($this->levels !== null) {
            return;
        }
        if ($this->level === 'ROLE_USER') {
            $this->levels = ['ROLE_ANON', 'ROLE_USER'];
        } elseif ($this->level === 'ROLE_ADMIN') {
            $this->levels = ['ROLE_ANON', 'ROLE_USER', 'ROLE_ADMIN'];
        } elseif ($this->level === 'ROLE_SUPER_ADMIN') {
            $this->levels = ['ROLE_ANON', 'ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN'];
        } else {
            $this->levels = ['ROLE_ANON'];
        }
    }
}
