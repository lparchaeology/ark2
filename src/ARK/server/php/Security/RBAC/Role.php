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

namespace ARK\Security\RBAC;

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Security\RBAC\Permission;
use ARK\Security\RBAC\User;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;

class Role
{
    use KeywordTrait;

    protected $role = '';
    protected $enabled = true;
    protected $users = null;
    protected $permissions = null;

    public function __construct($role)
    {
        $this->role = $role;
        $this->users = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    public function id()
    {
        return $this->role;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function users()
    {
        return $this->users;
    }

    public function hasUser(User $user)
    {
        return $this->users->contains($user);
    }

    public function addUsers(array $users)
    {
        foreach ($users as $user) {
            $this->addUser($user);
        }
    }

    public function addUser(User $user)
    {
        if (!$this->hasUser($user)) {
            $this->users->add($user);
            ORM::persist(Role::class, $this);
        }
    }

    public function removeUser(User $user)
    {
        if ($this->hasUser($user)) {
            $this->users->removeElement($user);
            ORM::persist(Role::class, $this);
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
            ORM::persist(Role::class, $this);
        }
    }

    public function removePermission(Permission $permission)
    {
        if ($this->hasPermission($permission)) {
            $this->permissions->removeElement($permission);
            ORM::persist(Role::class, $this);
        }
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_rbac_role');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('role', 30);

        // Attributes
        $builder->addField('enabled', 'boolean');
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToMany('users', User::class, 'ark_rbac_user_role');
        $builder->addManyToMany('permissions', Permission::class, 'ark_rbac_role_permission');
    }
}
