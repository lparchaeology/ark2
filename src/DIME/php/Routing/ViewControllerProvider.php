<?php

/**
 * Ark Route Site Controller Provider
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
namespace DIME\Routing;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class ViewControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // HACK for translated routing, replace later with DynamicRouter
        // Module Resources
        $finds = $app->translate('dime.find', 'resource');
        $actors = $app->translate('core.actor', 'resource');
        $files = $app->translate('core.file', 'resource');
        $events = $app->translate('core.event', 'resource');
        $messages = $app->translate('core.message', 'resource');
        $home = $app->translate('dime.home', 'resource');
        $profile = $app->translate('dime.profile', 'resource');
        $claim = $app->translate('dime.claim', 'resource');
        // Static pages
        $detector = $app->translate('dime.detector', 'resource');
        $research = $app->translate('dime.research', 'resource');
        $about = $app->translate('dime.about', 'resource');
        $news = $app->translate('dime.news', 'resource');

        $controllers = $app['controllers_factory'];

        // Internal API routes
        $controllers->post('/api/internal/vocabulary', 'DIME\Controller\API\VocabularyController')->bind('api.internal.vocabulary');
        $controllers->post('/api/internal/message/read', 'DIME\Controller\API\MessageReadController')->bind('api.internal.message.read');
        $controllers->post('/api/geo/find', 'DIME\Controller\API\GeoFindController')->bind('api.geo.find');
        $controllers->get('/api/geo/choropleth', 'DIME\Controller\API\ChoroplethController')->bind('api.geo.choropleth');
        $controllers->get("/img/{image}", 'DIME\Controller\API\ImageController')->bind('img');

        // User Routes
        $paths = $app['ark']['security']['user_paths'][$app['locale']];
        $controllers->match($paths['register'], 'DIME\Controller\View\UserRegisterController')
            ->method('GET|POST')
            ->bind('user.register');
        $controllers->match($paths['reset'], 'DIME\Controller\View\UserResetController')
            ->method('GET|POST')
            ->bind('user.reset');
        $controllers->match($paths['root'], 'DIME\Controller\View\UserConfirmController')
            ->method('GET')
            ->bind('user.confirm');
        $controllers->match($paths['login'], 'DIME\Controller\View\UserLoginController')
            ->method('GET')
            ->bind('user.login');
        $controllers->match($paths['check'], function () {
        })
            ->method('GET|POST')
            ->bind('user.check');
        $controllers->match($paths['logout'], function () {
        })
            ->method('GET')
            ->bind('user.logout');

        // Static Page Routes
        $controllers->match("/$detector", 'DIME\Controller\View\PageViewController')
            ->method('GET|POST')
            ->bind('detector');
        $controllers->match("/$research", 'DIME\Controller\View\PageViewController')
            ->method('GET|POST')
            ->bind('research');
        $controllers->match("/$about", 'DIME\Controller\View\PageViewController')
            ->method('GET|POST')
            ->bind('about');
        $controllers->match("/$news", 'DIME\Controller\View\NewsPageController')
            ->method('GET')
            ->bind('news');

        // Temp Routes?
        $controllers->match("/$files/{fileId}", 'DIME\Controller\View\FileController')
            ->method('GET|POST')
            ->bind('files.view');
        $controllers->match("/$claim/{itemSlug}", 'DIME\Controller\View\TreasureClaimController')
            ->method('GET|POST')
            ->bind('treasure.claim');

        // Find Routes
        $controllers->match("/$finds/add", 'DIME\Controller\View\FindAddController')
            ->method('GET|POST')
            ->bind('finds.add');
        $controllers->match("/$finds/{itemSlug}", 'DIME\Controller\View\FindViewController')
            ->method('GET|POST')
            ->bind('finds.view');
        $controllers->match("/$finds", 'DIME\Controller\View\FindListController')
            ->method('GET|POST')
            ->bind('finds.list');

        // Home routes
        $controllers->get("/$home/$messages", 'DIME\Controller\View\MessagePageController')->bind('home.messages');
        $controllers->get("/$home", 'DIME\Controller\View\HomePageController')->bind('home');
        $controllers->get("/$profile", 'DIME\Controller\View\ProfilePageController')->bind('profile');
        $controllers->get('/', 'DIME\Controller\View\FrontPageController')->bind('front');

        return $controllers;
    }
}
