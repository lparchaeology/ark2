<?php

/**
 * ARK Notification Entity.
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

namespace ARK\Message;

use ARK\Actor\Actor;
use ARK\ARK;
use ARK\Model\LocalText;
use ARK\Workflow\Event;

class Notification extends Message
{
    public function __construct(Actor $sender, iterable $recipients, Event $event, LocalText $message = null)
    {
        parent::__construct($sender, $recipients, new LocalText(), $message ?? new LocalText());
        $this->setEvent($event);
    }

    public function event() : Event
    {
        return $this->value('event');
    }

    public function setEvent(Event $event) : void
    {
        $this->setValue('event', $event);
    }
}
