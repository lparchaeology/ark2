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

namespace ARK\Routing;

use ARK\ORM\ORM;
use Silex\Application;
use Silex\ControllerCollection;
use Silex\ServiceControllerResolver;
use Silex\API\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ViewControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];
        return $controllers;
        $routes = ORM::findAll(Route::class);
        $pages = ORM::findAll(Page::class);
        $instances = ORM::findAll(Instance::class);

        foreach ($routes as $route) {
            $this->addRoute($controllers, $route);
        }

        $controllers
            ->get("/{parent}/{collection}", 'ARK\Controller\ItemListController')
            ->bind('core.item.list');

        $controllers
            ->get("/{parent}/{collection}/{item}", 'ARK\Controller\ItemViewController')
            ->bind('core.item.view');

        return $controllers;
    }

    public function addRoute($controllers, Route $route)
    {
        $controller = $controllers->match($route->pattern(), $route->controller());
        $controller->method($route->method);
        $controller->bind($route->id());
    }
}
