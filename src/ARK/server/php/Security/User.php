<?php

/**
 * ARK User.
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
 * @php        >=5.6, >=7.0
 */

namespace ARK\Security;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Security\Validator\PasswordStrength;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    protected $system = false;
    protected $enabled = false;
    protected $activated = false;
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

    public function __construct(string $id = null, string $username = null, string $email = null)
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

    public function setId($id) : void
    {
        $this->id = $id;
    }

    // UserInterface
    public function getUsername() : ?string
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

    public function email() : ?string
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
        $this->passwordRequestToken = '';
        $this->passwordRequestedAt = null;
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

    public function status() : Term
    {
        if ($this->isExpired()) {
            return Vocabulary::findTerm('core.security.user.status', 'expired');
        }
        if ($this->isLocked()) {
            return Vocabulary::findTerm('core.security.user.status', 'locked');
        }
        if ($this->isEnabled()) {
            return Vocabulary::findTerm('core.security.user.status', 'enabled');
        }
        if ($this->isActivated()) {
            return Vocabulary::findTerm('core.security.user.status', 'disabled');
        }
        if ($this->isVerified()) {
            return Vocabulary::findTerm('core.security.user.status', 'verified');
        }
        return Vocabulary::findTerm('core.security.user.status', 'registered');
    }

    public function isSystemUser() : bool
    {
        return $this->system;
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
        $this->activated = true;
        $this->enabled = true;
        $this->resetLevel();
    }

    public function disable() : void
    {
        $this->enabled = false;
    }

    public function isActivated() : bool
    {
        return $this->activated;
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

    public function isVerified() : bool
    {
        return $this->verified;
    }

    public function verify() : void
    {
        $this->verified = true;
        $this->verificationToken = '';
        $this->verificationRequestedAt = null;
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
        if ($this->passwordRequestedAt instanceof DateTime && $this->passwordRequestedAt->getTimestamp() + $ttl < time()) {
            $this->passwordRequestToken = '';
            $this->passwordRequestedAt = null;
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
        $this->levels = null;
    }

    public function resetLevel() : void
    {
        $levels = [];
        foreach ($this->roles() as $role) {
            $levels[$role->level()] = $role->level();
        }
        $this->level = $levels['ROLE_SUPER_ADMIN'] ?? $levels['ROLE_ADMIN'] ?? $levels['ROLE_USER'] ?? 'ROLE_ANON';
        $this->levels = null;
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

    public function actor() : ?Actor
    {
        return Actor::find($this->id());
    }

    public function actors() : iterable
    {
        $aus = ORM::findBy(ActorUser::class, ['user' => $this->id()]);
        $actors = new ArrayCollection();
        foreach ($aus as $au) {
            if ($au->isEnabled()) {
                $actors->add($au->actor());
            }
        }
        return $actors;
    }

    public function isActor(Actor $actor) : bool
    {
        return $this->actors()->contains($actor);
    }

    public function roles() : iterable
    {
        $roles = [];
        foreach ($this->actors() as $actor) {
            foreach ($actor->roles() as $role) {
                $roles[$role->role()->id()] = $role->role();
            }
        }
        return array_values($roles);
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

    public function hasPermission($permission = null) : bool
    {
        if ($permission === null) {
            return true;
        }
        foreach ($this->actors() as $actor) {
            if ($actor->hasPermission($permission)) {
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

    public static function find(string $id) : ?self
    {
        return ORM::find(self::class, $id);
    }

    public static function findAll() : ?Collection
    {
        return ORM::findAll(self::class);
    }

    public static function findByStatus($status) : ?Collection
    {
        if (is_string($status)) {
            $status = Vocabulary::findTerm('core.security.user.status', $status);
        }
        if (!$status instanceof Term || $status->concept()->id() !== 'core.security.user.status') {
            return new ArrayCollection();
        }
        switch ($status->name()) {
            case 'disabled':
                return ORM::findBy(self::class, ['enabled' => false, 'activated' => true]);
            case 'expired':
                // TODO What about past expiry but not expired???
                return ORM::findBy(self::class, ['expired' => true]);
            case 'locked':
                return ORM::findBy(self::class, ['locked' => true]);
            case 'enabled':
                // TODO What about past expiry but not expired???
                return ORM::findBy(self::class, ['enabled' => true, 'activated' => true]);
            case 'verified':
                return ORM::findBy(self::class, ['verified' => true, 'activated' => false]);
            case 'registered':
                return ORM::findBy(self::class, ['activated' => false, 'verified' => false]);
        }
        return new ArrayCollection();
    }

    public static function loadValidatorMetadata(ValidatorMetadata $metadata) : void
    {
        // username must be unique
        $metadata->addConstraint(
            new UniqueEntity([
                'fields' => 'username',
                'em' => 'user',
            ])
        );
        // email must be unique
        $metadata->addConstraint(
            new UniqueEntity([
                'fields' => 'email',
                'em' => 'user',
            ])
        );

        $metadata->addPropertyConstraints('username', [
            //new NotBlank(),
            new Regex('/^[a-zA-Z0-9]{3,30}$/us'),
        ]);

        $metadata->addPropertyConstraints('email', [
            //new NotBlank(),
            new Email(),
        ]);

        $metadata->addPropertyConstraints('password', [
            //new NotBlank(['groups' => ['full']]),
            new Length(['min' => 8, 'groups' => ['full']]),
            //new PasswordStrength(1),
        ]);
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_security_user');

        // Key
        $builder->addMappedStringKey('user', 'id', 30);

        // Attributes
        $builder->addStringField('username', 30);
        $builder->addStringField('email', 100);
        $builder->addStringField('password', 255);
        $builder->addStringField('name', 100);
        $builder->addStringField('level', 30);
        $builder->addField('system', 'boolean');
        $builder->addField('enabled', 'boolean');
        $builder->addField('activated', 'boolean');
        $builder->addField('verified', 'boolean');
        $builder->addField('locked', 'boolean');
        $builder->addField('expired', 'boolean');
        $builder->addMappedField('expires_at', 'expiresAt', 'datetime');
        $builder->addMappedField('credentials_expired', 'credentialsExpired', 'boolean');
        $builder->addMappedField('credentials_expire_at', 'credentialsExpireAt', 'datetime');
        $builder->addMappedStringField('verification_token', 'verificationToken', 100);
        $builder->addMappedField('verification_requested_at', 'verificationRequestedAt', 'datetime');
        $builder->addMappedStringField('password_request_token', 'passwordRequestToken', 100);
        $builder->addMappedField('password_requested_at', 'passwordRequestedAt', 'datetime');
        $builder->addMappedField('last_login', 'lastLogin', 'datetime');

        // Relationships
        $builder->addOneToManyField('accounts', Account::class, 'user');
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
