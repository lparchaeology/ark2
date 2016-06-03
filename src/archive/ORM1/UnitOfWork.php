<?php

/**
 * ARK ORM Unit of Work
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

/* This class is a heavily simplified version of Doctrine\ORM\UnitOfWork
 * which was originally licensed under the MIT license.
 * <http://www.doctrine-project.org>.
 */

namespace ARK\ORM;

use ARK\Database\Database;
use ARK\Error\ErrorException;
use ARK\ORM\ClassMetadata;
use ARK\ORM\EntityManager;
use ARK\ORM\Id\AssignedGenerator;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;


use Doctrine\Common\Persistence\Mapping\RuntimeReflectionService;
use Doctrine\DBAL\LockMode;
use InvalidArgumentException;
use UnexpectedValueException;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Cache\Persister\CachedPersister;
use Doctrine\ORM\Persisters\Entity\BasicEntityPersister;
use Doctrine\ORM\Persisters\Collection\OneToManyPersister;
use Doctrine\ORM\Persisters\Collection\ManyToManyPersister;

/**
 * @author      Benjamin Eberlei <kontakt@beberlei.de>
 * @author      Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author      Jonathan Wage <jonwage@gmail.com>
 * @author      Roman Borschel <roman@code-factory.org>
 * @author      Rob Caiger <rob@clocal.co.uk>
 */
class UnitOfWork
{
    private $em = null;
    // $entityWhatever[$className][$oid] => $entity (or just oid?)
    private $entityInsertions = [];
    private $entityUpdates = [];
    private $entityDeletions = [];
    private $collectionDeletions = [];
    private $collectionUpdates = [];

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function isScheduledForInsert($entity)
    {
        return $this->pendingInsert($this->em->getClassName($entity), spl_object_hash($entity));
    }

    private function pendingInsert($className, $oid)
    {
        return isset($this->entityInsertions[$className][$oid]);
    }

    public function isScheduledForUpdate($entity)
    {
        return $this->pendingUpdate($this->em->getClassName($entity), spl_object_hash($entity));
    }

    private function pendingUpdate($className, $oid)
    {
        return isset($this->entityUpdates[$className][$oid]);
    }

    public function isScheduledForDelete($entity)
    {
        return $this->pendingDelete($this->em->getClassName($entity), spl_object_hash($entity));
    }

    private function pendingDelete($className, $oid)
    {
        return isset($this->entityDeletions[$className][$oid]);
    }

    public function isScheduled($entity)
    {
        $className = $this->em->getClassName($entity);
        $oid = spl_object_hash($entity);
        return $this->pendingInsert($className, $oid)
            || $this->pendingUpdate($className, $oid)
            || $this->pendingDelete($className, $oid);
    }

    public function persist($entity)
    {
        $visited = [];
        $this->doPersist($entity, $visited);
    }

    private function doPersist($entity, array &$visited)
    {
        $oid = spl_object_hash($entity);
        if (isset($visited[$oid])) {
            return;
        }
        $visited[$oid] = $entity;

        $className = $this->em->getClassName($entity);
        $meta = $this->em->getClassMetadata($className);

        if (isset($this->entityInsertions[$className][$oid])) {
            throw new ErrorException(
                'ORM_INSERT_REPEAT',
                'ORM Repeated Insert',
                'Attempt to insert entity already scheduled for insertion'
            );
        }

        if (isset($this->entityUpdates[$className][$oid])) {
            throw new ErrorException(
                'ORM_INSERT_UPDATED',
                'ORM Insert updated entity',
                'Attempt to insert entity already scheduled for update'
            );
        }

        if ($this->pendingDelete($className, $oid)) {
            unset($this->entityDeletions[$className][$oid]);
        } else {
            $generator = $meta->getIdGenerator();
            if (!$generator->isPostInsertGenerator()) {
                $meta->setIdentifierValues($entity, $generator->generate($entity));
            }
            $this->entityInsertions[$className][$oid] = $entity;
        }

        // Cascade
        /*
        $associationMappings = array_filter(
            $meta->associationMappings,
            function ($assoc) {
                return $assoc['isCascadePersist'];
            }
        );

        foreach ($associationMappings as $assoc) {
            $relatedEntities = $meta->reflFields[$assoc['fieldName']]->getValue($entity);

            switch (true) {
                case ($relatedEntities instanceof PersistentCollection):
                    // Unwrap so that foreach() does not initialize
                    $relatedEntities = $relatedEntities->unwrap();
                    // break; is commented intentionally!

                case ($relatedEntities instanceof Collection):
                case (is_array($relatedEntities)):
                    if (($assoc['type'] & ClassMetadata::TO_MANY) <= 0) {
                        throw ORMInvalidArgumentException::invalidAssociation(
                            $this->em->getClassMetadata($assoc['targetEntity']),
                            $assoc,
                            $relatedEntities
                        );
                    }

                    foreach ($relatedEntities as $relatedEntity) {
                        $this->doPersist($relatedEntity, $visited);
                    }

                    break;

                case ($relatedEntities !== null):
                    if (! $relatedEntities instanceof $assoc['targetEntity']) {
                        throw ORMInvalidArgumentException::invalidAssociation(
                            $this->em->getClassMetadata($assoc['targetEntity']),
                            $assoc,
                            $relatedEntities
                        );
                    }

                    $this->doPersist($relatedEntities, $visited);
                    break;

                default:
                    // Do nothing
            }
        }
        */
    }

