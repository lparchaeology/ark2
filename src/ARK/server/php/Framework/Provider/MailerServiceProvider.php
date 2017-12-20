<?php

/**
 * ARK Mailer Service Provider.
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

use ARK\Security\SecurityService;
use ARK\Service;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\SwiftmailerServiceProvider;

class MailerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container) : void
    {
        // For SwiftMailer options see https://silex.symfony.com/doc/2.0/providers/swiftmailer.html
        if ($container['ark']['mailer']['enabled']) {
            $container->register(new SwiftmailerServiceProvider());
            $settings = $container['ark']['mailer'] ?? null;
            $options = $settings['options'] ?? [];
            $credentials = SecurityService::credentials('smtp');
            $options['username'] = $credentials['username'] ?? null;
            $options['password'] = $options['username'] ? $credentials['password'] ?? null : null;
            $container['swiftmailer.options'] = $options;
            $container['swiftmailer.use_spool'] = $settings['use_spool'] ?? false;
            $container['swiftmailer.sender_address'] = $settings['sender']['address'] ?? null;
            $container['swiftmailer.delivery_addresses'] = $settings['delivery']['addresses'] ?? null;
            $container['swiftmailer.delivery_whitelist'] = $settings['delivery']['whitelist'] ?? null;
        }
    }
}
