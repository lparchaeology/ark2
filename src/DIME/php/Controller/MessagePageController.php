<?php

/**
 * DIME Controller
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

namespace DIME\Controller;

use ARK\Message\Message;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use DIME\Controller\DimeController;
use Symfony\Component\HttpFoundation\Request;

class MessagePageController extends DimeFormController
{
    public function __invoke(Request $request)
    {
        return $this->renderResponse($request, 'dime_page_messages');
    }

    public function buildData(Request $request, Page $page)
    {
        $items = Service::database()->getActorMessages('ahavfrue');
        $messages = ORM::findBy(Message::class, ['item' => $items], ['created' => 'DESC']);
        $data['messages'] = $messages;
        $data['core_message_list'] = $messages;
        $msg = $request->query->get('message');
        $data['core_message_item'] = null;
        if ($msg) {
            $message = ORM::find(Message::class, $msg);
            if ($messages->contains($message)) {
                $data['core_message_item'] = $message;
                $data['message'] = $message;
            }
        }
        return $data;
    }
}
