<?php

/**
 * ARK Route Service Provider.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework\Provider;

use ARK\Framework\ControllerProvider;
use ARK\Routing\Console\Command\RouteDumpCommand;
use ARK\Routing\Router;
use ARK\Service;
use Exception;
use Pimple\Container;
use Silex\Provider\RoutingServiceProvider as SilexRoutingServiceProvider;
use Symfony\Cmf\Component\Routing\ChainRouter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RoutingServiceProvider extends SilexRoutingServiceProvider
{
    public function register(Container $container) : void
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
            $chain->add(new Router());
            return $chain;
        };

        $container->addCommand(RouteDumpCommand::class);

        $container->mount('/', new ControllerProvider());
        $container->flush();

        // TODO Proper error handling
        $container->error(function (Exception $e, Request $request, $code) use ($container) {
            if ($container['debug']) {
                return;
            }
            // 404.html, or 40x.html, or 4xx.html, or error.html
            $templates = [
                'errors/'.$code.'.html.twig',
                'errors/'.mb_substr($code, 0, 2).'x.html.twig',
                'errors/'.mb_substr($code, 0, 1).'xx.html.twig',
                'errors/default.html.twig',
            ];
            return new Response($container['twig']->resolveTemplate($templates)->render(['code' => $code]), $code);
        });
    }
}
