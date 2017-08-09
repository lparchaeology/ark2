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
 * @php        >=5.6, >=7.0
 */

namespace ARK\ORM;

use ARK\Error\Error;
use ARK\Error\ErrorException;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class ORM
{
    public static function manager($class)
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
        throw new ErrorException(new Error('ENTITY_NOT_MANAGED', 'Entity Not Managed', "Entity $class not managed by ORM"));
    }

    public static function repository($class)
    {
        return self::manager($class)->getRepository($class);
    }

    public static function persist($entity) : void
    {
        if (!$entity) {
            return;
        }
        if (is_array($entity) || $entity instanceof \Traversable) {
            foreach ($entity as $ent) {
                self::manager($ent)->persist($ent);
            }
            return;
        }
        self::manager($entity)->persist($entity);
    }

    public static function remove($entity) : void
    {
        if (is_array($entity) || $entity instanceof \Traversable) {
            foreach ($entity as $ent) {
                self::manager($ent)->remove($ent);
            }
            return;
        }
        self::manager($entity)->remove($entity);
    }

    public static function contains($entity)
    {
        return self::manager($entity)->contains($entity);
    }

    public static function flush($class) : void
    {
        self::manager($class)->flush();
    }

    public static function clear($class) : void
    {
        self::repository($class)->clear();
    }

    public static function find($class, $id, $lockMode = null, $lockVersion = null)
    {
        return self::repository($class)->find($id, $lockMode, $lockVersion);
    }

    public static function findAll($class)
    {
        return new ArrayCollection(self::repository($class)->findAll());
    }

    public static function findBy($class, array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return new ArrayCollection(self::repository($class)->findBy($criteria, $orderBy, $limit, $offset));
    }

    public static function findOneBy($class, array $criteria, array $orderBy = null)
    {
        return self::repository($class)->findOneBy($criteria, $orderBy);
    }

    public static function matching($class, Criteria $criteria)
    {
        return self::repository($class)->matching($criteria);
    }
}
