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
    protected $expiresAt = null;

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

    public function isEnabled()
    {
        // TODO Check is UTC?
        if ($this->enabled && $this->expiresAt && $this->expiresAt->getTimestamp() < time()) {
            $this->disable();
        }
        return $this->enabled;
    }

    public function enable()
    {
        $this->enabled = true;
        $this->expiresAt = null;
    }

    public function disable()
    {
        $this->enabled = false;
        $this->expiresAt = null;
    }

    public function expireAt(DateTime $date)
    {
        $this->expiresAt = $date;
        return $this;
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
        $builder->addField('expiresAt', 'datetime', [], 'expires_at');

        // Relationships
        $builder->addManyToOneField('agentFor', Actor::class, 'agent_for', 'item');
    }
}
