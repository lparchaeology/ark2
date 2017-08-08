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

use ARK\Service;

abstract class DimeController
{
    public function defaultOptions(string $route = null) : iterable
    {
        $options['mode'] = 'view';
        $options['data'] = null;
        $options['forms'] = null;
        $options['page_config'] = $this->pageConfig($route);
        return $options;
    }

    public function pageConfig(string $route = null) : iterable
    {
        // TODO Use visibility / permissions
        $homeTarget = (Service::security()->isGranted('ROLE_USER') ? 'dime.home' : 'front');
        $config = [
            'navlinks' => [
                ['name' => 'dime.home', 'dropdown' => false, 'target' => $homeTarget],
                ['name' => 'dime.detector', 'dropdown' => false, 'target' => 'detector'],
                ['name' => 'dime.research', 'dropdown' => false, 'target' => 'research'],
                ['name' => 'dime.about', 'dropdown' => false, 'target' => 'about'],
                ['name' => 'dime.news', 'dropdown' => false, 'target' => 'news'],
            ],
            'sidelinks' => [
                [
                    'name' => 'add',
                    'active' => false,
                    'role' => 'ROLE_USER',
                    'links' => [
                        ['name' => 'dime.find.add', 'active' => false, 'target' => 'finds.add'],
                    ],
                ],
                [
                    'name' => 'search',
                    'active' => false,
                    'role' => 'IS_AUTHENTICATED_ANONYMOUSLY',
                    'links' => [
                        ['name' => 'dime.find.search', 'active' => false, 'target' => 'finds.list'],
                    ],
                ],
                [
                    'name' => 'admin.users',
                    'active' => false,
                    'role' => 'ROLE_ADMIN',
                    'links' => [
                        ['name' => 'dime.admin.users', 'active' => false, 'target' => 'admin.users'],
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
