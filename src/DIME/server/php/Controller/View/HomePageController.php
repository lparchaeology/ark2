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

use ARK\ORM\ORM;
use ARK\Service;
use DIME\DIME;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class HomePageController extends DimeFormController
{
    public function buildData(Request $request)
    {
        // Find 9 most recent finds for current actor
        $items = Service::database()->getActorFinds(Service::workflow()->actor()->id());
        $finds = ORM::findBy(Find::class, ['id' => $items], ['created' => 'DESC'], 9);
        $data['finds']['items'] = $finds;

        // TODO Use visibility / permissions
        $data['map']['finds'] = (Service::security()->isGranted('ROLE_USER') ? $finds : []);
        $data['map']['kortforsyningenticket'] = DIME::getMapTicket();

        return $data;
    }

    public function buildWorkflow(Request $request, $data, iterable $state) : iterable
    {
        $workflow['mode'] = 'edit';
        $workflow['actor'] = $state['actor'];
        return $workflow;
    }
}
