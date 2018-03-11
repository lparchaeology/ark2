<?php

/**
 * ARK Message Entity.
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

namespace ARK\Message;

use ARK\ARK;
use ARK\Model\Fragment\DateTimeFragment;
use ARK\Model\Fragment\ItemFragment;
use ARK\Model\Item;
use ARK\Model\ItemTrait;
use ARK\Model\LocalText;
use ARK\ORM\ORM;
use ARK\Security\Actor;
use ARK\Security\Role;
use ARK\Service;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Message implements Item
{
    use ItemTrait;

    public function __construct(Actor $sender, iterable $recipients, LocalText $subject, LocalText $body)
    {
        $this->construct('core.message');
        $this->setSender($sender);
        $this->setRecipients($recipients);
        $this->setSubject($subject);
        $this->setBody($body);
        $this->setSentAt();
    }

    public function sender() : Actor
    {
        return $this->value('sender');
    }

    public function setSender(Actor $sender) : void
    {
        $this->setValue('sender', $sender);
    }

    public function recipients() : iterable
    {
        return $this->serialize('recipients');
    }

    public function setRecipients(iterable $recipients) : void
    {
        $dispatches = [];
        foreach ($recipients as $recipient) {
            $dispatch['status'] = 'unread';
            if ($recipient instanceof Actor) {
                $dispatch['recipient'] = $recipient;
            }
            if ($recipient instanceof Role) {
                $dispatch['role'] = $recipient->id();
            }
            $dispatches[] = $dispatch;
        }
        $this->setValue('recipients', $dispatches);
    }

    public function sentAt() : DateTime
    {
        return $this->value('sent');
    }

    public function setSentAt(DateTime $sentAt = null) : void
    {
        $this->setValue('sent', $sentAt ?? ARK::timestamp());
    }

    public function subject() : ?LocalText
    {
        return $this->value('subject');
    }

    public function setSubject(LocalText $subject) : void
    {
        $this->setValue('subject', $subject);
    }

    public function body() : ?LocalText
    {
        return $this->value('body');
    }

    public function setBody(LocalText $subject) : void
    {
        $this->setValue('body', $subject);
    }

    public function isRecipient(Actor $actor) : bool
    {
        foreach ($this->recipients() as $dispatch) {
            if ($actor->id() === $dispatch['recipient']['id']) {
                return true;
            }
        }
        return false;
    }

    public function markAsRead(Actor $actor) : void
    {
        $recipient = ORM::findOneBy(
            ItemFragment::class,
            [
                'module' => 'message',
                'item' => $this->id(),
                'attribute' => 'recipient',
                'parameter' => 'actor',
                'value' => $actor->id(),
            ]
        );
        $read = ORM::findOneBy(
            DateTimeFragment::class,
            [
                'module' => 'message',
                'item' => $this->id(),
                'attribute' => 'read',
                'object' => $recipient->object()->id(),
            ]
        );
        if ($read !== null) {
            return;
        }
        $now = ARK::timestamp();
        $read = DateTimeFragment::create(
            'message',
            $this->id(),
            $this->attribute('recipients')->dataclass()->attribute('read'),
            Service::workflow()->actor(),
            $now,
            $recipient->object()
        );
        $read->setValue($now);
        ORM::persist($read);
    }

    public function wasReadBy(Actor $actor) : bool
    {
        foreach ($this->recipients() as $dispatch) {
            if ($actor->id() === $dispatch['recipient']['id'] && isset($dispatch['read'])) {
                return true;
            }
        }
        return false;
    }

    public static function findSentBy(Actor $actor) : Collection
    {
        $frags = ORM::findBy(
            ItemFragment::class,
            [
                'module' => 'message',
                'attribute' => 'sender',
                'parameter' => 'actor',
                'value' => $actor->id(),
            ]
        );
        $messages = new ArrayCollection();
        foreach ($frags as $frag) {
            $message = $frag->owner();
            $messages->set((int) $message->id(), $message);
        }
        return $messages;
    }

    public static function findReceivedBy(Actor $actor) : Collection
    {
        $frags = ORM::findBy(
            ItemFragment::class,
            [
                'module' => 'message',
                'attribute' => 'recipient',
                'parameter' => 'actor',
                'value' => $actor->id(),
            ]
        );
        $messages = new ArrayCollection();
        foreach ($frags as $frag) {
            $message = $frag->owner();
            $messages->set((int) $message->id(), $message);
        }
        return $messages;
    }

    public static function findUnreadBy(Actor $actor) : Collection
    {
        $received = self::findReceivedBy($actor);
        $unread = new ArrayCollection();
        foreach ($received as $id => $message) {
            if (!$message->wasReadBy($actor)) {
                $unread->set($id, $message);
            }
        }
        return $unread;
    }

    public static function findReadBy(Actor $actor) : Collection
    {
        $received = self::findReceivedBy($actor);
        $read = new ArrayCollection();
        foreach ($received as $id => $message) {
            if ($message->wasReadBy($actor)) {
                $read->set($id, $message);
            }
        }
        return $read;
    }
}
