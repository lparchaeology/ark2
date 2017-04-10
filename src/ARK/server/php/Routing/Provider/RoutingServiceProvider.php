<?php

/**
 * ARK Route Service Provider
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

namespace ARK\Routing\Provider;

use ARK\Routing\Router\SilexRouter;
use Exception;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use rootLogin\UserProvider\Provider\UserProviderControllerProvider;
use Silex\Provider\RoutingServiceProvider as SilexRoutingServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Cmf\Component\Routing\ChainRouter;

class RoutingServiceProvider extends SilexRoutingServiceProvider
{
    public function register(Container $container)
    {
        parent::register($container);

        $container['url_matcher'] = function (Container $container) {
            $chain = $container['routers'];
            $chain->setContext($container['request_context']);
            return $chain;
        };

        $container['url_generator'] = function (Container $container) {
            $container->flush();
            return $container['routers'];
        };

        $container['routers'] = function (Container $container) {
            $chain = new ChainRouter($container['logger']);
            $chain->add(new SilexRouter($container));
            return $chain;
        };

        // Mount standard routes
        $container->mount('/users', new UserProviderControllerProvider());
        foreach ($container['ark']['routes'] as $path => $provider) {
            $container->mount($path, new $provider);
        }

        // TODO Proper error handling
        $container->error(function (Exception $e, Request $request, $code) use ($container) {
            if ($container['debug']) {
                return;
            }
            // 404.html, or 40x.html, or 4xx.html, or error.html
            $templates = array(
                'errors/'.$code.'.html.twig',
                'errors/'.substr($code, 0, 2).'x.html.twig',
                'errors/'.substr($code, 0, 1).'xx.html.twig',
                'errors/default.html.twig',
            );
            return new Response($container['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
        });
    }
}
