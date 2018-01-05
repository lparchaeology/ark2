<?php

/**
 * ARK Security Controller Provider
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

namespace ARK\Security\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class SecurityControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->match('/user/login', 'UserLoginController')
            ->method('GET')
            ->bind('user.login');

        $controllers->match('/user/register', 'UserResetContoller')
            ->method('GET|POST')
            ->bind('user.register');

        $controllers->match('/user/confirm', 'UserConfirmContoller')
            ->method('GET|POST')
            ->bind('user.confirm');

        $controllers->match('/user/reset', 'UserResetContoller')
            ->method('GET|POST')
            ->bind('user.reset');

        $controllers->match('/user/check', function (){})
            ->method('GET|POST')
            ->bind('user.check');

        $controllers->match('/user/logout', function (){})
            ->method('GET')
            ->bind('core.user.logout');

        $controllers->match('/admin/users/{id}', 'UserViewController')
            ->method('GET|POST')
            ->bind('admin.user.edit');

        $controllers->match('/admin/users', 'UserListController')
            ->method('GET|POST')
            ->bind('admin.user.list');

        return $controllers;
    }
}
