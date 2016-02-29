<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/framework/routes.php
*
* PHP version 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2015  L - P : Heritage LLP.
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
* @category   framework
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/src/framework/routes.php
* @since      2.0
*
*/

namespace ArkFramework;

use Symfony\Component\Routing;

$routes = new Routing\RouteCollection();
$routes->add('micro_view',
             new Routing\Route('/micro_view.php',
                               array('_controller' => 'ArkFramework\\PageController::indexAction'))
            );

return $routes;

?>
