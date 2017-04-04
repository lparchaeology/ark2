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

namespace DIME\Route;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class ViewControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // HACK
        $finds = 'fund';
        $localities = 'lokalitet';
        $actors = 'aktører';
        $files = 'filer';
        $research = 'forskning';
        $about = 'om';
        $background = 'baggrund';
        $treasure = 'danefae';
        $detector = 'detektor';
        $exhibits = 'udstiller';
        $news = 'nyheder';

        $controllers = $app['controllers_factory'];

        // Static Page Routes
        $controllers->match("/$research", 'DIME\Controller\PageViewController')
                    ->method('GET|POST')
                    ->bind('research');
        $controllers->match("/$about", 'DIME\Controller\PageViewController')
                    ->method('GET|POST')
                    ->bind('about');
        $controllers->match("/$background", 'DIME\Controller\PageViewController')
                    ->method('GET|POST')
                    ->bind('background');
        $controllers->match("/$treasure", 'DIME\Controller\PageViewController')
                    ->method('GET|POST')
                    ->bind('treasure');
        $controllers->match("/$detector", 'DIME\Controller\PageViewController')
                    ->method('GET|POST')
                    ->bind('detector');
        $controllers->match("/$exhibits", 'DIME\Controller\PageViewController')
                    ->method('GET|POST')
                    ->bind('exhibits');
        $controllers->match("/$news", 'DIME\Controller\PageViewController')
                    ->method('GET|POST')
                    ->bind('news');

        // Temp Routes?
        $controllers->post("/$files/{itemSlug}", 'DIME\Controller\FileViewController');
        $controllers->get("/$files/{itemSlug}", 'DIME\Controller\FileViewController')
                    ->bind('files.view');
        $controllers->get("/$files", 'DIME\Controller\FileListController')
                    ->bind('files.list');

        $controllers->get("/$actors/{itemSlug}/finds", 'DIME\Controller\FindListController')
                    ->bind('actors.finds.list');
        $controllers->get("/$actors/{itemSlug}/localities", 'DIME\Controller\LocalityListController')
                    ->bind('actors.localities.list');
        $controllers->get("/$actors/{itemSlug}", 'DIME\Controller\ActorViewController')
                    ->bind('actors.view');
        $controllers->get("/$actors", 'DIME\Controller\ActorListController')
                    ->bind('actors.list');

        // Find Routes
        $controllers->get("/$finds/add", 'DIME\Controller\FindAddController')
                    ->bind('finds.add');

        $controllers->post("/$finds/add", 'DIME\Controller\FindAddController');

        $controllers->post("/$finds/{itemSlug}", 'DIME\Controller\FindViewController');
        $controllers->get("/$finds/{itemSlug}", 'DIME\Controller\FindViewController')
                    ->bind('finds.view');

        $controllers->post("/$finds", 'DIME\Controller\FindListController');
        $controllers->get("/$finds", 'DIME\Controller\FindListController')
                    ->bind('finds.list');

        $controllers->post("/$localities/add", 'DIME\Controller\LocalityAddController');
        $controllers->get("/$localities/add", 'DIME\Controller\LocalityAddController')
                    ->bind('localities.add');

        $controllers->post("/$localities/{itemSlug}", 'DIME\Controller\LocalityViewController');
        $controllers->get("/$localities/{itemSlug}", 'DIME\Controller\LocalityViewController')
                    ->bind('localities.view');

        $controllers->get("/$localities", 'DIME\Controller\LocalityListController')
                    ->bind('localities.list');

        $controllers->get('/demo', 'DIME\Controller\DemoController')
                    ->bind('demo');

        $controllers->get('/test', 'DIME\Controller\TestViewController')
                    ->bind('test');

        $controllers->post('/api/geo/find', 'DIME\Controller\GeoFindController')
                    ->bind('api.geo.find');

        $controllers->get('/api/geo/choropleth', 'DIME\Controller\ChoroplethController')
                    ->bind('api.geo.choropleth');

        $controllers->get("/img/{image}", 'DIME\Controller\ImageController')
                    ->bind('img');

        $controllers->get('/home/messages', 'DIME\Controller\MessagePageController')
                    ->bind('home.messages');

        $controllers->get('/home/events', 'DIME\Controller\EventsListController')
                    ->bind('home.events');

        $controllers->get('/home', 'DIME\Controller\HomePageController')
                    ->bind('home');

        $controllers->get('/', 'DIME\Controller\FrontPageController')
                    ->bind('front');

        return $controllers;
    }
}
