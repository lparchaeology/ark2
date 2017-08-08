<?php

/**
 * DIME Globals.
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

namespace DIME;

use ARK\Actor\Actor;
use ARK\Message\Notification;
use ARK\ORM\ORM;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;

class DIME
{
    public static function version()
    {
        return '0.1.00';
    }

    public static function getMapTicket()
    {
        if ($credentials = Service::security()->credentials('kortforsyningen')) {
            $user = $credentials['kortforsyningen']['user'];
            $password = $credentials['kortforsyningen']['password'];
            $path = "http://services.kortforsyningen.dk/service?request=GetTicket&login=$user&password=$password";
            $ticket = file_get_contents($path);
            if (strlen($ticket) === 32) {
                return $ticket;
            }
        }
        return false;
    }

    public static function getNotifications($actor = null)
    {
        if ($actor === null) {
            $actor = Service::workflow()->actor();
        }
        if ($actor instanceof Actor && $actor->id() !== 'anonymous') {
            $msgIds = Service::database()->getActorMessages($actor->id());
            dump($actor->roles());
            foreach ($actor->roles() as $role) {
                if ($role->isAgent()) {
                    $msgIds = array_merge($msgIds, Service::database()->getActorMessages($role->agentFor()->id()));
                }
            }
            return ORM::findBy(Notification::class, ['item' => $msgIds], ['created' => 'DESC']);
        }
        return new ArrayCollection();
    }

    public static function getUnreadNotifications($actor = null)
    {
        if ($actor === null) {
            $actor = Service::workflow()->actor();
        }
        $messages = self::getNotifications($actor);
        $unread = new ArrayCollection();
        foreach ($messages as $message) {
            if (!$message->wasReadBy($actor)) {
                $unread[] = $message;
            }
        }
        return $unread;
    }
}
