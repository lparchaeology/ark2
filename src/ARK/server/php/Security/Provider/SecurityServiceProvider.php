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

namespace ARK\Security\Provider;

use ARK\Security\Security;
use ARK\Security\Validator\PasswordStrength;
use ARK\Security\Validator\PasswordStrengthValidator;
use ARK\Security\UserProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
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

        // ARK Security Service
        $container['security'] = function ($app) {
            return new Security($app);
        };

        // HACK translate as needed!
        //$user = $container->translate('core.user', 'resource');
        $user = 'users';

        // Configure Symfony Security Firewalls
        $container['security.firewalls'] = [];
        $container->extendArray('security.firewalls', 'login_area', [
            'pattern' => "(^/$user/login$)|(^/$user/register$)|(^/$user/reset$)",
            'anonymous' => true
        ]);
        $container->extendArray('security.firewalls', 'default', [
            'pattern' => '^/.*$',
            'anonymous' => true,
            'remember_me' => [],
            'form' => [
                'login_path' => "/$user/login",
                'check_path' => "/$user/check"
            ],
            'logout' => [
                'logout_path' => "/$user/logout"
            ],
            'users' => function ($app) {
                return $app['user.provider'];
            }
        ]);
        $container['security.access_rules'] = [
            [
                "(^/$user/login$)|(^/$user/register$)|(^/$user/reset$)|(^/$user/check$)",
                "IS_AUTHENTICATED_ANONYMOUSLY"
            ],
            [
                "(^/$user)",
                "ROLE_USER"
            ],
            [
                "^/.+$",
                "IS_AUTHENTICATED_ANONYMOUSLY"
            ]
        ];
        if (isset($container['ark']['security']['access_rules'])) {
            $container['security.access_rules'] = array_merge(
                $container['security.access_rules'],
                $container['ark']['security']['access_rules']
            );
        }

        $container['user.options'] = [
            'adminConfirm' => true,
            'emailConfirm' => true,
            'emailAddress' => 'noreply@example.com',
            'emailName' => 'ARK User Admin (Do Not Reply)',
            'passwordStrength' => 2,
            'userReset' => true,
            'resetTTL' => 86400,
        ];

        $container['user.options.init'] = $container->protect(function () use ($container) {
            return;
        });

        $container['password.validate'] = $container->protect(function ($plainPassword) use ($container) {
            return $container['password.validator']->validate($plainPassword, $container['password.validator.constraint']);
        });

        $container['password.validator'] = function ($app) {
            return new PasswordStrengthValidator;
        };

        $container['password.validator.constraint'] = function ($app) {
            $app['user.options.init']();
            $constraint = new PasswordStrength();
            $constraint->minimumScore = $app['user.options']['passwordStrength'];
            return $constraint;
        };

        $container['user.provider'] = function ($app) {
            $app['user.options.init']();
            return new UserProvider;
        };
    }
}
