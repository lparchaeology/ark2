<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/framework/container.php
*
* PHP version 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Heritage LLP.
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
* @category   base
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/framework/container.php
* @since      2.0
*
*/

namespace ArkFramework;

use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;

// Build a new Container to inject our global objects when required
$sc = new DependencyInjection\ContainerBuilder();

// Register a RequestContext to extract the required route parameters from a Request
$sc->register('context', 'Symfony\Component\Routing\RequestContext');

// Register a UrlMatcher to match the RequestContext to a Route and extract the route variables
$sc->register('matcher', 'Symfony\Component\Routing\Matcher\UrlMatcher')
    ->setArguments(array($routes, new Reference('context')));

// Register a ControllerResolver to route the matched Request to the required Controller
$sc->register('resolver', 'Symfony\Component\HttpKernel\Controller\ControllerResolver');

// Register an EventListener to send incoming Requests to the UrlMatcher
$sc->register('listener.router', 'Symfony\Component\HttpKernel\EventListener\RouterListener')
    ->setArguments(array(new Reference('matcher')));

// Register an EventListener to always call Response::prepare() on calling Response::send()
$sc->register('listener.response', 'Symfony\Component\HttpKernel\EventListener\ResponseListener')
    ->setArguments(array('UTF-8'));

// Register an EventListener to allow a Contoller to stream the Response
$sc->register('listener.stream', 'Symfony\Component\HttpKernel\EventListener\StreamedResponseListener');

// Register an EventListener to catch exceptions and pass them to the ErrorController
$sc->register('listener.exception', 'Symfony\Component\HttpKernel\EventListener\ExceptionListener')
    ->setArguments(array('ArkFramework\\ErrorController::exceptionAction'));

// Register an EventDispatcher to dispatch events to the required EventListeners
$sc->register('dispatcher', 'Symfony\Component\EventDispatcher\EventDispatcher')
    ->addMethodCall('addSubscriber', array(new Reference('listener.router')))
    ->addMethodCall('addSubscriber', array(new Reference('listener.response')))
    ->addMethodCall('addSubscriber', array(new Reference('listener.stream')))
    ->addMethodCall('addSubscriber', array(new Reference('listener.exception')));

// Register the kernel used to link the EventDispatcher to the ContollerResolver
$sc->register('kernel', 'Symfony\Component\HttpKernel\HttpKernel')
    ->setArguments(array(new Reference('dispatcher'), new Reference('resolver')));

return $sc;

?>
