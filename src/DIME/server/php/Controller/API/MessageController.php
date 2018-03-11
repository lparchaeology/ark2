<?php

/**
 * DIME Controller.
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace DIME\Controller\API;

use ARK\Framework\FormController;
use ARK\Message\Message;
use ARK\Model\Item;
use ARK\ORM\ORM;
use DIME\DIME;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends FormController
{
    public function buildData(Request $request)
    {
        $id = $request->attributes->get('id');
        $data['message'] = ORM::find(Message::class, $id);
        return $data;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $id = $request->attributes->get('id');
        $submitted = $form->getConfig()->getName();
        if ($submitted === 'message') {
            $message = $form->getData();
            ORM::flush($message);
            $request->attributes->set('_status', 'success');
            $request->attributes->set('_message', 'dime.message.updated');
        }
    }

    protected function item($data) : ?Item
    {
        return $data['message'];
    }
}
