<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Provider/JsonApiServiceProvider.php
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
* @see        http://ark.lparchaeology.com/code/src/php/Provider/JsonApiServiceProvider.php
* @since      2.0
*/

namespace ARK\Api;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use WoohooLabs\Yin\JsonApi\Request\Request as JsonApiRequest;
use WoohooLabs\Yin\JsonApi\Exception\DefaultExceptionFactory;

class JsonApiServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['jsonapi.exception_factory'] = function () use ($app) {
            return new DefaultExceptionFactory();
        };

        $app['jsonapi.request'] = $app->protect(
            function (HttpFoundationRequest $request) use ($app) {
                return JsonApiRequest($app['psr7.request']($request), $app['jsonapi.exception_factory']);
            }
        );

        $app['jsonapi.inject'] = $app->protect(
            function (HttpFoundationRequest $request) use ($app) {
                $jsonApiRequest = $app['jsonapi.request']($request);
                $jsonApi = new JsonApi($request, new HttpFoundationResponse(), $app['jsonapi.exception_factory']);
                $request->attributes->set('jsonApiRequest', $jsonApiRequest);
                $request->attributes->set('jsonApi', $jsonApi);
            }
        );
    }
}
