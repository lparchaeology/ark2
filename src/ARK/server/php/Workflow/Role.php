<?php

/**
 * ARK Workflow Role.
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

namespace ARK\Workflow;

use ARK\Actor\Actor;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Vocabulary\Term;
use ARK\Workflow\Security\ActorRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Role
{
    use KeywordTrait;

    protected $role;
    protected $agentFor;
    protected $level;
    protected $enabled = true;
    protected $actors;
    protected $permissions;

    public function __construct($role, string $level = 'ROLE_USER')
    {
        $this->role = ($role instanceof Term ? $role->name() : $role);
        $level = $level;
        $this->actors = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    public function id() : string
    {
        return $this->role;
    }

    public function isAgent() : bool
    {
        return $this->agentFor !== null;
    }

    public function agentFor() : ?string
    {
        return $this->agentFor;
    }

    public function level() : string
    {
        return $this->level;
    }

    public function isEnabled() : bool
    {
        return $this->enabled;
    }

    public function actors() : Collection
    {
        if ($this->actors === null) {
            $ars = ORM::findBy(ActorRole::class, ['role' => $this->role]);
            $this->actors = new ArrayCollection();
            foreach ($ars as $ar) {
                $this->actors->add($ar->actor());
            }
        }
        return $this->actors;
    }

    public function hasActor(Actor $actor) : bool
    {
        return $this->actors()->contains($actor);
    }

    public function addActors(array $actors) : void
    {
        foreach ($actors as $user) {
            $this->addActor($user);
        }
    }

    public function addActor(Actor $user) : void
    {
        if (!$this->hasActor($user)) {
            $this->actors()->add($user);
            ORM::persist($this->actors);
        }
    }

    public function removeActor(Actor $user) : void
    {
        if ($this->hasActor($user)) {
            $this->actors()->removeElement($user);
            ORM::persist($this->actors);
        }
    }

    public function permissions() : Collection
    {
        return $this->permissions;
    }

    public function hasPermission(Permission $permission) : bool
    {
        return $this->permissions->contains($permission);
    }

    public function addPermission(Permission $permission) : void
    {
        if (!$this->hasPermission($permission)) {
            $this->permissions->add($permission);
            ORM::persist($this);
        }
    }

    public function removePermission(Permission $permission) : void
    {
        if ($this->hasPermission($permission)) {
            $this->permissions->removeElement($permission);
            ORM::persist($this);
        }
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_role');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('role', 30);

        // Attributes
        $builder->addStringField('agentFor', 30, 'agent_for');
        $builder->addStringField('level', 30);
        $builder->addField('enabled', 'boolean');
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToMany('permissions', Permission::class, 'ark_workflow_grant', 'role', 'permission');
    }
}
