<?php

/**
 * ARK Event Entity.
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

namespace ARK\Entity;

use ARK\ARK;
use ARK\Model\Item;
use ARK\Model\ItemTrait;
use ARK\Security\Actor;
use ARK\Workflow\Action;

class Event implements Item
{
    use ItemTrait;

    public function __construct(Actor $agent, Action $action, Item $object)
    {
        $this->construct('core.event');
        $this->setParent($object);
        $this->setValue('agents', [$agent]);
        $this->setValue('object', $object);
        $this->setValue('class', $action->event());
        $this->setValue('occurred', ARK::timestamp());
    }

    public function term()
    {
        return $this->value('class');
    }

    public function agent()
    {
        return $this->value('agent');
    }

    public function object()
    {
        return $this->value('object');
    }

    public function occurredAt()
    {
        return $this->value('occurred');
    }
}
