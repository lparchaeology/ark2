<?php

/**
 * ARK Translation Service Provider
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

namespace ARK\Security;

use ARK\Security\Security;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use rootLogin\UserProvider\Entity\LegacyUser as User;
use rootLogin\UserProvider\Provider\UserProviderServiceProvider;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\RememberMeServiceProvider;
use Silex\Provider\SecurityServiceProvider as SilexSecurityServiceProvider;

class SecurityServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container->register(new SilexSecurityServiceProvider());
        $container->register(new RememberMeServiceProvider());
        $container->register(new CsrfServiceProvider());

        $container['security'] = function ($app) {
            return new Security();
        };
        $container['security.firewalls'] = [];
        $container->extendArray(
            'security.firewalls',
            'login_area',
            [
                'pattern' => '(^/users/login$)|(^/users/register$)|(^/users/forgot-password$)',
                'anonymous' => true,
            ]
        );
        $container->extendArray(
            'security.firewalls',
            'default',
            [
                'pattern' => '^/.*$',
                'anonymous' => true,
                'remember_me' => [],
                'form' => [
                   'login_path' => '/users/login',
                   'check_path' => '/users/login_check',
                ],
                'logout' => [
                   'logout_path' => '/users/logout',
                ],
                'users' => function ($app) {
                    return $app['user.manager'];
                },
            ]
        );
        $container['security.access_rules'] = $container['ark']['security']['access_rules'];

        $container->register(new UserProviderServiceProvider(true));
        $container['user.options'] = [
            'userConnection' => 'user',
            'userClass' => User::class,
            'userTableName' => 'ark_user',
            'userCustomFieldsTableName' => 'ark_user_field',
            'editCustomFields' => [],
            'templates'=> ['layout' => 'pages/page.html.twig'],
        ];
    }
}
