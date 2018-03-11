<?php

/**
 * ARK ORM Trait.
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

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;

trait OrmTrait
{
    public static function find(string $id) : ?self
    {
        return ORM::find(get_called_class(), $id);
    }

    public static function findAll() : Collection
    {
        return ORM::findAll(get_called_class());
    }

    public static function findBy(
        iterable $criteria,
        iterable $orderBy = null,
        int $limit = null,
        int $offset = null
    ) : Collection {
        return ORM::findBy(get_called_class(), $criteria, $orderBy, $limit, $offset);
    }

    public static function findOneBy(iterable $criteria, iterable $orderBy = null)
    {
        return ORM::findOneBy(get_called_class(), $criteria, $orderBy);
    }

    public static function matching(Criteria $criteria)
    {
        return ORM::matching(get_called_class(), $criteria);
    }

    public static function count(iterable $criteria) : int
    {
        return ORM::count(get_called_class(), $criteria);
    }
}
