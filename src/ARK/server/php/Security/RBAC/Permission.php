<?php

/**
 * ARK Security Permission
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
use ARK\Security\RBAC\Role;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;

class Permission
{
    use KeywordTrait;

    const GRANT = true;
    const DENY = false;
    const ABSTAIN = null;

    protected $permission = '';
    protected $roles = null;

    public function __construct($permission)
    {
        $this->permission = $permission;
        $this->roles = new ArrayCollection();
    }

    public function id()
    {
        return $this->permission;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function roles()
    {
        return $this->roles;
    }

    public function inRole(Role $role)
    {
        return $this->roles->contains($role);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_rbac_permission');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('permission', 30);

        // Attributes
        $builder->addField('enabled', 'boolean');
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToMany('roles', Role::class, 'ark_rbac_role_permission');
    }
}
