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
 */

namespace ARK\Security;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ActorRole
{
    protected $actor;
    protected $role;
    protected $roleEntity;
    protected $agentFor;
    protected $enabled = false;
    protected $expiresAt;

    public function __construct(Actor $actor, Role $role, Actor $agentFor = null)
    {
        $this->actor = $actor;
        $this->role = $role->id();
        $this->roleEntity = $role;
        $this->agentFor = ($agentFor === null) ? $actor : $agentFor;
    }

    public function actor() : Actor
    {
        return $this->actor;
    }

    public function role() : Role
    {
        if ($this->roleEntity === null) {
            $this->roleEntity = ORM::find(Role::class, $this->role);
        }
        return $this->roleEntity;
    }

    public function isAgent() : bool
    {
        return $this->agentFor->id() !== $this->actor->id();
    }

    public function agentFor() : ?Actor
    {
        return $this->isAgent() ? $this->agentFor : null;
    }

    public function isEnabled() : bool
    {
        // TODO Check is UTC?
        if ($this->enabled && $this->expiresAt && $this->expiresAt->getTimestamp() < time()) {
            $this->disable();
        }
        return $this->enabled;
    }

    public function enable() : void
    {
        $this->enabled = true;
        $this->expiresAt = null;
    }

    public function disable() : void
    {
        $this->enabled = false;
        $this->expiresAt = null;
    }

    public function expireAt(?DateTime $date) : void
    {
        $this->expiresAt = $date;
    }

    public static function findByActor($actor) : Collection
    {
        // TODO Use DQL to check enabled flag and expiry date in single query
        $id = $actor instanceof Actor ? $actor->id() : $actor;
        // Get enabled roles for actor
        $ars = ORM::findBy(self::class, ['actor' => $id, 'enabled' => true]);
        // Check for now expired roles
        $enabled = new ArrayCollection();
        foreach ($ars as $ar) {
            if ($ar->isEnabled()) {
                $enabled->add($ar);
            }
        }
        return $enabled;
    }

    public static function findByRole($role) : Collection
    {
        // TODO Use DQL to check enabled flag and expiry date in single query
        $id = $actor instanceof Role ? $role->id() : $role;
        // Get enabled roles for actor
        $ars = ORM::findBy(self::class, ['role' => $id, 'enabled' => true]);
        // Check for now expired roles
        $enabled = new ArrayCollection();
        foreach ($ars as $ar) {
            if ($ar->isEnabled()) {
                $enabled->add($ar);
            }
        }
        return $enabled;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_security_actor_role');

        // Key
        $builder->addManyToOneKey('actor', Actor::class, 'actor', 'id');
        $builder->addStringKey('role', 30);
        $builder->addManyToOneKey('agentFor', Actor::class, 'agent_for', 'id');

        // Attributes
        $builder->addField('enabled', 'boolean');
        $builder->addMappedField('expires_at', 'expiresAt', 'datetime');
    }
}
