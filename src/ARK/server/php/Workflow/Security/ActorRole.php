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

namespace ARK\Workflow\Security;

use ARK\Actor\Actor;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Workflow\Role;
use DateTime;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;

class ActorRole
{
    protected $actor = null;
    protected $role = null;
    protected $roleEntity = null;
    protected $agentFor = null;
    protected $enabled = false;
    protected $verified = false;
    protected $locked = false;
    protected $expired = false;
    protected $expiresAt = null;
    protected $verificationToken = '';
    protected $verificationRequestedAt = null;

    public function __construct(Actor $actor, Role $role, Actor $agentFor = null)
    {
        $this->actor = $actor;
        $this->role = $role->id();
        $this->roleEntity = $role;
        if ($role->isAgent()) {
            $this->agentFor = $agentFor;
        }
    }

    public function actor()
    {
        return $this->actor;
    }

    public function role()
    {
        if ($this->roleEntity === null) {
            $this->roleEntity = ORM::find(Role::class, $this->role);
        }
        return $this->roleEntity;
    }

    public function isAgent()
    {
        return $this->agentFor !== null;
    }

    public function agentFor()
    {
        return $this->agentFor;
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

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_actor_role');

        // Key
        $builder->addManyToOneKey('actor', Actor::class, 'actor', 'item');
        $builder->addStringKey('role', 30);

        // Attributes
        $builder->addField('enabled', 'boolean');
        $builder->addField('verified', 'boolean');
        $builder->addField('locked', 'boolean');
        $builder->addField('expired', 'boolean');
        $builder->addField('expiresAt', 'datetime', [], 'expires_at');
        $builder->addStringField('verificationToken', 100, 'verification_token');
        $builder->addField('verificationRequestedAt', 'datetime', [], 'verification_requested_at');

        // Relationships
        $builder->addManyToOneField('agentFor', Actor::class, 'proxy_for', 'item');
    }
}
