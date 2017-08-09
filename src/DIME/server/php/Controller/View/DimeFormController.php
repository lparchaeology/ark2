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

use ARK\Actor\Actor;
use ARK\ORM\ORM;
use ARK\Routing\Route;
use ARK\Service;
use ARK\View\Page;
use DIME\DIME;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

abstract class DimeFormController extends DimeController
{
    public function __invoke(Request $request)
    {
        return $this->handleRequest($request);
    }

    public function handleRequest(Request $request)
    {
        $route = ORM::find(Route::class, $request->attributes->get('_route'));
        if ($route) {
            $page = $route->page();
            if ($route->redirect()) {
                $request->attributes->set('redirect', $route->redirect()->id());
            }
        } else {
            $page = ORM::find(Page::class, $request->attributes->get('page'));
        }
        $data = $this->buildData($request);
        $state = $this->buildState($request);
        $state['workflow'] = $this->buildWorkflow($request, $data, $state);
        $state['page_config'] = $this->pageConfig($request->attributes->get('_route'));
        return $page->handleRequest($request, $data, $state, [$this, 'processForm']);
    }

    public function buildData(Request $request)
    {
        return null;
    }

    public function buildState(Request $request) : iterable
    {
        $state['actor'] = Service::workflow()->actor();
        $state['image'] = 'image';
        $state['notifications'] = DIME::getUnreadNotifications();
        // FIXME temp hardcode for now, do properly later!
        $state['modules']['find']['api'] = Service::url('api.finds.collection');
        $state['modules']['find']['view'] = Service::url('dime.finds.list');
        $state['modules']['find']['route'] = 'dime.finds.view';
        $state['modules']['find']['resource'] = Service::translate('dime.find', 'resource');
        $state['modules']['event']['api'] = Service::url('api.events.collection');
        $state['modules']['event']['view'] = null;
        $state['modules']['event']['route'] = null;
        $state['modules']['event']['resource'] = Service::translate('core.event', 'resource');
        $state['modules']['message']['api'] = Service::url('api.messages.collection');
        $state['modules']['message']['view'] = null;
        $state['modules']['message']['route'] = null;
        $state['modules']['message']['resource'] = Service::translate('core.message', 'resource');
        $state['modules']['actor']['api'] = Service::url('api.actors.collection');
        $state['modules']['actor']['view'] = Service::url('dime.profiles.list');
        $state['modules']['actor']['route'] = 'dime.profiles.view';
        $state['modules']['actor']['resource'] = Service::translate('core.actor', 'resource');
        $state['modules']['file']['api'] = Service::url('api.files.collection');
        $state['modules']['file']['view'] = null;
        $state['modules']['file']['route'] = null;
        $state['modules']['file']['resource'] = Service::translate('core.file', 'resource');
        return $state;
    }

    public function buildWorkflow(Request $request, $data, iterable $state) : iterable
    {
        $actor = $state['actor'];
        $workflow['mode'] = Service::workflow()->mode($actor, $data);
        $workflow['actor'] = $actor;
        if ($workflow['mode'] === 'edit') {
            $workflow['actions'] = Service::workflow()->updateActions($actor, $data);
            $workflow['actors'] = Service::workflow()->actors($actor, $data);
        }
        return $workflow;
    }

    public function processForm(Request $request, Form $form) : void
    {
    }
}
