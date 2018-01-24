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

namespace DIME\Framework\Controller\View;

use ARK\Framework\PageController;
use ARK\Routing\Route;
use ARK\Service;
use DIME\DIME;
use Symfony\Component\HttpFoundation\Request;

abstract class DimePageController extends PageController
{
    public function buildState(Request $request, $data) : iterable
    {
        $state = parent::buildState($request, $data);

        $state['notifications'] = DIME::getNotifications(Service::workflow()->actor(), 'unread');
        $state['image'] = 'image';

        // FIXME Routes to pass into JS, temp hardcode for now, do properly later!
        $state['modules']['find']['view'] = Service::url('dime.finds.list');
        $state['modules']['find']['route'] = 'dime.finds.view';
        $state['modules']['find']['resource'] = Service::translate('dime.find', 'resource');
        $state['modules']['event']['view'] = null;
        $state['modules']['event']['route'] = null;
        $state['modules']['event']['resource'] = Service::translate('core.event', 'resource');
        $state['modules']['message']['view'] = null;
        $state['modules']['message']['route'] = null;
        $state['modules']['message']['resource'] = Service::translate('core.message', 'resource');
        $state['modules']['actor']['view'] = Service::url('dime.profiles.list');
        $state['modules']['actor']['route'] = 'dime.profiles.view';
        $state['modules']['actor']['resource'] = Service::translate('core.actor', 'resource');
        $state['modules']['file']['view'] = null;
        $state['modules']['file']['route'] = null;
        $state['modules']['file']['resource'] = Service::translate('core.file', 'resource');

        return $state;
    }

    protected function buildContext(Request $request, iterable $view) : iterable
    {
        $view = parent::buildContext($request, $view);
        // FIXME temp hardcode for now, later replace with Nav table
        $view['menus'] = $this->menuConfig($request->attributes->get('_route'));

        return $view;
    }

    protected function menuConfig(string $route = null) : iterable
    {
        // TODO Use visibility / permissions
        $homeTarget = (Service::security()->user()->hasPermission('dime.find.home') ? 'dime.home' : 'dime.front');
        $config = [
            'navlinks' => [
                ['name' => 'dime.home', 'dropdown' => false, 'target' => $homeTarget],
                ['name' => 'dime.detector', 'dropdown' => false, 'target' => 'dime.detector'],
                ['name' => 'dime.research', 'dropdown' => false, 'target' => 'dime.research'],
                ['name' => 'dime.about', 'dropdown' => false, 'target' => 'dime.about'],
                ['name' => 'dime.news', 'dropdown' => false, 'target' => 'dime.news'],
            ],
            'sidelinks' => [
                [
                    'name' => 'add',
                    'active' => false,
                    'permission' => 'dime.find.create',
                    'links' => [
                        ['name' => 'dime.find.add', 'active' => false, 'target' => 'dime.finds.add'],
                    ],
                ],
                [
                    'name' => 'mine',
                    'active' => false,
                    'permission' => 'dime.find.home',
                    'links' => [
                        ['name' => 'dime.search.finds.mine', 'active' => false, 'target' => 'dime.home.finds'],
                    ],
                ],
                [
                    'name' => 'search',
                    'active' => false,
                    'permission' => null,
                    'links' => [
                        ['name' => 'dime.find.search', 'active' => false, 'target' => 'dime.finds.list'],
                    ],
                ],
                [
                    'name' => 'admin.users',
                    'active' => false,
                    'permission' => 'core.admin.user',
                    'links' => [
                        ['name' => 'dime.admin.users', 'active' => false, 'target' => 'core.admin.users'],
                    ],
                ],
                [
                    'name' => 'admin.users.register',
                    'active' => false,
                    'permission' => 'core.admin.user',
                    'links' => [
                        ['name' => 'dime.admin.users.register', 'active' => false, 'target' => 'core.admin.users.register'],
                    ],
                ],
                [
                    'name' => 'admin.museums',
                    'active' => false,
                    'permission' => 'core.admin.user',
                    'links' => [
                        ['name' => 'dime.admin.museums', 'active' => false, 'target' => 'dime.admin.museums'],
                    ],
                ],
            ],
        ];
        if ($route) {
            foreach ($config['sidelinks'] as &$section) {
                foreach ($section['links'] as &$link) {
                    if ($link['target'] === $route) {
                        $section['active'] = true;
                        $link['active'] = true;
                    }
                }
            }
        }
        return $config;
    }
}