    public function update($entity)
    {
        $className = $this->em->getClassName($entity);
        $oid = spl_object_hash($entity);

        if ($this->pendingDelete($className, $oid)) {
            throw new ErrorException(
                'ORM_UPDATE_DELETE',
                'ORM update deleted entity',
                'Attempt to update entity already scheduled for deletion'
            );
        }

        if (!$this->pendingUpdate($className, $oid) && !$this->pendingInsert($className, $oid)) {
            $this->entityUpdates[$className][$oid] = $entity;
        }
    }

    public function remove($entity)
    {
        $visited = [];
        $this->doRemove($entity, $visited);
    }

    private function doRemove($entity, array &$visited)
    {
        $oid = spl_object_hash($entity);
        if (isset($visited[$oid])) {
            return;
        }
        $visited[$oid] = $entity;

        $className = $this->em->getClassName($entity);
        $meta = $this->em->getClassMetadata($className);

        // Cascade
        $associationMappings = array_filter(
            $meta->associationMappings,
            function ($assoc) {
                return $assoc['isCascadeRemove'];
            }
        );

        $entitiesToCascade = [];

        foreach ($associationMappings as $assoc) {
            if ($entity instanceof Proxy && !$entity->__isInitialized__) {
                $entity->__load();
            }

            $relatedEntities = $class->reflFields[$assoc['fieldName']]->getValue($entity);

            switch (true) {
                case ($relatedEntities instanceof Collection):
                case (is_array($relatedEntities)):
                    // If its a PersistentCollection initialization is intended! No unwrap!
                    foreach ($relatedEntities as $relatedEntity) {
                        $entitiesToCascade[] = $relatedEntity;
                    }
                    break;

                case ($relatedEntities !== null):
                    $entitiesToCascade[] = $relatedEntities;
                    break;

                default:
                    // Do nothing
            }
        }

        foreach ($entitiesToCascade as $relatedEntity) {
            $this->doRemove($relatedEntity, $visited);
        }

        // Do actual remove
        if ($this->pendingInsert($className, $oid)) {
            unset($this->entityInsertions[$className][$oid]);
            return;
        }

        unset($this->entityUpdates[$className][$oid]);

        if (!$this->pendingDelete($className, $oid)) {
            $this->entityDeletions[$className][$oid] = $entity;
        }
    }

    public function refresh($entity)
    {
        $visited = [];
        $this->doRefresh($entity, $visited);
    }

    private function doRefresh($entity, array &$visited)
    {
        $oid = spl_object_hash($entity);

        if (isset($visited[$oid])) {
            return; // Prevent infinite recursion
        }

        $visited[$oid] = $entity; // mark visited

        $meta = $this->em->getClassMetadata(get_class($entity));

        if ($this->getEntityState($entity) !== self::STATE_MANAGED) {
            throw ORMInvalidArgumentException::entityNotManaged($entity);
        }

        $this->getEntityPersister($meta->name)->refresh(
            array_combine($meta->getIdentifierFieldNames(), $entity->id()),
            $entity
        );

        // Cascade
        $associationMappings = array_filter(
            $meta->associationMappings,
            function ($assoc) {
                return $assoc['isCascadeRefresh'];
            }
        );

        foreach ($associationMappings as $assoc) {
            $relatedEntities = $meta->reflFields[$assoc['fieldName']]->getValue($entity);

            switch (true) {
                case ($relatedEntities instanceof PersistentCollection):
                    // Unwrap so that foreach() does not initialize
                    $relatedEntities = $relatedEntities->unwrap();
                    // break; is commented intentionally!

                case ($relatedEntities instanceof Collection):
                case (is_array($relatedEntities)):
                    foreach ($relatedEntities as $relatedEntity) {
                        $this->doRefresh($relatedEntity, $visited);
                    }
                    break;

                case ($relatedEntities !== null):
                    $this->doRefresh($relatedEntities, $visited);
                    break;

                default:
                    // Do nothing
            }
        }
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        if ($entity === null) {
            throw new \InvalidArgumentException("No entity passed to UnitOfWork#lock().");
        }

        if ($this->getEntityState($entity, self::STATE_DETACHED) != self::STATE_MANAGED) {
            throw ORMInvalidArgumentException::entityNotManaged($entity);
        }

        $meta = $this->em->getClassMetadata(get_class($entity));

        switch (true) {
            case LockMode::OPTIMISTIC === $lockMode:
                if (!$meta->isVersioned) {
                    throw OptimisticLockException::notVersioned($meta->name);
                }

                if ($lockVersion === null) {
                    return;
                }

                if ($entity instanceof Proxy && !$entity->__isInitialized__) {
                    $entity->__load();
                }

                $entityVersion = $meta->reflFields[$meta->versionField]->getValue($entity);

                if ($entityVersion != $lockVersion) {
                    throw OptimisticLockException::lockFailedVersionMismatch($entity, $lockVersion, $entityVersion);
                }

                break;

            case LockMode::NONE === $lockMode:
            case LockMode::PESSIMISTIC_READ === $lockMode:
            case LockMode::PESSIMISTIC_WRITE === $lockMode:
                if (!$this->em->getConnection()->isTransactionActive()) {
                    throw TransactionRequiredException::transactionRequired();
                }

                $oid = spl_object_hash($entity);

                $this->getEntityPersister($class->name)->lock(
                    array_combine($class->getIdentifierFieldNames(), $entity->id()),
                    $lockMode
                );
                break;

            default:
                // Do nothing
        }
    }

