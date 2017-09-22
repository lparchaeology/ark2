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
 */

namespace DIME;

use ARK\Actor\Actor;
use ARK\Message\Notification;
use ARK\ORM\ORM;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;

class DIME
{
    public static function version() : string
    {
        return '0.1.00';
    }

    public static function generateDetectoristId() : string
    {
        $seq = Service::database()->sequence()->generateSequence('DIME', '', 'detectorist_id');
        return 'DB'.str_pad($seq, 6, '0', STR_PAD_LEFT);
    }

    public static function getMapTicket() : ?string
    {
        if ($credentials = Service::security()->credentials('kortforsyningen')) {
            $user = $credentials['user'];
            $password = $credentials['password'];
            $path = "http://services.kortforsyningen.dk/service?request=GetTicket&login=$user&password=$password";
            $ticket = file_get_contents($path);
            if (strlen($ticket) === 32) {
                return $ticket;
            }
        }
        return null;
    }

    public static function getNotifications(Actor $actor = null) : ArrayCollection
    {
        if ($actor === null) {
            $actor = Service::workflow()->actor();
        }
        if ($actor->id() === 'anonymous') {
            return new ArrayCollection();
        }
        $msgIds = Service::database()->getActorMessages($actor->id());
        foreach ($actor->roles() as $role) {
            $msgIds = array_merge($msgIds, Service::database()->getRoleMessages($role->role()->id()));
            if ($role->isAgent()) {
                $msgIds = array_merge($msgIds, Service::database()->getActorMessages($role->agentFor()->id()));
            }
        }
        return ORM::findBy(Notification::class, ['id' => $msgIds], ['created' => 'DESC']);
    }

    public static function getUnreadNotifications(Actor $actor = null) : ArrayCollection
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
