<?php

/**
 * DIME Action
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

namespace DIME\Action;

use ARK\Entity\Message;
use ARK\ORM\ORM;
use ARK\Service;
use DIME\Action\DimeAction;
use Symfony\Component\HttpFoundation\Request;

class MessagePageAction extends DimeFormAction
{
    public function __invoke(Request $request)
    {
        $layout = 'dime_message_page';
        $data['core_message_list'] = ORM::findAll(Message::class);
        if (!$data['core_message_list']->isEmpty()) {
            dump('fill item');
            $data['core_message_item'] = $data['core_message_list'][0];
            dump($data['core_message_item']);
        }
        return $this->renderResponse($request, $data, $layout);
    }
}
