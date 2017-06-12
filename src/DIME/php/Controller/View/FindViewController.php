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

use ARK\Error\ErrorException;
use ARK\Http\Error\NotFoundError;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use DIME\DIME;
use DIME\Controller\View\DimeFormController;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class FindViewController extends DimeFormController
{
    public function __invoke(Request $request, $itemSlug)
    {
        return $this->handleRequest($request, 'dime_page_find', ['find' => $itemSlug]);
    }

    public function buildData(Request $request, $slugs = [])
    {
        if (!$find = ORM::find(Find::class, $slugs['find'])) {
            throw new ErrorException(new NotFoundError('ITEM_NOT_FOUND', 'Find not found', "Find ".$slugs['find']." not found"));
        }
        $data['find'] = $find;
        $data['actions'] = Service::workflow()->actions(Service::workflow()->actor(), $find);
        return $data;
    }

    public function processForm(Request $request, $form, $redirect)
    {
        $data = $form->getData();
        $find = $data['find'];
        // FIXME!!!
        $find->property('image')->setValue(null);
        ORM::persist($find);
        if (isset($data['actions'])) {
            $action = $data['actions'];
            $actor = Service::workflow()->actor();
            //$action->apply($actor, $item);
        }
        ORM::flush($find);
        Service::view()->addSuccessFlash('dime.find.update.success');
        return Service::redirectPath($redirect, [
            'itemSlug' => $find->id()
        ]);
    }
}
