<?php

/**
 * SimpleBus Service Provider
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Provider;

use Doctrine\DBAL\Connection;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Log\LogLevel;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\Bus\Middleware\LoggingMiddleware;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;
use SimpleBus\Message\Handler\Map\LazyLoadingMessageHandlerMap;
use SimpleBus\Message\Name\ClassBasedNameResolver;

class SimpleBusServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['bus.command.middleware'] = function () {
            return array(
                new FinishesHandlingMessageBeforeHandlingNext(),
                new LoggingMiddleware($app['logger'], $app['logger.level']),
            );
        };

        $app['bus.command'] = function () use ($app) {
            return new MessageBusSupportingMiddleware($app['bus.command.middleware']);
        };

        $app['bus.event.middleware'] = function () {
            return array(
                new FinishesHandlingMessageBeforeHandlingNext(),
                new LoggingMiddleware($app['logger'], $app['logger.level']),
            );
        };

        $app['bus.event'] = function () use ($app) {
            return new MessageBusSupportingMiddleware($app['bus.event.middleware']);
        };

        // TODO
        $app['bus.handler.locator'] = $app->protect(
            function ($serviceId) use ($app) {
                if ($app->offsetExists($serviceId)) {
                    return $app[$serviceId];
                }
                throw new \Exception($serviceId . ' to handle message could not be located.');
            }
        );

        $app['bus.handlers'] = function () {
            return array();
        };

        $app['bus.handler.resolver'] = function () {
            return new ClassBasedNameResolver();
        };

        $app['bus.handler.map'] = function () use ($app) {
            return new LazyLoadingMessageHandlerMap(
                $app['bus.handlers'],
                $app['bus.handler.locator']
            );
        };
    }
}
