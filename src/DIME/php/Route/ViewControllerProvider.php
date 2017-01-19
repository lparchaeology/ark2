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
 * @copyright  2016 L - P : Heritage LLP.
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
        $controllers = $app['controllers_factory'];

        // Under Construction Routes
        $controllers->get('/detector', 'DIME\\Action\\UnderConstructionAction')
                    ->bind('detector');
        $controllers->get('/research', 'DIME\\Action\\UnderConstructionAction')
                    ->bind('research');
        $controllers->get('/about', 'DIME\\Action\\UnderConstructionAction')
                    ->bind('about');
        $controllers->get('/exhibits', 'DIME\\Action\\UnderConstructionAction')
                    ->bind('exhibits');
        $controllers->get('/news', 'DIME\\Action\\UnderConstructionAction')
                    ->bind('news');

        // Dummy Routes
        $controllers->get('/actors/{actorSlug}/finds', 'DIME\\Action\\FindListAction')
                    ->bind('actors.finds.list');

        $controllers->get('/actors/{actorSlug}/locations', 'DIME\\Action\\LocationListAction')
                    ->bind('actors.locations.list');

        $controllers->get('/actors/{actorSlug}', 'DIME\\Action\\ActorViewAction')
                    ->bind('actors.view');

        $controllers->get('/actors', 'DIME\\Action\\ActorListAction')
                    ->bind('actors.list');

        // Find Routes
        $controllers->get('/finds/add', 'DIME\\Action\\FindAddAction')
                    ->bind('finds.add');

        $controllers->post('/finds/add', 'DIME\\Action\\FindAddAction');

        $controllers->get('/finds/{findSlug}', 'DIME\\Action\\FindViewAction')
                    ->bind('finds.view');

        $controllers->post('/finds/{findSlug}', 'DIME\\Action\\FindViewAction');

        $controllers->get('/finds', 'DIME\\Action\\FindListAction')
                    ->bind('finds.list');

        $controllers->get('/locations/add', 'DIME\\Action\\LocationAddAction')
                    ->bind('locations.add');

        $controllers->get('/locations/{locationSlug}', 'DIME\\Action\\LocationViewAction')
                    ->bind('locations.view');

        $controllers->get('/locations', 'DIME\\Action\\LocationListAction')
                    ->bind('locations.list');

        $controllers->get('/test', 'DIME\\Action\\TestViewAction')
                    ->bind('test');

        $controllers->get('/', 'DIME\\Action\\HomeViewAction')
                    ->bind('home');

        return $controllers;
    }
}
