<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Provider/SimpleBusServiceProvider.php
*
* SimpleBus Service Provider
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Provider/SimpleBusServiceProvider.php
* @since      2.0
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
        }

        $app['bus.command'] = function () use ($app) {
            return new MessageBusSupportingMiddleware($app['bus.command.middleware']);
        };

        $app['bus.event.middleware'] = function () {
            return array(
                new FinishesHandlingMessageBeforeHandlingNext(),
                new LoggingMiddleware($app['logger'], $app['logger.level']),
            );
        }

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
            return array(
                // example
                // Fully\Qualified\Class\Name\Of\Command::class => 'command.handler_service_id'
            );
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
