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
use ARK\Model\Item;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Vocabulary;
use DIME\DIME;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class MessagePageController extends DimePageController
{
    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);
        $state['event_vocabulary'] = Vocabulary::find('core.event.class');
        dump($state);
        return $state;
    }

    public function buildData(Request $request)
    {
        $actor = Service::workflow()->actor();
        $status = $request->query->get('status');
        $data['messages']['items'] = DIME::getNotifications($actor, $status);
        $msg = $request->query->get('id');
        if ($msg) {
            $message = ORM::find(Message::class, $msg);
            if ($data['messages']['items']->contains($message)) {
                $data['message'] = $message;
            }
        }
        dump($data);
        dump($data['messages']['items'][0]->value('recipients'));
        return $data;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $submitted = $form->getConfig()->getName();
        if ($submitted === 'filter') {
            $status = $form['status']->getData();
            $query = [];
            if ($status) {
                $query['status'] = $status->name();
            }
            $request->attributes->set('parameters', $query);
            return;
        }
    }

    protected function item($data) : ?Item
    {
        return null;
        return $data['message'] ?? $data['messages']['items']->first() ?? null;
    }
}
