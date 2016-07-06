<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Route/SiteControllerProvider.php
*
* Ark Route Site Controller Provider
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Route/SiteControllerProvider.php
* @since      2.0
*/

namespace ARK\Route;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ServiceControllerResolver;
use Silex\API\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class SiteControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        $controllers
            ->method('GET')
            ->get('/{site}/{module}/{item}', 'ARK\\Controller\\ItemController::viewItemAction')
            ->bind('sites.item.view');

        $controllers
            ->method('GET')
            ->get('/{site}/{module}', 'ARK\\Controller\\ModuleController::viewModuleAction')
            ->bind('sites.module.view');

        $controllers
            ->method('GET')
            ->get('/{site}', 'ARK\\Controller\\SiteController::viewSiteAction')
            ->bind('sites.view');

        $controllers->method('GET')->get('/', 'ARK\\Controller\\SiteController::listSitesAction')
            ->bind('sites.list');

        return $controllers;
    }

}
