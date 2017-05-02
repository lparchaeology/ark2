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
        // Static pages
        $home = $app->translate('dime.home', 'resource');
        $detector = $app->translate('dime.detector', 'resource');
        $research = $app->translate('dime.research', 'resource');
        $about = $app->translate('dime.about', 'resource');
        $news = $app->translate('dime.news', 'resource');

        $controllers = $app['controllers_factory'];

        // Temp APi routes
        $controllers->post('/api/geo/find', 'DIME\Controller\GeoFindController')
                    ->bind('api.geo.find');
        $controllers->get('/api/geo/choropleth', 'DIME\Controller\ChoroplethController')
                    ->bind('api.geo.choropleth');
        $controllers->get("/img/{image}", 'DIME\Controller\ImageController')
                    ->bind('img');

        // Static Page Routes
        $controllers->match("/$detector", 'DIME\Controller\PageViewController')
                    ->method('GET|POST')
                    ->bind('detector');
        $controllers->match("/$research", 'DIME\Controller\PageViewController')
                    ->method('GET|POST')
                    ->bind('research');
        $controllers->match("/$about", 'DIME\Controller\PageViewController')
                    ->method('GET|POST')
                    ->bind('about');
        $controllers->match("/$news", 'DIME\Controller\PageViewController')
                    ->method('GET|POST')
                    ->bind('news');

        // Temp Routes?
        $controllers->match("/$files/{itemSlug}", 'DIME\Controller\FileViewController')
                    ->method('GET|POST')
                    ->bind('files.view');
        $controllers->get("/$files", 'DIME\Controller\FileListController')
                    ->bind('files.list');

        // Actor Routes
        $controllers->get("/$actors/{itemSlug}/finds", 'DIME\Controller\FindListController')
                    ->bind('actors.finds.list');
        $controllers->get("/$actors/{itemSlug}", 'DIME\Controller\ActorViewController')
                    ->bind('actors.view');
        $controllers->get("/$actors", 'DIME\Controller\ActorListController')
                    ->bind('actors.list');

        // Find Routes
        $controllers->match("/$finds/add", 'DIME\Controller\FindAddController')
                    ->method('GET|POST')
                    ->bind('finds.add');
        $controllers->match("/$finds/{itemSlug}", 'DIME\Controller\FindViewController')
                    ->method('GET|POST')
                    ->bind('finds.view');
        $controllers->match("/$finds", 'DIME\Controller\FindListController')
                    ->method('GET')
                    ->bind('finds.list');

        // Home routes
        $controllers->get("/$home/$messages", 'DIME\Controller\MessagePageController')
                    ->bind('home.messages');
        $controllers->get("/$home", 'DIME\Controller\HomePageController')
                    ->bind('home');
        $controllers->get('/', 'DIME\Controller\FrontPageController')
                    ->bind('front');

        return $controllers;
    }
}
