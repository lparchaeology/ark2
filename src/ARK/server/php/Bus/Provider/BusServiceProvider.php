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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Bus\Provider;

use ARK\Bus\Bus;
use Exception;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\CallableResolver\CallableCollection;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Logging\LoggingMiddleware;
use SimpleBus\Message\Name\ClassBasedNameResolver;
use SimpleBus\Message\Recorder\HandlesRecordedMessagesMiddleware;
use SimpleBus\Message\Recorder\PublicMessageRecorder;
use SimpleBus\Message\Subscriber\NotifiesMessageSubscribersMiddleware;
use SimpleBus\Message\Subscriber\Resolver\NameBasedMessageSubscriberResolver;

class BusServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        // ARK View Service
        $container['bus'] = function ($app) {
            return new Bus($app);
        };

        $app['bus.command.handlers'] = [];

        $app['bus.event.subscribers'] = [];

        // Command Bus
        $app['bus.command'] = function () use ($app) {
            return new MessageBusSupportingMiddleware($app['bus.command.middleware']);
        };

        $app['bus.command.middleware'] = function () use ($app) {
            return [
                new HandlesRecordedMessagesMiddleware($app['bus.event.recorder'], $app['bus.event']),
                new FinishesHandlingMessageBeforeHandlingNext(),
                new LoggingMiddleware($app['logger'], $app['logger.level']),
                new DelegatesToMessageHandlerMiddleware($app['bus.command.resolver']),
            ];
        };

        $app['bus.command.resolver'] = function () use ($app) {
            return new NameBasedMessageHandlerResolver(
                $app['bus.resolver.name'],
                $app['bus.command.callables']
            );
        };

        $app['bus.command.callables'] = function () use ($app) {
            return new CallableMap(
                $app['bus.command.handlers'],
                $app['bus.resolver.callable']
            );
        };

        // Event Bus
        $app['bus.event'] = function () use ($app) {
            return new MessageBusSupportingMiddleware($app['bus.event.middleware']);
        };

        $app['bus.event.middleware'] = function () use ($app) {
            return [
                new FinishesHandlingMessageBeforeHandlingNext(),
                new LoggingMiddleware($app['logger'], $app['logger.level']),
                new NotifiesMessageSubscribersMiddleware($app['bus.event.resolver']),
            ];
        };

        $app['bus.event.resolver'] = function () use ($app) {
            return new NameBasedMessageSubscriberResolver(
                $app['bus.resolver.name'],
                $app['bus.event.callables']
            );
        };

        $app['bus.event.callables'] = function () use ($app) {
            return new CallableCollection(
                $app['bus.event.subscribers'],
                $app['bus.resolver.callable']
            );
        };

        $app['bus.event.recorder'] = function () use ($app) {
            return new PublicMessageRecorder;
        };

        // Shared Resolvers
        $app['bus.resolver.name'] = function () {
            return new ClassBasedNameResolver();
        };

        $app['bus.resolver.callable'] = function () use ($app) {
            return new ServiceLocatorAwareCallableResolver(function ($serviceId) use ($app) {
                if ($app->offsetExists($serviceId)) {
                    return $app[$serviceId];
                }
                if (class_exists($serviceId)) {
                    return new $serviceId;
                }
                throw new Exception("Service $serviceId to handle message could not be located.");
            });
        };
    }
}
