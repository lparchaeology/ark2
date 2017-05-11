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

use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use ARK\Workflow\Registry;
use ARK\Actor\Actor;
use DIME\DIME;
use DIME\Controller\DimeController;
use Symfony\Component\HttpFoundation\Request;

abstract class DimeFormController extends DimeController
{
    public function renderResponse(Request $request, $page, $redirect = null, $options = [])
    {
        $route = $request->attributes->get('_route');
        $page = ORM::find(Page::class, $page);
        $options = $page->defaultOptions();
        $options['page_config'] = $this->pageConfig($route);
        $options['page_mode'] = 'view';
        $data = $this->buildData($request, $page);

        $actor = Service::workflow()->actor();
        if ($actor && $actor->id() != 'anonymous') {
            $data['notifications'] = DIME::getUnreadNotifications();
            if ($page->mode() == 'edit') {
                $item = $data[$page->content()->name()];
                if (Service::workflow()->can($actor, 'edit', $item)) {
                    $role = $actor->roles()[0];
                    // HACK Do using workflow!
                    if ($role->id() != 'detectorist' || $item->property('process')->value()->name() == 'recorded') {
                        $options['page_mode'] = 'edit';
                    }
                }
            }
        }

        $forms = $page->content()->buildForms($data, $options);
        if ($request->getMethod() == 'POST') {
            $form = null;
            foreach ($forms as $name => $fm) {
                if ($request->request->has($name)) {
                    $form = $fm;
                    continue;
                }
            }
            if ($form) {
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    if (! $redirect) {
                        $redirect = $route;
                    }
                    return $this->processForm($request, $form, $redirect);
                }
            }
        }
        $options['forms'] = null;
        if ($forms) {
            foreach ($forms as $name => $form) {
                $options['forms'][$name] = $form->createView();
            }
        }
        $options['page'] = $page;
        $options['layout'] = $page->content();
        $options['data'] = $data;
        return Service::renderResponse($page->template(), $options);
    }

    public function buildData(Request $request, Page $page)
    {
        $data[$page->content()->name()] = null;
        return $data;
    }

    public function processForm(Request $request, $form, $redirect)
    {
        return Service::redirectPath($redirect);
    }
}
