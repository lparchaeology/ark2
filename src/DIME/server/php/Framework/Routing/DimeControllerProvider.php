<?php

/**
 * Ark Route Site Controller Provider.
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

namespace DIME\Framework\Routing;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class DimeControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        // HACK for translated routing, replace later with DynamicRouter
        // Module Resources
        $admin = $app->translate('core.admin', 'resource');
        $users = $app->translate('core.users', 'resource');
        $finds = $app->translate('dime.find', 'resource');
        $actors = $app->translate('core.actor', 'resource');
        $files = $app->translate('core.file', 'resource');
        $events = $app->translate('core.event', 'resource');
        $messages = $app->translate('core.message', 'resource');
        $home = $app->translate('dime.home', 'resource');
        $profile = $app->translate('dime.profile', 'resource');
        $profiles = $app->translate('dime.profiles', 'resource');
        $claim = $app->translate('dime.claim', 'resource');
        // Static pages
        $detector = $app->translate('dime.detector', 'resource');
        $research = $app->translate('dime.research', 'resource');
        $about = $app->translate('dime.about', 'resource');
        $news = $app->translate('dime.news', 'resource');

        $controllers = $app['controllers_factory'];

        // JSON API Routes
        $controllers->match('/api/v2/messages/{message}', 'DIME\Framework\Controller\Api\MessageGetController')
            ->method('GET')
            ->bind('api.messages.get');
        $controllers->match('/api/v2/events/{event}', 'DIME\Framework\Controller\Api\EventGetController')
            ->method('GET')
            ->bind('api.events.get');
        $controllers->match('/api/v2/actors/{actor}', 'DIME\Framework\Controller\Api\ActorGetController')
            ->method('GET')
            ->bind('api.actors.get');

        // Internal API routes
        $controllers->match('/api/internal/translations/{keyword}/languages/{language}',
                            'DIME\Framework\Controller\API\TranslationMessageController')
            ->method('GET|POST')
            ->bind('api.internal.translation.message');
        $controllers->get('/api/internal/file/{id}', 'DIME\Framework\Controller\API\FileGetController')
            ->bind('api.internal.file.get');
        $controllers->post('/api/internal/file', 'DIME\Framework\Controller\API\FilePostController')
            ->bind('api.internal.file.add');
        $controllers->match('/api/internal/users/{id}/password/set', 'DIME\Framework\Controller\API\UserPasswordSetController')
            ->method('POST')
            ->bind('api.internal.user.password.set');
        $controllers->match('/api/internal/actors/{id}/roles/add', 'DIME\Framework\Controller\API\ActorRoleAddController')
            ->method('POST')
            ->bind('api.internal.actor.role.add');
        $controllers->match('/api/internal/actors/{id}', 'DIME\Framework\Controller\API\ActorController')
            ->method('GET|POST')
            ->bind('api.internal.actor');
        $controllers->post('/api/internal/vocabulary', 'DIME\Framework\Controller\API\VocabularyController')
            ->bind('api.internal.vocabulary');
        $controllers->post('/api/internal/message/read', 'DIME\Framework\Controller\API\MessageReadController')
            ->bind('api.internal.message.read');
        $controllers->post('/api/geo/find', 'DIME\Framework\Controller\API\GeoFindController')
            ->bind('api.geo.find');
        $controllers->get('/api/geo/choropleth', 'DIME\Framework\Controller\API\ChoroplethController')
            ->bind('api.geo.choropleth');
        $controllers->get('/img/{server}/{image}', 'ARK\Framework\ImageController')
            ->bind('img');

        // User Routes
        $routes = $app['ark']['security']['routes'];
        $locale = $app['locale'];
        $controllers->match($routes['register']['paths'][$locale], 'DIME\Framework\Controller\View\UserRegisterController')
            ->method('GET|POST')
            ->bind($routes['register']['route']);
        $controllers->match($routes['reset']['paths'][$locale], 'DIME\Framework\Controller\View\UserResetController')
            ->method('GET|POST')
            ->bind($routes['reset']['route']);
        $controllers->match($routes['confirm']['paths'][$locale], 'DIME\Framework\Controller\View\UserConfirmController')
            ->method('GET')
            ->bind($routes['confirm']['route']);
        $controllers->match($routes['login']['paths'][$locale], 'DIME\Framework\Controller\View\UserLoginController')
            ->method('GET')
            ->bind($routes['login']['route']);
        $controllers->match($routes['check']['paths'][$locale], function () : void {})
            ->method('GET|POST')
            ->bind($routes['check']['route']);
        $controllers->match($routes['logout']['paths'][$locale], function () : void {})
            ->method('GET')
            ->bind($routes['logout']['route']);

        // Temp Routes?
        $controllers->match("/$files/{id}", 'DIME\Framework\Controller\API\FileGetController')
            ->method('GET|POST')
            ->bind('files.view');
        $controllers->match("/$claim/{id}", 'DIME\Framework\Controller\View\TreasureClaimController')
            ->method('GET|POST')
            ->bind('dime.treasure.claim');

        return $controllers;
    }
}
