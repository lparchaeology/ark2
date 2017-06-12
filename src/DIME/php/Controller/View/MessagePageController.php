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

namespace DIME\Controller\View;

use ARK\Message\Message;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use DIME\DIME;
use DIME\Controller\View\DimeFormController;
use Symfony\Component\HttpFoundation\Request;
use ARK\Vocabulary\Vocabulary;

class MessagePageController extends DimeFormController
{
    public function __invoke(Request $request)
    {
        return $this->handleRequest($request, 'dime_page_message');
    }

    public function buildState(Request $request)
    {
        $state['notifications'] = DIME::getUnreadNotifications();
        $state['event_vocabulary'] = ORM::find(Vocabulary::class, 'core.event.type');
        return $state;
    }

    public function buildData(Request $request, $slugs = [])
    {
        $data['messages'] = DIME::getNotifications();
        $msg = $request->query->get('id');
        if ($msg) {
            $message = ORM::find(Message::class, $msg);
            if ($messages->contains($message)) {
                $data['message'] = $message;
            }
        }
        return $data;
    }
}
