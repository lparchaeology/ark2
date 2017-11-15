<?php

/**
 * ARK ORM Globals.
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

namespace ARK\ORM;

use ARK\Error\Error;
use ARK\Http\Exception\InternalServerHttpException;
use ARK\Model\Schema\Module;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

class ORM
{
    public static function manager($class) : EntityManager
    {
        if ($class === 'data' || Service::entityManager('data')->manages($class)) {
            return Service::entityManager('data');
        }
        if ($class === 'core' || Service::entityManager('core')->manages($class)) {
            return Service::entityManager('core');
        }
        if ($class === 'user' || Service::entityManager('user')->manages($class)) {
            return Service::entityManager('user');
        }
        // TODO Proper error strategy?
        $class = (is_object($class) ? get_class($class) : $class);
        throw new InternalServerHttpException(
            'ENTITY_NOT_MANAGED',
            "Entity $class is not managed by the ORM"
        );
    }

    public static function repository($class)
    {
        return self::manager($class)->getRepository($class);
    }

    public static function persist($entity) : void
    {
        if (is_array($entity) || $entity instanceof Collection) {
            foreach ($entity as $ent) {
                self::manager($ent)->persist($ent);
            }
        } elseif (is_object($entity)) {
            self::manager($entity)->persist($entity);
        }
    }

    public static function remove($entity) : void
    {
        if (is_array($entity) || $entity instanceof Collection) {
            foreach ($entity as $ent) {
                self::manager($ent)->remove($ent);
            }
            return;
        } elseif (is_object($entity)) {
            self::manager($entity)->remove($entity);
        }
    }

    public static function contains($entity) : bool
    {
        return self::manager($entity)->contains($entity);
    }

    public static function isScheduled($entity) : bool
    {
        return self::manager($entity)->getUnitOfWork()->isEntityScheduled($entity);
    }

    public static function flush($entity) : void
    {
        if (is_array($entity) || $entity instanceof Collection) {
            foreach ($entity as $ent) {
                if (is_object($ent) && !self::isScheduled($ent)) {
                    self::persist($ent);
                }
            }
            if (isset($ent)) {
                self::manager($ent)->flush();
            }
        } else {
            if (is_object($entity) && !self::isScheduled($entity)) {
                self::persist($entity);
            }
            self::manager($entity)->flush();
        }
    }

    public static function rollback() : void
    {
        Service::entityManager('data')->getConnection()->rollBack();
        Service::entityManager('core')->getConnection()->rollBack();
        Service::entityManager('user')->getConnection()->rollBack();
    }

    public static function clear($class) : void
    {
        self::repository($class)->clear();
    }

    public static function find($class, $id, $lockMode = null, $lockVersion = null)
    {
        return self::repository($class)->find($id, $lockMode, $lockVersion);
    }

    public static function findAll($class) : Collection
    {
        return new ArrayCollection(self::repository($class)->findAll());
    }

    public static function findBy(
        $class,
        iterable $criteria,
        iterable $orderBy = null,
        int $limit = null,
        int $offset = null
    ) : Collection {
        return new ArrayCollection(self::repository($class)->findBy($criteria, $orderBy, $limit, $offset));
    }

    public static function findOneBy($class, iterable $criteria, iterable $orderBy = null)
    {
        return self::repository($class)->findOneBy($criteria, $orderBy);
    }

    public static function findItemByModule(string $module, string $id)
    {
        return self::find(Module::class, $module)->find($id);
    }

    public static function matching($class, Criteria $criteria)
    {
        return self::repository($class)->matching($criteria);
    }

    public static function count($class, iterable $criteria) : int
    {
        return self::findBy($class, $criteria)->count();
    }
}
