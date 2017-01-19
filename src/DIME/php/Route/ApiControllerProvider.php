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

class ApiControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/actors/{actorSlug}/finds', 'DIME\\Action\\JsonApi\\FindCollectionAction')
                    ->bind('api.actors.finds.collection');

        $controllers->get('/actors/{actorSlug}/locations', 'DIME\\Action\\JsonApi\\LocationCollectionAction')
                    ->bind('api.actors.locations.collection');

        $controllers->get('/actors/{actorSlug}', 'DIME\\Action\\JsonApi\\ActorGetAction')
                    ->bind('api.actors.get');

        $controllers->get('/actors', 'DIME\\Action\\JsonApi\\ActorCollectionAction')
                    ->bind('api.actors.collection');

        $controllers->get('/finds/{findSlug}', 'DIME\\Action\\JsonApi\\FindGetAction')
                    ->bind('api.finds.get');

        $controllers->get('/finds', 'DIME\\Action\\JsonApi\\FindCollectionAction')
                    ->bind('api.finds.collection');

        $controllers->get('/locations/{locationSlug}', 'DIME\\Action\\JsonApi\\LocationGetAction')
                    ->bind('api.locations.get');

        $controllers->get('/locations', 'DIME\\Action\\JsonApi\\LocationCollectionAction')
                    ->bind('api.locations.collection');

        return $controllers;
    }
}
