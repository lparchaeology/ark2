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

namespace ARK\Workflow\Security;

use ARK\Actor\Actor;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Security\User;
use ARK\Service;
use DateTime;

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

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_actor_user');

        // Key
        $builder->addManyToOneKey('actor', Actor::class, 'actor', 'id');
        $builder->addStringKey('user', 30);

        // Attributes
        $builder->addField('enabled', 'boolean');
        $builder->addMappedField('expires_at', 'expiresAt', 'datetime');
    }
}
