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

namespace DIME\Framework\Controller\API;

use ARK\Actor\Actor;
use ARK\Http\JsonResponse;
use ARK\Message\Message;
use ARK\ORM\ORM;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MessageReadController
{
    public function __invoke(Request $request) : Response
    {
        try {
            $content = json_decode($request->getContent(), true);
            $message = $content['message'];
            $message = ORM::find(Message::class, $message);
            $recipient = $content['recipient'];
            $recipient = ORM::find(Actor::class, $recipient);
            $data['result'] = false;
            if ($message) {
                $data['message'] = $message->id();
            }
            if ($recipient) {
                $data['recipient'] = $recipient->id();
            }
            if ($message && $recipient) {
                $data['is_recipient'] = $message->isRecipient($recipient);
            }
            if ($message && $recipient && $message->isRecipient($recipient)) {
                $message->markAsRead($recipient);
                $data['result'] = true;
                ORM::persist($message);
                ORM::flush($message);
            } else {
                $data['error']['code'] = '9999';
                $data['error']['message'] = 'Message or Recipient Not Found';
            }
        } catch (Exception $e) {
            $data['error']['code'] = $e->getCode();
            $data['error']['message'] = $e->getMessage();
        }
        return new JsonResponse($data);
    }
}
