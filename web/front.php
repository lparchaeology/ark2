<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* web/front.php
*
* PHP version 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2015  L - P : Heritage LLP.
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
* @link       http://ark.lparchaeology.com/code/web/front.php
* @since      2.0
*
*/

// Autoload vendor classes using Composer
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

// Load the URL routing
$routes = include __DIR__.'/../framework/routes.php';

// Load the Dependency Injection container
$container = include __DIR__.'/../src/framework/container.php';

// Create the request from the PHP globals
$request = Request::createFromGlobals();

// Route the Request via the Kernel to the required Controller and get the Response
$response = $container->get('kernel')->handle($request);

// Send the Response
$response->send();

?>
