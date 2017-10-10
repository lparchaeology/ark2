<?php

/**
 * ARK Security Service Provider.
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

namespace ARK\Framework\Provider;

use ARK\Security\Security;
use ARK\Security\UserProvider;
use ARK\Security\Validator\PasswordStrength;
use ARK\Security\Validator\PasswordStrengthValidator;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\RememberMeServiceProvider;
use Silex\Provider\SecurityServiceProvider as SilexSecurityServiceProvider;

class SecurityServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container) : void
    {
        // Register the default Silex/Symfony security providers
        $container->register(new SilexSecurityServiceProvider());
        $container->register(new RememberMeServiceProvider());
        $container->register(new CsrfServiceProvider());

        // ARK Security Service
        $container['security'] = function ($app) {
            return new Security($app);
        };

        // Site specific settings
        $settings = $container['ark']['security'];

        // TODO Replace with Routes/Paths tables
        // Can't use translation here :-(
        $locale = $container['locale'];
        $admin = $settings['routes']['admin']['paths'][$locale];
        $user = $settings['routes']['user']['paths'][$locale];
        $login = $settings['routes']['login']['paths'][$locale];
        $check = $settings['routes']['check']['paths'][$locale];
        $confirm = $settings['routes']['confirm']['paths'][$locale];
        $verify = $settings['routes']['verify']['paths'][$locale];
        $target = $settings['routes']['target']['paths'][$locale];
        $logout = $settings['routes']['logout']['paths'][$locale];
        $register = $settings['routes']['register']['paths'][$locale];
        $reset = $settings['routes']['reset']['paths'][$locale];

        // Configure Symfony Security Firewalls
        // See https://silex.symfony.com/doc/2.0/providers/security.html
        $container['security.firewalls'] = [
            // unsecured firewall: anyone can login/register/reset
            'unsecured' => [
                'pattern' => "(^$login$)|(^$register$)|(^$reset$)|(^$confirm$)|(^$verify$)",
                'anonymous' => true,
            ],
            // TODO API firewall: all api calls controlled by access_rules and tokens
            // secured firewall: everything else is controlled by access_rules and a login form
            'secured' => [
                'pattern' => '^/.*$',
                'anonymous' => $settings['anonymous'] ?? false,
                'remember_me' => $settings['remember_me'] ?? [],
                'form' => [
                    'login_path' => $login,
                    'check_path' => $check,
                    'default_target_path' => $target,
                ],
                'logout' => [
                    'logout_path' => $logout,
                ],
                'users' => function ($app) {
                    return $app['user.provider'];
                },
            ],
        ];

        // Access Rules to restrict access by user levels
        // Rules are evaluated in defined order, first match wins
        // If https is required then force redirect
        $channel = $settings['https'] ? 'https' : null;
        $container['security.access_rules'] = array_merge(
            // First ensure anyone can access login area
            [
                [
                    "(^$login$)|(^$register$)|(^$reset$)|(^$check$)|(^$confirm$)|(^$verify$)",
                    'IS_AUTHENTICATED_ANONYMOUSLY',
                    $channel,
                ],
            ],
            // Then evaluate the site specific rules if defined
            $settings['access_rules'] ?? [],
            // Then evaluate the default rules
            [
                // Only Admins can access admin area
                [
                    "(^$admin)",
                    'ROLE_ADMIN',
                    $channel,
                ],
                // Only Users can access users area
                [
                    "(^$user)",
                    'ROLE_USER',
                    $channel,
                ],
                [
                    // Anyone can access all other areas
                    '^/.+$',
                    'IS_AUTHENTICATED_ANONYMOUSLY',
                    $channel,
                ],
            ]
        );

        // Configure the UserProvider
        $container['user.defaults'] = [
            'admin_confirm' => false,
            'verify_email' => true,
            'verify_email_required' => true,
            'email' => 'noreply@example.com',
            'sender' => 'ARK User Admin (Do Not Reply)',
            'reset_email_template' => 'user/emails/reset.txt.twig',
            'verify_email_template' => 'user/emails/verify.txt.twig',
            'password_strength' => 2,
            'password_expiry' => 0,
            'user_reset' => true,
            'user_register' => true,
            'default_role' => 'anonymous',
            'reset_ttl' => 86400,
        ];
        $container['user.options'] = array_replace($container['user.defaults'], $settings['user']);
        $container['user.options.init'] = $container->protect(function () use ($container) : void {});
        $container['user.provider'] = function ($app) {
            $app['user.options.init']();
            return new UserProvider();
        };

        // Configure the zxcvbn password strength validator (https://github.com/bjeavons/zxcvbn-php)
        $container['password.validate'] = $container->protect(function ($plainPassword) use ($container) {
            return $container['password.validator']->validate($plainPassword, $container['password.validator.constraint']);
        });
        $container['password.validator'] = function ($app) {
            return new PasswordStrengthValidator();
        };
        $container['password.validator.constraint'] = function ($app) {
            $app['user.options.init']();
            $constraint = new PasswordStrength();
            $constraint->minimumScore = $app['user.options']['password_strength'];
            return $constraint;
        };
    }
}
