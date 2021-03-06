<?php

/**
 * ARK ORM Class Metadata.
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

use ARK\ORM\Item\ItemPersister;
use ARK\ORM\Item\ItemSingleTablePersister;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata as DoctrineClassMetadata;
use Doctrine\ORM\Persisters\Entity\BasicEntityPersister;
use Doctrine\ORM\Persisters\Entity\JoinedSubclassPersister;
use Doctrine\ORM\Persisters\Entity\SingleTablePersister;
use RuntimeException;

class ClassMetadata extends DoctrineClassMetadata
{
    public $isItemEntity = false;
    public $classnames;

    public function setItemEntity(bool $status) : void
    {
        $this->isItemEntity = $status;
    }

    public function setClassNames(iterable $classnames) : void
    {
        $this->classnames = $classnames;
    }

    public function getEntityPersister(EntityManagerInterface $em)
    {
        if ($this->isInheritanceTypeNone()) {
            if ($this->isItemEntity) {
                return new ItemPersister($em, $this);
            }
            return new BasicEntityPersister($em, $this);
        }

        if ($this->isInheritanceTypeSingleTable()) {
            if ($this->isItemEntity) {
                return new ItemSingleTablePersister($em, $this);
            }
            return new SingleTablePersister($em, $this);
        }

        if ($this->isInheritanceTypeJoined()) {
            return new JoinedSubclassPersister($em, $this);
        }

        throw new RuntimeException('No persister found for entity.');
    }
}
