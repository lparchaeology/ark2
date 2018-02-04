<?php

/**
 * ARK ORM Unit of Work.
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

use ARK\Utility\ReflectionTrait;
use Doctrine\ORM\Persisters\Entity\EntityPersister;
use Doctrine\ORM\UnitOfWork as DoctrineUnitOfWork;

class UnitOfWork extends DoctrineUnitOfWork
{
    use ReflectionTrait;

    public function getEntityPersister($entityName) : EntityPersister
    {
        $persisters = $this->reflectGetValue('persisters');
        if (isset($persisters[$entityName])) {
            return $persisters[$entityName];
        }

        $em = $this->reflectGetValue('em');
        $meta = $em->getClassMetadata($entityName);
        $persister = $meta->getEntityPersister($em);

        if ($this->hasCache && $meta->cache !== null) {
            $persister = $em->getConfiguration()
                ->getSecondLevelCacheConfiguration()
                ->getCacheFactory()
                ->buildCachedEntityPersister($em, $persister, $meta);
        }

        $persisters[$entityName] = $persister;
        $this->reflectSetValue('persisters', $persisters);
        return $persister;
    }
}
