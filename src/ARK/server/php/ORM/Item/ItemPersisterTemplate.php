<?php

/**
 * ARK ORM Item Persister
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

namespace ARK\ORM\Item;

use Doctrine\ORM\Persisters\Entity\BasicEntityPersister;

class ItemPersister extends BasicEntityPersister
{
    protected function getSelectColumnsSQL()
    {
    }

    protected function getInsertColumnList()
    {
    }

    protected function getSQLTableAlias($className, $assocName = '')
    {
    }

    protected function getSelectConditionSQL(array $criteria, $assoc = null)
    {
    }

    protected function getSelectConditionCriteriaSQL(Criteria $criteria)
    {
    }

    protected function getSelectConditionDiscriminatorValueSQL()
    {
    }

    protected function generateFilterConditionSQL(ClassMetadata $targetEntity, $targetTableAlias)
    {
    }

    public function getOwningTable($fieldName)
    {
    }

    public function executeInserts()
    {
    }

    public function update($entity)
    {
    }

    public function delete($entity)
    {
    }

    public function getSelectSQL($criteria, $assoc = null, $lockMode = null, $limit = null, $offset = null, array $orderBy = null)
    {
    }

    public function getCountSQL($criteria = array())
    {
    }

    protected function getLockTablesSql($lockMode)
    {
    }

    protected function assignDefaultVersionValue($entity, array $id)
    {
    }

    protected function prepareInsertData($entity)
    {
    }

    protected function getSelectColumnSQL($field, ClassMetadata $class, $alias = 'r')
    {
    }

    protected function getSelectJoinColumnSQL($tableAlias, $joinColumnName, $className, $type)
    {
    }
}
