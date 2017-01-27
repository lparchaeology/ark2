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
use Silex\API\ControllerProviderInterface;

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
        $controllers->get("/$research", 'DIME\Action\PageViewAction')
                    ->bind('research');
        $controllers->get("/$about", 'DIME\Action\PageViewAction')
                    ->bind('about');
        $controllers->get("/$background", 'DIME\Action\PageViewAction')
                    ->bind('background');
        $controllers->get("/$treasure", 'DIME\Action\PageViewAction')
                    ->bind('treasure');

        // Under Construction Routes
        $controllers->get("/$detector", 'DIME\Action\UnderConstructionAction')
                    ->bind('detector');
        $controllers->get("/$exhibits", 'DIME\Action\UnderConstructionAction')
                    ->bind('exhibits');
        $controllers->get("/$news", 'DIME\Action\UnderConstructionAction')
                    ->bind('news');

        // Temp Routes?
        $controllers->post("/$files/{itemSlug}", 'DIME\Action\FileViewAction');
        $controllers->get("/$files/{itemSlug}", 'DIME\Action\FileViewAction')
                    ->bind('files.view');
        $controllers->get("/$files", 'DIME\Action\FileListAction')
                    ->bind('files.list');

        $controllers->get("/$actors/{itemSlug}/finds", 'DIME\Action\FindListAction')
                    ->bind('actors.finds.list');
        $controllers->get("/$actors/{itemSlug}/localities", 'DIME\Action\LocalityListAction')
                    ->bind('actors.localities.list');
        $controllers->get("/$actors/{itemSlug}", 'DIME\Action\ActorViewAction')
                    ->bind('actors.view');
        $controllers->get("/$actors", 'DIME\Action\ActorListAction')
                    ->bind('actors.list');

        // Find Routes
        $controllers->get("/$finds/add", 'DIME\Action\FindAddAction')
                    ->bind('finds.add');

        $controllers->post("/$finds/add", 'DIME\Action\FindAddAction');

        $controllers->get("/$finds/{itemSlug}", 'DIME\Action\FindViewAction')
                    ->bind('finds.view');

        $controllers->post("/$finds/{itemSlug}", 'DIME\Action\FindViewAction');

        $controllers->post("/$finds", 'DIME\Action\FindListAction');
        $controllers->get("/$finds", 'DIME\Action\FindListAction')
                    ->bind('finds.list');

        $controllers->post("/$localities/add", 'DIME\Action\LocalityAddAction');
        $controllers->get("/$localities/add", 'DIME\Action\LocalityAddAction')
                    ->bind('localities.add');

        $controllers->post("/$localities/{itemSlug}", 'DIME\Action\LocalityViewAction');
        $controllers->get("/$localities/{itemSlug}", 'DIME\Action\LocalityViewAction')
                    ->bind('localities.view');

        $controllers->get("/$localities", 'DIME\Action\LocalityListAction')
                    ->bind('localities.list');

        $controllers->get('/demo', 'DIME\Action\DemoAction')
                    ->bind('demo');
        $controllers->get('/test', 'DIME\Action\TestViewAction')
                    ->bind('test');

        $controllers->get('/', 'DIME\Action\HomeViewAction')
                    ->bind('home');

        return $controllers;
    }
}
