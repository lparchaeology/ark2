<?php

/**
 * ARK ORM Globals.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\ORM;

use ARK\Model\Schema\Module;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ORM
{
    public static function manager($class) : EntityManager
    {
        if ($class === 'data' || Service::entityManager('data')->manages($class)) {
            return Service::entityManager('data');
        }
        if ($class === 'config' || Service::entityManager('config')->manages($class)) {
            return Service::entityManager('config');
        }
        if ($class === 'spatial' || Service::entityManager('spatial')->manages($class)) {
            return Service::entityManager('spatial');
        }
        if ($class === 'user' || Service::entityManager('user')->manages($class)) {
            return Service::entityManager('user');
        }
        // TODO Proper error strategy?
        $class = (is_object($class) ? get_class($class) : $class);
        throw new HttpException(500, "Entity $class is not managed by the ORM");
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

    public static function flush($entity = null) : void
    {
        // By default, flush everything
        if ($entity === null) {
            // TODO manage rollback on failure?
            Service::entityManager('data')->flush();
            Service::entityManager('spatial')->flush();
            Service::entityManager('user')->flush();
            Service::entityManager('config')->flush();
            return;
        }
        // If an array or Collection, process each item
        if (is_array($entity) || $entity instanceof Collection) {
            foreach ($entity as $ent) {
                // If an object, check is persisted first
                if (is_object($ent) && !self::isScheduled($ent)) {
                    self::persist($ent);
                }
            }
            if (isset($ent)) {
                // Flush the object or classname
                $em = self::manager($ent);
                $em->flush();
                // If a data object or class, flush the spatial index as well
                if ($em->name() === 'data') {
                    self::manager('spatial')->flush();
                }
            }
        } else {
            // If an object, check is persisted first
            if (is_object($entity) && !self::isScheduled($entity)) {
                self::persist($entity);
            }
            // Flush the object or classname
            $em = self::manager($entity);
            $em->flush();
            // If a data object or class, flush the spatial index as well
            if ($em->name() === 'data') {
                self::manager('spatial')->flush();
            }
        }
    }

    public static function rollback() : void
    {
        Service::entityManager('data')->getConnection()->rollBack();
        Service::entityManager('config')->getConnection()->rollBack();
        Service::entityManager('spatial')->getConnection()->rollBack();
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

    public static function findAll($class, iterable $orderBy = null, int $limit = null, int $offset = null) : Collection
    {
        return new ArrayCollection(self::repository($class)->findBy([], $orderBy, $limit, $offset));
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
