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

use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use ARK\Workflow\Registry;
use ARK\Actor\Actor;
use DIME\DIME;
use DIME\Controller\View\DimeController;
use Symfony\Component\HttpFoundation\Request;

abstract class DimeFormController extends DimeController
{

    public function handleRequest(Request $request, $page, $redirect = null, $options = [], $context = [])
    {
        $page = ORM::find(Page::class, $page);
        $data = $this->buildData($request, $page);

        // TODO Make generic somehow?
        $mode = 'view';
        $actor = Service::workflow()->actor();
        if ($actor && $actor->id() != 'anonymous') {
            if ($page->defaultMode() == 'edit') {
                $item = $data[$page->content()->name()];
                // HACK Do properly in permissions!!!
                if ($page->name() == 'dime_page_claim' || Service::workflow()->can($actor, 'edit', $item)) {
                    $role = $actor->roles()[0];
                    $process = $item->property('process')->value();
                    // HACK Do using workflow!
                    if ($role->id() != 'detectorist' || $process->name() == 'recorded') {
                        $mode = 'edit';
                    }
                }
            }
        }

        $context['page_config'] = $this->pageConfig($request->attributes->get('_route'));
        return $page->handleRequest($request, $data, $options, $context, [
            $this,
            'processForm'
        ]);
    }

    public function buildData(Request $request, Page $page)
    {
        $data[$page->content()->name()] = null;
        $data['notifications'] = DIME::getUnreadNotifications();
        return $data;
    }

    public function processForm(Request $request, $form, $redirect)
    {
        $id = 0;
        $data = $form->getData();
        $item = $data[$form->getName()];
        ORM::persist($item);
        if (isset($data['dime_find_actions'])) {
            $action = $data['dime_find_actions'];
            $actor = Service::workflow()->actor();
            $action->apply($actor, $item);
        }
        ORM::flush($item);
        return Service::redirectPath($redirect, [
            'itemSlug' => $item->id()
        ]);
    }
}