    public function clear($entityName = null)
    {
        if ($entityName === null) {
            $this->entityInsertions = [];
            $this->entityUpdates = [];
            $this->entityDeletions = [];
            $this->collectionDeletions = [];
            $this->collectionUpdates = [];
        } else {
            $this->clearIdentityMapForEntityName($entityName);
            $this->clearEntityInsertionsForEntityName($entityName);
        }
    }

    public function commit()
    {
        if (!($this->entityInsertions ||
                $this->entityDeletions ||
                $this->entityUpdates ||
                $this->collectionUpdates ||
                $this->collectionDeletions)) {
            return; // Nothing to do.
        }

        $conn = $this->em->getConnection();
        $conn->beginTransaction();

        try {
            // Collection deletions (deletions of complete collections)
            foreach ($this->collectionDeletions as $collectionToDelete) {
                $this->getCollectionPersister($collectionToDelete->getMapping())->delete($collectionToDelete);
            }

            $this->executeInserts();
            $this->executeUpdates();

            // Collection updates (deleteRows, updateRows, insertRows)
            foreach ($this->collectionUpdates as $collectionToUpdate) {
                $this->getCollectionPersister($collectionToUpdate->getMapping())->update($collectionToUpdate);
            }

            // Entity deletions come last and need to be in reverse commit order
            $this->executeDeletions();

            $conn->commit();
        } catch (Exception $e) {
            $this->em->close();
            $conn->rollBack();
            throw $e;
        }

        $this->clear();
    }

    private function executeInserts($class)
    {
        if (!$this->entityInsertions) {
            return;
        }

        $entities   = [];
        $className  = $class->name;
        $persister  = $this->getEntityPersister($className);

        foreach ($this->entityInsertions as $oid => $entity) {
            if ($this->em->getClassMetadata(get_class($entity))->name !== $className) {
                continue;
            }

            $persister->addInsert($entity);

            unset($this->entityInsertions[$oid]);
        }

        $postInsertIds = $persister->executeInserts();

        if ($postInsertIds) {
            // Persister returned post-insert IDs
            foreach ($postInsertIds as $postInsertId) {
                $id      = $postInsertId['generatedId'];
                $entity  = $postInsertId['entity'];
                $oid     = spl_object_hash($entity);
                $idField = $class->identifier[0];

                $class->reflFields[$idField]->setValue($entity, $id);

                $this->entityStates[$oid] = self::STATE_MANAGED;

                $this->addToIdentityMap($entity);
            }
        }
    }

    private function executeUpdates($class)
    {
        if (!$this->entityUpdates) {
            return;
        }

        $className = $class->name;
        $persister = $this->getEntityPersister($className);

        foreach ($this->entityUpdates as $oid => $entity) {
            if ($this->em->getClassMetadata(get_class($entity))->name !== $className) {
                continue;
            }

            if (!empty($this->entityChangeSets[$oid])) {
                $persister->update($entity);
            }

            unset($this->entityUpdates[$oid]);
        }
    }

