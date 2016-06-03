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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Security\User;

use ARK\ORM\EntityTrait;
use Doctrine\Common\Collections\ArrayCollection;

class Role
{
    use EntityTrait;

    protected $keyword;
    protected $permissions;

    public function __construct($id, $keyword)
    {
        $this->id = $id;
        $this->keyword = $keyword;
        $this->permissions = new ArrayCollection();
    }

    public function keyword()
    {
        return $this->keyword;
    }

    public function permissions()
    {
        return $this->permissions;
    }

    public function addPermission(Permission $permission)
    {
        if (!$this->hasPermission($permission)) {
            $this->permissions->add($permission);
        }
    }

    public function removePermission(Permission $permission)
    {
        if ($this->hasPermission($permission)) {
            $this->permissions->removeElement($permission);
        }
    }

    public function hasPermission(Permission $permission)
    {
        return $this->permissions->contains($permission);
    }
}
