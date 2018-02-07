<?php

/**
 * DIME Controller.
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

namespace DIME\Controller\API;

use ARK\Http\JsonResponse;
use ARK\Message\Message;
use ARK\ORM\ORM;
use ARK\Security\Actor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class MessageReadController
{
    public function __invoke(Request $request) : Response
    {
        try {
            $content = json_decode($request->getContent(), true);
            $message = Message::find($content['message']);
            $recipient = Actor::find($content['recipient']);
            $data['result'] = false;
            $data['message'] = $message->id();
            $data['recipient'] = $recipient->id();
            $recipients = [];
            if ($message->isRecipient($recipient)) {
                $recipients[] = $recipient;
            }
            foreach ($recipient->agencies() as $agentFor) {
                if ($message->isRecipient($agentFor)) {
                    $recipients[] = $agentFor;
                }
            }
            $data['is_recipient'] = count($recipients) > 0;
            if ($data['is_recipient']) {
                foreach ($recipients as $recipient) {
                    $message->markAsRead($recipient);
                }
                $data['result'] = true;
                ORM::persist($message);
                ORM::flush($message);
            } else {
                $data['error']['code'] = '9999';
                $data['error']['message'] = 'Actor is not a recipient of or agent for the message';
            }
        } catch (Throwable $e) {
            $data['error']['code'] = $e->getCode();
            $data['error']['message'] = $e->getMessage();
        }
        return new JsonResponse($data);
    }
}
