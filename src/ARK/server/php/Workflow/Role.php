<?php

/**
 * ARK Security Role
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

namespace ARK\Workflow;

use ARK\Actor\Actor;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Workflow\Permission;
use ARK\Workflow\Security\ActorRole;
use ARK\Vocabulary\Term;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;

class Role
{
    use KeywordTrait;

    protected $role = '';
    protected $proxyFor = null;
    protected $enabled = true;
    protected $actors = null;
    protected $permissions = null;

    public function __construct($role)
    {
        $this->role = ($role instanceof Term ? $role->name() : $role);
        $this->permissions = new ArrayCollection();
    }

    public function id()
    {
        return $this->role;
    }

    public function isAgent()
    {
        return $this->proxyFor !== null;
    }

    public function agentFor()
    {
        return $this->proxyFor;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function actors()
    {
        if ($this->actors === null) {
            $ars = ORM::findBy(ActorRole::class, ['role' => $this->role]);
            $this->actors = new ArrayCollection();
            foreach ($ars as $ar) {
                $this->actors[] = $ar->actor();
            }
        }
        return $this->actors;
    }

    public function hasActor(Actor $actor)
    {
        return $this->actors()->contains($actor);
    }

    public function addActors(array $actors)
    {
        foreach ($actors as $user) {
            $this->addActor($user);
        }
    }

    public function addActor(Actor $user)
    {
        if (!$this->hasActor($user)) {
            $this->actors()->add($user);
            ORM::persist($this->actors);
        }
    }

    public function removeActor(Actor $user)
    {
        if ($this->hasActor($user)) {
            $this->actors()->removeElement($user);
            ORM::persist($this->actors);
        }
    }

    public function permissions()
    {
        return $this->permissions;
    }

    public function hasPermission(Permission $permission)
    {
        return $this->permissions->contains($permission);
    }

    public function addPermission(Permission $permission)
    {
        if (!$this->hasPermission($permission)) {
            $this->permissions->add($permission);
            ORM::persist($this);
        }
    }

    public function removePermission(Permission $permission)
    {
        if ($this->hasPermission($permission)) {
            $this->permissions->removeElement($permission);
            ORM::persist($this);
        }
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_workflow_role');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('role', 30);

        // Attributes
        $builder->addStringField('proxyFor', 30, 'proxy_for');
        $builder->addField('enabled', 'boolean');
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToMany('permissions', Permission::class, 'ark_workflow_grant', 'role', 'permission');
    }
}
