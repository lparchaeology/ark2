<?php

/**
 * ARK Entity Repository
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

namespace ARK\ORM;

use ARK\Error\ErrorException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Exception;

class EntityRepository implements ObjectRepository, Selectable
{
    protected $meta = null;
    protected $persister = null;
    // $entities[$oid] => $entity
    protected $entities = null;
    // $identifierEntities[$idHash] => $oid
    protected $identifierEntities = [];
    // $entityIdentifiers[$oid] => $idHash
    protected $entityIdentifiers = [];
    // $postInsertIdentifiers[] => $oid
    protected $postInsertIdentifiers = [];

    public function __construct(ClassMetadata $meta)
    {
        $this->meta = $meta;
        $this->persister = $meta->getPersister();
        $this->entities = new ArrayCollection();
    }

    protected function register($entity)
    {
        $hash = spl_object_hash($entity);
        $idHash = $this->meta->getIdentifierHash($entity);
        $this->entities[$hash] = $entity;
        if ($idHash) {
            $this->identifierEntities[$idHash] = $hash;
            $this->entityIdentifiers[$hash] = $idHash;
        } elseif ($this->meta->getIdGenerator()->isPostInsertGenerator()) {
            $this->postInsertIdentifiers[] = $hash;
        } else {
            throw new ErrorException(
                'ORM_MISSING_ID',
                'Entity Missing Identifier',
                'Entity has not been assigned an identifier'
            );
        }
        return $entity;
    }

    public function manage($entity)
    {
        // TODO validity checks on $entity
        $this->register($entity);
    }

    public function contains($entity)
    {
        $this->entities->containsKey(spl_object_hash($entity));
    }

    public function refresh($entity)
    {
        // TODO
    }

    public function clear()
    {
        $this->entities->clear();
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        // TODO See Doctrine UoW
    }

    // reimp ObjectRepository
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        // TODO See Doctrine EM, $lock
        if ($managed = $this->tryGetById($id)) {
            return $managed;
        }
        if ($entity = $this->persister->load($id)) {
            return $this->register($entity);
        }
        return null;
    }

    // reimp ObjectRepository
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->tryGetAll($this->persister->loadAll($criteria, $orderBy, $limit, $offset));
    }

    // reimp ObjectRepository
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->tryGet($this->persister->loadOneBy($criteria, $orderBy, 1));
    }

    // reimp ObjectRepository
    public function findAll()
    {
        return $this->tryGetAll($this->persister->loadAll());
    }

    public function count(array $criteria)
    {
        return $this->persister->count($criteria);
    }

    public function matching(Criteria $criteria)
    {
        return new LazyCriteriaCollection($this->persister, $criteria);
    }

    public function getReference($id)
    {
        // TODO See Doctrine EM
    }

    public function getPartialReference($id)
    {
        // TODO See Doctrine EM
    }

    // reimp ObjectRepository
    public function getClassName()
    {
        return $this->meta->getName();
    }

    public function getClassMetadata()
    {
        return $this->meta();
    }

    protected function tryGetById($id)
    {
        $idHash = $this->meta->getIdentifierHash($id);
        if (isset($identifierEntities[$idHash])) {
            return $entities->get($identifierEntities[$idHash]);
        }
        return null;
    }

    protected function tryGet($entity)
    {
        if ($managed = $this->tryGetById($this->meta->getIdentifierValues($entity))) {
            return $managed;
        }
        return $this->register($entity);
    }

    protected function tryGetAll(array $entities)
    {
        $all = [];
        foreach ($entities as $entity) {
            $all[] = $this->tryGet($entity);
        }
        return $all;
    }
}
