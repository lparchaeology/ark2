<?php

/**
 * ARK Item Repository
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

namespace ARK\Model\Item;

use ARK\ORM\EntityManager;
use ARK\ORM\EntityRepository;

class ItemRepository extends EntityRepository
{
    public function findChildrenBy($parentModule, $parentId, array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->tryGetAll($this->persister->loadChildrenBy($parentModule, $parentId, $criteria, $orderBy, $limit, $offset));
    }

    public function findAllChildren($parentModule, $parentId)
    {
        return $this->tryGetAll($this->persister->loadAllChildren($parentModule, $parentId));
    }

    public function findByIndex($parent, $index)
    {
        return $this->tryGet($this->persister->loadByIndex($parent, $index));
    }

    public function findRecent(/*int*/ $limit, $parent = null)
    {
        return $this->tryGetAll($this->persister->loadRecent($limit, $parent));
    }

    public function findLast($parent = null)
    {
        return $this->tryGet($this->persister->loadLast($parent));
    }

    public function findRelated($module, $id)
    {
        return $this->persister->loadRelated($module, $id);
    }

    public function findRoot($root)
    {
        return $this->persister->loadRoot();
    }

    public function findAttributes($id, array $properties)
    {
        return $this->persister->loadAttributes($id, $properties);
    }

    protected function tryGetById($id)
    {
        // Optimised to use id directly
        $id = (is_array($id) ? $id[0] : $id);
        if (isset($identifierEntities[$id])) {
            return $entities->get($identifierEntities[$id]);
        }
        return null;
    }

    protected function tryGet($entity)
    {
        if (!$entity) {
            return $entity;
        }
        // Optimised to use id directly
        $id = $entity->id();
        if (isset($identifierEntities[$id])) {
            return $entities->get($identifierEntities[$id]);
        }
        return $this->register($entity);
    }
}
