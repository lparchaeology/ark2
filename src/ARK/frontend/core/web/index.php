<?php

/**
 * ARK Index Page
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

require_once __DIR__.'/../../../vendor/autoload.php';

use ARK\Application;
use ARK\Route\ApiControllerProvider;
use ARK\Route\ViewControllerProvider;
use rootLogin\UserProvider\Provider\UserProviderControllerProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Application('../config/site.json');

// TODO Proper Route mounting
if ($app['ark']['api']['enable']) {
    $app->mount($app['path.api'], new ApiControllerProvider());
}

if ($app['ark']['web']['enable']) {
    $app->mount('/users', new UserProviderControllerProvider());
    $app->mount('/', new ViewControllerProvider());
    // TODO Proper error handling
    $app->error(function (Exception $e, Request $request, $code) use ($app) {
        if ($app['debug']) {
            return;
        }
        // 404.html, or 40x.html, or 4xx.html, or error.html
        $templates = array(
            'errors/'.$code.'.html.twig',
            'errors/'.substr($code, 0, 2).'x.html.twig',
            'errors/'.substr($code, 0, 1).'xx.html.twig',
            'errors/default.html.twig',
        );
        return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
    });
}

$app->run();
