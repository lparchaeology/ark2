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

namespace DIME\Routing;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class ViewControllerProvider implements ControllerProviderInterface
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

        // Internal API routes
        $controllers->match('/api/internal/translations/{keyword}/languages/{language}',
                            'DIME\Controller\API\TranslationMessageController')
            ->method('GET|POST')
            ->bind('api.internal.translation.message');
        $controllers->get('/api/internal/file/{id}', 'DIME\Controller\API\FileGetController')
            ->bind('api.internal.file.get');
        $controllers->post('/api/internal/file', 'DIME\Controller\API\FilePostController')
            ->bind('api.internal.file.add');
        $controllers->match('/api/internal/users/{id}/password/set', 'DIME\Controller\API\UserPasswordSetController')
            ->method('POST')
            ->bind('api.internal.user.password.set');
        $controllers->match('/api/internal/actors/{id}/roles/add', 'DIME\Controller\API\ActorRoleAddController')
            ->method('POST')
            ->bind('api.internal.actor.role.add');
        $controllers->match('/api/internal/actors/{id}', 'DIME\Controller\API\ActorController')
            ->method('GET|POST')
            ->bind('api.internal.actor');
        $controllers->post('/api/internal/vocabulary', 'DIME\Controller\API\VocabularyController')
            ->bind('api.internal.vocabulary');
        $controllers->post('/api/internal/message/read', 'DIME\Controller\API\MessageReadController')
            ->bind('api.internal.message.read');
        $controllers->post('/api/geo/find', 'DIME\Controller\API\GeoFindController')
            ->bind('api.geo.find');
        $controllers->get('/api/geo/choropleth', 'DIME\Controller\API\ChoroplethController')
            ->bind('api.geo.choropleth');
        $controllers->get('/img/{image}', 'DIME\Controller\API\ImageController')
            ->bind('img');

        // Admin Routes
        $controllers->match("/$admin/$users/register", 'DIME\Controller\View\UserRegisterController')
            ->method('GET|POST')
            ->bind('dime.admin.users.register');
        $controllers->match("/$admin/$users", 'DIME\Controller\View\AdminUserController')
            ->method('GET|POST')
            ->bind('dime.admin.users');
        $controllers->match("/$admin", 'DIME\Controller\View\AdminHomeController')
            ->method('GET')
            ->bind('dime.admin');

        // User Routes
        $routes = $app['ark']['security']['routes'];
        $locale = $app['locale'];
        $controllers->match($routes['register']['paths'][$locale], 'DIME\Controller\View\UserRegisterController')
            ->method('GET|POST')
            ->bind($routes['register']['route']);
        $controllers->match($routes['reset']['paths'][$locale], 'DIME\Controller\View\UserResetController')
            ->method('GET|POST')
            ->bind($routes['reset']['route']);
        $controllers->match($routes['confirm']['paths'][$locale], 'DIME\Controller\View\UserConfirmController')
            ->method('GET')
            ->bind($routes['confirm']['route']);
        $controllers->match($routes['login']['paths'][$locale], 'DIME\Controller\View\UserLoginController')
            ->method('GET')
            ->bind($routes['login']['route']);
        $controllers->match($routes['verify']['paths'][$locale], 'DIME\Controller\View\UserVerifyController')
            ->method('GET')
            ->bind($routes['verify']['route']);
        $controllers->match($routes['check']['paths'][$locale], function () : void {
        })
            ->method('GET|POST')
            ->bind($routes['check']['route']);
        $controllers->match($routes['logout']['paths'][$locale], function () : void {
        })
            ->method('GET')
            ->bind($routes['logout']['route']);

        // Static Page Routes
        $controllers->match("/$detector", 'DIME\Controller\View\PageViewController')
            ->method('GET|POST')
            ->bind('dime.detector');
        $controllers->match("/$research", 'DIME\Controller\View\PageViewController')
            ->method('GET|POST')
            ->bind('dime.research');
        $controllers->match("/$about", 'DIME\Controller\View\PageViewController')
            ->method('GET|POST')
            ->bind('dime.about');
        $controllers->match("/$news", 'DIME\Controller\View\NewsPageController')
            ->method('GET')
            ->bind('dime.news');

        // Temp Routes?
        $controllers->match("/$files/{id}", 'DIME\Controller\API\FileGetController')
            ->method('GET|POST')
            ->bind('files.view');
        $controllers->match("/$claim/{id}", 'DIME\Controller\View\TreasureClaimController')
            ->method('GET|POST')
            ->bind('dime.treasure.claim');

        // Find Routes
        $controllers->match("/$finds/add", 'DIME\Controller\View\FindAddController')
            ->method('GET|POST')
            ->bind('dime.finds.add');
        $controllers->match("/$finds/{id}", 'DIME\Controller\View\FindViewController')
            ->method('GET|POST')
            ->bind('dime.finds.view');
        $controllers->match("/$finds", 'DIME\Controller\View\FindListController')
            ->method('GET|POST')
            ->bind('dime.finds.list');

        // Profile Routes
        $controllers->match("/$profiles/{id}", 'DIME\Controller\View\ProfileViewController')
            ->method('GET')
            ->bind('dime.profiles.view');
        $controllers->match("/$profiles", 'DIME\Controller\View\ProfileListController')
            ->method('GET')
            ->bind('dime.profiles.list');

        // Home routes
        $controllers->match("/$home/$profile", 'DIME\Controller\View\UserProfileController')
            ->method('GET|POST')
            ->bind('dime.home.profile');
        $controllers->match("/$home/$finds", 'DIME\Controller\View\FindListController')
            ->method('GET|POST')
            ->bind('dime.home.finds');
        $controllers->get("/$home/$messages", 'DIME\Controller\View\MessagePageController')->bind('dime.home.messages');
        $controllers->get("/$home", 'DIME\Controller\View\HomePageController')->bind('dime.home');
        $controllers->get('/', 'DIME\Controller\View\FrontPageController')->bind('dime.front');

        return $controllers;
    }
}
