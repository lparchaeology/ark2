<?php

/**
 * ARK Debug Route Command
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

namespace ARK\Routing\Console;

use ARK\Console\AbstractCommand;
use ARK\Service;
use Silex\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteDumpCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('route:dump')
             ->setDescription('Dump configured route(s)')
             ->addOptionalArgument('name', 'A specific route name');
    }

    protected function doExecute()
    {
        $this->app()->flush();
        $routes = $this->app('routes');
        if (!$routes->count()) {
            $this->write('No routes defined');
            return;
        }

        if ($name = $this->getArgument('name')) {
            $route = $routes->get($name);
            if (!$route) {
                $this->write('Route does not exist');
                return;
            }
            $this->writeRoute($name, $route);
            return;
        }
        $this->writeRouteCollection($routes);
    }

    protected function writeRouteCollection(RouteCollection $routes)
    {
        foreach ($routes->all() as $name => $route) {
            $controller = $route->getDefault('_controller');
            if ($controller instanceof \Closure) {
                $controller = 'Closure';
            } elseif (is_object($controller)) {
                $controller = get_class($controller);
            }
            $rows[] = [
                $name,
                $route->getMethods() ? implode('|', $route->getMethods()) : 'ANY',
                $route->getSchemes() ? implode('|', $route->getSchemes()) : 'ANY',
                $route->getHost() !== '' ? $route->getHost() : 'ANY',
                $route->getPath(),
                $controller
            ];
        }
        $this->writeTable(['Name', 'Method', 'Scheme', 'Host', 'Path', 'Controller'], $rows);
    }

    protected function writeRoute($name, Route $route)
    {
        $rows[] = ['Route Name', $name];
        $rows[] = ['Path', $route->getPath()];
        $rows[] = ['Path Regex', $route->compile()->getRegex()];
        $rows[] = ['Host', ($route->getHost() ?: 'ANY')];
        $rows[] = ['Host Regex', ($route->getHost() ? $route->compile()->getHostRegex() : '')];
        $rows[] = ['Scheme', ($route->getSchemes() ? implode('|', $route->getSchemes()) : 'ANY')];
        $rows[] = ['Method', ($route->getMethods() ? implode('|', $route->getMethods()) : 'ANY')];
        $rows[] = ['Requirements', ($route->getRequirements() ? $this->formatRouterConfig($route->getRequirements()) : 'NO CUSTOM')];
        $rows[] = ['Class', get_class($route)];
        $rows[] = ['Defaults', $this->formatRouterConfig($route->getDefaults())];
        $rows[] = ['Options', $this->formatRouterConfig($route->getOptions())];
        $this->writeTable(['Property', 'Value'], $rows);
    }

    private function formatRouterConfig(array $config)
    {
        if (empty($config)) {
            return 'NONE';
        }
        ksort($config);
        $configAsString = '';
        foreach ($config as $key => $value) {
            $configAsString .= sprintf("\n%s: %s", $key, $this->formatValue($value));
        }
        return trim($configAsString);
    }

    protected function formatValue($value)
    {
        if (is_object($value)) {
            return sprintf('object(%s)', get_class($value));
        }
        if (is_string($value)) {
            return $value;
        }
        return preg_replace("/\n\s*/s", '', var_export($value, true));
    }
}
