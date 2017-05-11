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
        $page = ORM::find(Page::class, $page);

        $data = $this->buildData($request, $page);

        $mode = 'view';
        $actor = Service::workflow()->actor();
        if ($actor && $actor->id() != 'anonymous') {
            $data['notifications'] = DIME::getUnreadNotifications();
            if ($page->defaultMode() == 'edit') {
                $item = $data[$page->content()->name()];
                if (Service::workflow()->can($actor, 'edit', $item)) {
                    dump('initial');
                    dump($actor);
                    dump($actor->roles());
                    $role = $actor->roles()[0];
                    $process = $item->property('process')->value();
                    dump($item);
                    dump($item->property('process'));
                    dump($process);
                    dump($role->id());
                    dump($process->name());
                    // HACK Do using workflow!
                    if ($role->id() != 'detectorist' || $process->name() == 'recorded') {
                        $mode = 'edit';
                    }
                    dump($mode);
                }
            }
        }

        $options = $page->defaultOptions();
        $forms = $page->buildForms($mode, $data, $options);
        dump('BUILT');
        dump($forms);
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
                    if (!$redirect) {
                        $redirect = $request->attributes->get('_route');
                    }
                    return $this->processForm($request, $form, $redirect);
                }
            }
        }

        $options['page_config'] = $this->pageConfig($request->attributes->get('_route'));
        return $page->renderResponse($mode, $data, $options, $forms);
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
