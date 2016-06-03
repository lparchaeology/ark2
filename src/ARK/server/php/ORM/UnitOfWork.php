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

namespace ARK\ORM;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork as DoctrineUnitOfWork;
use ReflectionClass;

class UnitOfWork extends DoctrineUnitOfWork
{
    protected $em2 = null;
    protected $refl = null;
    protected $reflPersisters = null;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
        $this->em2 = $em;
        $this->refl = new ReflectionClass('Doctrine\ORM\UnitOfWork');
        $this->reflPersisters = $this->refl->getProperty('persisters');
        $this->reflPersisters->setAccessible(true);
    }

    public function getEntityPersister($entityName)
    {
        $persisters = $this->reflPersisters->getValue($this);
        if (isset($persisters[$entityName])) {
            return $persisters[$entityName];
        }

        $meta = $this->em2->getClassMetadata($entityName);
        $persister = $meta->getEntityPersister($this->em2);

        if ($this->hasCache && $meta->cache !== null) {
            $persister = $this->em2->getConfiguration()
                ->getSecondLevelCacheConfiguration()
                ->getCacheFactory()
                ->buildCachedEntityPersister($this->em2, $persister, $meta);
        }

        $persisters[$entityName] = $persister;
        $this->reflPersisters->setValue($this, $persisters);
        return $persister;
    }
}
