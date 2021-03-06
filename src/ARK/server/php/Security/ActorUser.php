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
 */

namespace ARK\Security;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Service;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ActorUser
{
    protected $actor;
    protected $user;
    protected $userEntity;
    protected $enabled = false;
    protected $expiresAt;

    public function __construct(Actor $actor, User $user)
    {
        $this->actor = $actor;
        $this->user = $user->id();
        $this->userEntity = $user;
        if ($user->isEnabled()) {
            $this->enable();
        }
    }

    public function actor() : Actor
    {
        return $this->actor;
    }

    public function user() : User
    {
        if ($this->userEntity === null) {
            $this->userEntity = Service::security()->userProvider()->loadUserByUsername($this->user);
        }
        return $this->userEntity;
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
        // Get enabled users for actor
        $aus = ORM::findBy(self::class, ['actor' => $id, 'enabled' => true]);
        // Check for now expired users
        $enabled = new ArrayCollection();
        foreach ($aus as $au) {
            if ($au->isEnabled()) {
                $enabled->add($au);
            }
        }
        return $enabled;
    }

    public static function findByUser($user) : Collection
    {
        // TODO Use DQL to check enabled flag and expiry date in single query
        $id = $actor instanceof User ? $user->id() : $user;
        // Get enabled actors for user
        $aus = ORM::findBy(self::class, ['user' => $id, 'enabled' => true]);
        // Check for now expired actors
        $enabled = new ArrayCollection();
        foreach ($aus as $au) {
            if ($au->isEnabled()) {
                $enabled->add($au);
            }
        }
        return $enabled;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_security_actor_user');

        // Key
        $builder->addManyToOneKey('actor', Actor::class, 'actor', 'id');
        $builder->addStringKey('user', 30);

        // Attributes
        $builder->addField('enabled', 'boolean');
        $builder->addMappedField('expires_at', 'expiresAt', 'datetime');
    }
}