    private function executeDeletions($class)
    {
        if (!$this->entityDeletions) {
            return;
        }

        $className  = $class->name;
        $persister  = $this->getEntityPersister($className);

        foreach ($this->entityDeletions as $oid => $entity) {
            if ($this->em->getClassMetadata(get_class($entity))->name !== $className) {
                continue;
            }

            $persister->delete($entity);

            unset($this->entityDeletions[$oid]);

            // Entity with this $oid after deletion treated as NEW, even if the $oid
            // is obtained by a new entity because the old one went out of scope.
            //$this->entityStates[$oid] = self::STATE_NEW;
            if (!$class->isIdentifierNatural()) {
                $class->reflFields[$class->identifier[0]]->setValue($entity, null);
            }
        }
    }

    public function scheduleCollectionDeletion(PersistentCollection $coll)
    {
        $coid = spl_object_hash($coll);

        // TODO: if $coll is already scheduled for recreation ... what to do?
        // Just remove $coll from the scheduled recreations?
        unset($this->collectionUpdates[$coid]);

        $this->collectionDeletions[$coid] = $coll;
    }

    public function isCollectionScheduledForDeletion(PersistentCollection $coll)
    {
        return isset($this->collectionDeletions[spl_object_hash($coll)]);
    }


    /**
     * Initializes (loads) an uninitialized persistent collection of an entity.
     *
     * @param \Doctrine\ORM\PersistentCollection $collection The collection to initialize.
     *
     * @return void
     *
     * @todo Maybe later move to EntityManager#initialize($proxyOrCollection). See DDC-733.
     */
    public function loadCollection(PersistentCollection $collection)
    {
        $assoc     = $collection->getMapping();
        $persister = $this->getEntityPersister($assoc['targetEntity']);

        switch ($assoc['type']) {
            case ClassMetadata::ONE_TO_MANY:
                $persister->loadOneToManyCollection($assoc, $collection->getOwner(), $collection);
                break;

            case ClassMetadata::MANY_TO_MANY:
                $persister->loadManyToManyCollection($assoc, $collection->getOwner(), $collection);
                break;
        }

        $collection->setInitialized(true);
    }

    /**
     * Processes an entity instance to extract their identifier values.
     *
     * @param object $entity The entity instance.
     *
     * @return mixed A scalar value.
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function getSingleIdentifierValue($entity)
    {
        $class = $this->em->getClassMetadata(get_class($entity));

        if ($class->isIdentifierComposite) {
            throw ORMInvalidArgumentException::invalidCompositeIdentifier();
        }

        $values = $class->getIdentifierValues($entity);

        return isset($values[$class->identifier[0]]) ? $values[$class->identifier[0]] : null;
    }

    /**
     * Gets the EntityPersister for an Entity.
     *
     * @param string $entityName The name of the Entity.
     *
     * @return \Doctrine\ORM\Persisters\Entity\EntityPersister
     */
    public function getEntityPersister($entityName)
    {
        if (isset($this->persisters[$entityName])) {
            return $this->persisters[$entityName];
        }

        $class = $this->em->getClassMetadata($entityName);

        switch (true) {
            case ($class->isInheritanceTypeNone()):
                $persister = new BasicEntityPersister($this->em, $class);
                break;

            case ($class->isInheritanceTypeSingleTable()):
                $persister = new SingleTablePersister($this->em, $class);
                break;

            case ($class->isInheritanceTypeJoined()):
                $persister = new JoinedSubclassPersister($this->em, $class);
                break;

            default:
                throw new \RuntimeException('No persister found for entity.');
        }

        if ($this->hasCache && $class->cache !== null) {
            $persister = $this->em->getConfiguration()
                ->getSecondLevelCacheConfiguration()
                ->getCacheFactory()
                ->buildCachedEntityPersister($this->em, $persister, $class);
        }

        $this->persisters[$entityName] = $persister;

        return $this->persisters[$entityName];
    }

    /**
     * Gets a collection persister for a collection-valued association.
     *
     * @param array $association
     *
     * @return \Doctrine\ORM\Persisters\Collection\CollectionPersister
     */
    public function getCollectionPersister(array $association)
    {
        $role = isset($association['cache'])
            ? $association['sourceEntity'] . '::' . $association['fieldName']
            : $association['type'];

        if (isset($this->collectionPersisters[$role])) {
            return $this->collectionPersisters[$role];
        }

        $persister = ClassMetadata::ONE_TO_MANY === $association['type']
            ? new OneToManyPersister($this->em)
            : new ManyToManyPersister($this->em);

        if ($this->hasCache && isset($association['cache'])) {
            $persister = $this->em->getConfiguration()
                ->getSecondLevelCacheConfiguration()
                ->getCacheFactory()
                ->buildCachedCollectionPersister($this->em, $persister, $association);
        }

        $this->collectionPersisters[$role] = $persister;

        return $this->collectionPersisters[$role];
    }

    public function initializeObject($obj)
    {
        if ($obj instanceof Proxy) {
            $obj->__load();
            return;
        }

        if ($obj instanceof PersistentCollection) {
            $obj->initialize();
        }
    }
}
