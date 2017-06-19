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
    public function handleRequest(Request $request, $page, $slugs = [], $redirect = null)
    {
        $page = ORM::find(Page::class, $page);
        $data = $this->buildData($request, $slugs);
        $state = $this->buildState($request);
        $state['page_config'] = $this->pageConfig($request->attributes->get('_route'));
        return $page->handleRequest($request, $data, $state, [$this, 'processForm'], $redirect);
    }

    public function handleJsonRequest(Request $request, $page, $slugs = [])
    {
        $page = ORM::find(Page::class, $page);
        $data = $this->buildData($request, $slugs);
        $state = $this->buildState($request);
        return $page->handleJsonRequest($request, $data, $state, [$this, 'processForm']);
    }

    public function buildData(Request $request, $slugs = [])
    {
        return null;
    }

    public function buildState(Request $request)
    {
        $state['image'] = 'image';
        $state['notifications'] = DIME::getUnreadNotifications();
        // FIXME temp hardcode for now, do properly later!
        $state['modules']['find']['api'] = Service::url('api.finds.collection');
        $state['modules']['find']['view'] = Service::url('finds.list');
        $state['modules']['find']['route'] = 'finds.view';
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
        $state['modules']['actor']['view'] = Service::url('profiles.list');
        $state['modules']['actor']['route'] = 'profiles.view';
        $state['modules']['actor']['resource'] = Service::translate('core.actor', 'resource');
        $state['modules']['file']['api'] = Service::url('api.files.collection');
        $state['modules']['file']['view'] = null;
        $state['modules']['file']['route'] = null;
        $state['modules']['file']['resource'] = Service::translate('core.file', 'resource');
        return $state;
    }

    public function processForm(Request $request, $form, $redirect)
    {
        return Service::redirectPath($redirect);
    }
}
