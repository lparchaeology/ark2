<?php

/**
 * ARK Message Entity
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
namespace ARK\Message;

use ARK\Actor\Actor;
use ARK\ARK;
use ARK\Model\Item;
use ARK\Model\ItemTrait;
use DateTime;
use ARK\Service;

class Message implements Item
{
    use ItemTrait;

    public function __construct(Actor $sender, array $recipients, DateTime $sentAt)
    {
        $this->construct('core.message');
        $this->property('sender')->setValue($sender);
        $dispatches =[];
        foreach ($recipients as $recipient) {
            $dispatches[]['recipient'] = $recipient;
        }
        $this->property('recipients')->setValue($dispatches);
        $this->property('sent')->setValue($sentAt);
    }

    public function sender()
    {
        return $this->property('sender')->value();
    }

    public function recipients()
    {
        return $this->property('recipients')->serialize();
    }

    public function sentAt()
    {
        return $this->property('sent')->value();
    }

    public function isRecipient(Actor $actor)
    {
        foreach ($this->recipients() as $dispatch) {
            if ($actor->id() == $dispatch['recipient']['item']) {
                return true;
            }
        }
        return false;
    }

    public function markAsRead(Actor $actor)
    {
        return Service::database()->markMessageAsRead($this->id(), $actor->id());
    }

    public function wasReadBy(Actor $actor)
    {
        foreach ($this->recipients() as $dispatch) {
            if ($actor->id() == $dispatch['recipient']['item'] && isset($dispatch['read'])) {
                return true;
            }
        }
        return false;
    }
}
