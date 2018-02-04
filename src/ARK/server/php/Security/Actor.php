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

namespace ARK\Security;

use ARK\Model\Item;
use ARK\Model\ItemTrait;
use ARK\Model\LocalText;
use ARK\Service;
use ARK\Workflow\Action;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Actor implements Item
{
    use ItemTrait;

    public function __construct(string $schema = 'core.actor')
    {
        $this->construct($schema);
    }

    public function fullname() : string
    {
        $fullname = $this->value('fullname');
        return $fullname ? $fullname->content() : '';
    }

    public function setFullname(string $name) : void
    {
        $fullname = new LocalText();
        $fullname->setContent($name);
        $this->setValue('fullname', $fullname);
    }

    public function isAgentFor(self $actor) : bool
    {
        return $this->agencies()->contains($actor);
    }

    public function agencies() : Collection
    {
        $agencies = new ArrayCollection();
        foreach ($this->roles() as $role) {
            if ($role->agentFor()) {
                $agencies->add($role->agentFor());
            }
        }
        return $agencies;
    }

    public function hasRole($role) : bool
    {
        foreach ($this->roles() as $has) {
            if ($has->role() === $role or $has->role()->id() === $role) {
                return true;
            }
        }
        return false;
    }

    public function roles() : Collection
    {
        return ActorRole::findByActor($this);
    }

    public function users() : Collection
    {
        return ActorUser::findByActor($this);
    }

    public function hasPermission($permission = null) : bool
    {
        if ($permission === null) {
            return true;
        }
        if (is_string($permission)) {
            $permission = Permission::find($permission);
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

    public function canAction(Action $action, Item $item, $attribute = null) : bool
    {
        return Service::workflow()->can($this, $action, $item, $attribute);
    }
}
