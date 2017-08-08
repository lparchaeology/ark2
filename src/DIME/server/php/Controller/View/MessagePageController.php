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
 */

namespace DIME\Controller\View;

use ARK\Message\Message;
use ARK\ORM\ORM;
use ARK\View\Page;
use ARK\Vocabulary\Vocabulary;
use DIME\DIME;
use Symfony\Component\HttpFoundation\Request;

class MessagePageController extends DimeFormController
{
    public function __invoke(Request $request)
    {
        $request->attributes->set('page', 'dime_page_message');
        return $this->handleRequest($request);
    }

    public function buildState(Request $request) : iterable
    {
        $state = parent::buildState($request);
        $state['event_vocabulary'] = ORM::find(Vocabulary::class, 'core.event.type');
        return $state;
    }

    public function buildWorkflow(Request $request, $data, iterable $state) : iterable
    {
        $workflow['mode'] = 'edit';
        $workflow['actor'] = $state['actor'];
        return $workflow;
    }

    public function buildData(Request $request)
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
