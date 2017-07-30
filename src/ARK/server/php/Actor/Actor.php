<?php

/**
 * ARK Actor Entity.
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

namespace ARK\Actor;

use ARK\Model\Item;
use ARK\Model\ItemTrait;
use ARK\Model\LocalText;
use ARK\ORM\ORM;
use ARK\Workflow\Permission;
use ARK\Workflow\Role;
use ARK\Workflow\Security\ActorRole;
use Doctrine\Common\Collections\ArrayCollection;

class Actor implements Item
{
    use ItemTrait;

    protected $roles;

    public function __construct(string $schema = 'core.actor')
    {
        $this->construct($schema);
    }

    public function fullname() : string
    {
        $fullname = $this->property('fullname')->value();
        return $fullname ? $fullname->content() : '';
    }

    public function setFullname(string $name) : void
    {
        $fullname = new LocalText();
        $fullname->setContent($name);
        $this->property('fullname')->setValue($fullname);
    }

    public function hasRole($role) : bool
    {
        foreach ($this->roles() as $has) {
            if ($has === $role or $has->role()->id() === $role) {
                return true;
            }
        }
        return false;
    }

    public function roles() : ArrayCollection
    {
        if ($this->roles === null) {
            $this->roles = new ArrayCollection();
            $ars = ORM::findBy(ActorRole::class, ['actor' => $this->id()]);
            foreach ($ars as $ar) {
                if ($ar->isEnabled()) {
                    $this->roles->add($ar->role());
                }
            }
        }
        return $this->roles;
    }

    public function addRole($role, Actor $agentFor = null) : void
    {
        if ($this->hasRole($role) && $agentFor === null) {
            return;
        }
        if (is_string($role)) {
            $role = ORM::find(Role::class, $role);
        }
        if ($role instanceof Role) {
            $actorRole = new ActorRole($actor, $role, $agentFor);
            ORM::persist($actorRole);
            $this->roles->append($actorRole);
            ORM::persist($this);
        }
    }

    public function hasPermission($permission = null) : bool
    {
        if ($permission === null) {
            return true;
        }
        if (is_string($permission)) {
            $permission = ORM::find(Permission::class, $permission);
        }
        if ($permission instanceof Permission) {
            foreach ($this->roles() as $role) {
                if ($role->role()->hasPermission($permission)) {
                    return true;
                }
            }
        }
        return false;
    }
}
