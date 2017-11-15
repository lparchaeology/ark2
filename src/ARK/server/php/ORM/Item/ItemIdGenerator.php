<?php

/**
 * ARK ORM Table ID Generator.
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
 *
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\ORM\Item;

use ARK\Http\Exception\InternalServerHttpException;
use ARK\Model\Item;
use ARK\Service;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

class ItemIdGenerator extends AbstractIdGenerator
{
    public function generate(DoctrineEntityManager $em, $entity)
    {
        if (!$entity instanceof Item) {
            throw new InternalServerHttpException(
                'ORM_INVALID_ENTITY',
                'Only objects of class Item can use the ItemSequenceGenerator'
            );
        }
        $strategy = $entity->schema()->generator();
        if ($strategy === 'assigned') {
            return $entity->id();
        }
        $parentId = '';
        $parent = '';
        if ($strategy === 'hierarchy' && $entity->parent()) {
            $parentModule = $entity->parent()->schema()->module()->id();
            $parentId = $entity->parent()->id();
            $parent = $this->makeIdentifier($parentModule, '.', $parentId);
        }
        $index = Service::database()->data()->generateSequence(
            $entity->schema()->module()->id(),
            $parent, $entity->schema()->sequence()
        );
        $id = $this->makeIdentifier($parent, '.', $index);
        $label = $this->makeIdentifier($parentId, '_', $index);
        $entity->setId($id, $index, $label);

        return $id;
    }

    protected function makeIdentifier($parentId, $sep, $index)
    {
        return $parentId && $index ? $parentId.$sep.$index : $index;
    }
}
