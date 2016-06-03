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

namespace ARK\Route;

use Silex\Application;
use Silex\API\ControllerProviderInterface;

class ApiControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers
            ->get('/sites/{siteSlug}/{moduleSlug}/{itemSlug}', 'ARK\\Api\\JsonApi\\Action\\ItemGetAction')
            ->bind('api.item.get');

        $controllers
            ->post('/sites/{siteSlug}/{moduleSlug}/{itemSlug}', 'ARK\\Api\\JsonApi\\Action\\ItemPostAction')
            ->bind('api.item.post');

        $controllers
            ->delete('/sites/{siteSlug}/{moduleSlug}/{itemSlug}', 'ARK\\Api\\JsonApi\\Action\\ItemDeleteAction')
            ->bind('api.item.delete');

        $controllers
            ->post('/sites/{siteSlug}/{moduleSlug}', 'ARK\\Api\\JsonApi\\Action\\ItemPostAction')
            ->bind('api.item.postnext');

        $controllers
            ->get('/sites/{siteSlug}/{moduleSlug}', 'ARK\\Api\\JsonApi\\Action\\ItemListAction')
            ->bind('api.items.get');

        $controllers
            ->get('/sites/{siteSlug}', 'ARK\\Api\\JsonApi\\Action\\SiteGetAction')
            ->bind('api.site.get');

        $controllers
            ->post('/sites/{siteSlug}', 'ARK\\Api\\JsonApi\\Action\\SitePostAction')
            ->bind('api.site.post');

        $controllers
            ->delete('/sites/{siteSlug}', 'ARK\\Api\\JsonApi\\Action\\SiteDeleteAction')
            ->bind('api.site.delete');

        $controllers
            ->get('/sites', 'ARK\\Api\\JsonApi\\Action\\SiteListAction')
            ->bind('api.sites.get');

        $controllers
            ->post('/sites', 'ARK\\Api\\JsonApi\\Action\\SitePostAction')
            ->bind('api.site.postnext');

        $controllers
            ->put('/sites/{siteSlug}/{moduleSlug}/{itemSlug}', 'ARK\\Controller\\ItemController::patchItemAction')
            ->bind('api.item.patch');

        $controllers
            ->put('/sites/{siteSlug}/{moduleSlug}/{itemSlug}', 'ARK\\Controller\\ItemController::postItemAction')
            ->bind('api.item.post');

        $controllers
            ->post('/sites/{siteSlug}/{moduleSlug}', 'ARK\\Controller\\ItemController::postItemAction')
            ->bind('api.item.post');

        return $controllers;
    }
}
