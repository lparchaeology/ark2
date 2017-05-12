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

class ApiControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        // Internal API routes
        $controllers->post('/api/internal/vocabulary', 'DIME\Controller\API\VocabularyController')->bind('api.internal.vocabulary');
        $controllers->post('/api/internal/message/read', 'DIME\Controller\API\MessageReadController')->bind('api.internal.message.read');
        $controllers->post('/api/geo/find', 'DIME\Controller\API\GeoFindController')->bind('api.geo.find');
        $controllers->get('/api/geo/choropleth', 'DIME\Controller\API\ChoroplethController')->bind('api.geo.choropleth');
        $controllers->get("/img/{image}", 'DIME\Controller\API\ImageController')->bind('img');

        // JSON API Routes
        $controllers->get('/files/{fileSlug}', 'DIME\Controller\JsonApi\FileGetController')
                    ->bind('api.files.get');

        $controllers->get('/files', 'DIME\Controller\JsonApi\FileCollectionController')
                    ->bind('api.files.collection');

        $controllers->get('/messages/{messageSlug}', 'DIME\Controller\JsonApi\MessageGetController')
                    ->bind('api.messages.get');

        $controllers->get('/messages', 'DIME\Controller\JsonApi\MessageCollectionController')
                    ->bind('api.messages.collection');

        $controllers->get('/events/{eventSlug}', 'DIME\Controller\JsonApi\EventGetController')
                    ->bind('api.events.get');

        $controllers->get('/events', 'DIME\Controller\JsonApi\EventCollectionController')
                    ->bind('api.events.collection');

        $controllers->get('/actors/{actorSlug}/messages', 'DIME\Controller\JsonApi\MessageCollectionController')
                    ->bind('api.actors.messages.collection');

        $controllers->get('/actors/{actorSlug}/events', 'DIME\Controller\JsonApi\EventCollectionController')
                    ->bind('api.actors.events.collection');

        $controllers->get('/actors/{actorSlug}', 'DIME\Controller\JsonApi\ActorGetController')
                    ->bind('api.actors.get');

        $controllers->get('/actors', 'DIME\Controller\JsonApi\ActorCollectionController')
                    ->bind('api.actors.collection');

        $controllers->get('/finds/{findSlug}/messages', 'DIME\Controller\JsonApi\MessageCollectionController')
                    ->bind('api.finds.messages.collection');

        $controllers->get('/finds/{findSlug}/events', 'DIME\Controller\JsonApi\EventCollectionController')
                    ->bind('api.finds.events.collection');

        $controllers->get('/finds/{findSlug}', 'DIME\Controller\JsonApi\FindGetController')
                    ->bind('api.finds.get');

        $controllers->get('/finds', 'DIME\Controller\JsonApi\FindCollectionController')
                    ->bind('api.finds.collection');

        return $controllers;
    }
}
