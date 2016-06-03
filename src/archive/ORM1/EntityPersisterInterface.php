<?php

/**
 * ARK Entity Persister Interface
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

use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
interface EntityPersisterInterface
{
    public function getClassMetadata();

    public function insert(array $entities);

    public function update($entity);

    public function delete($entity);

    public function count($criteria = array());

    public function load($id, $entity = null, $lockMode = null, $lockVersion = null);

    public function loadOneBy(array $criteria, $entity = null, $lockMode = null, array $orderBy = null);

    public function loadAll(array $criteria = [], array $orderBy = null, $limit = null, $offset = null);

    public function loadOneToOneEntity(array $assoc, $sourceEntity, array $identifier = []);

    public function getManyToManyCollection(array $assoc, $sourceEntity, $offset = null, $limit = null);

    public function loadManyToManyCollection(array $assoc, $sourceEntity, PersistentCollection $collection);

    public function getOneToManyCollection(array $assoc, $sourceEntity, $offset = null, $limit = null);

    public function loadOneToManyCollection(array $assoc, $sourceEntity, PersistentCollection $collection);

    public function lock(array $criteria, $lockMode);

    public function expandParameters($criteria);

    public function loadCriteria(Criteria $criteria);

    public function exists($entity, Criteria $extraConditions = null);

    public function expandCriteriaParameters(Criteria $criteria);
}
