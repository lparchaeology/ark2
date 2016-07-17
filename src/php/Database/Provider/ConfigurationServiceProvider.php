<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Database/Provider/ConfigurationServiceProvider.php
*
* Ark Database Configuration Service Provider
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
* @see        http://ark.lparchaeology.com/code/src/php/Database/Provider/ConfigurationServiceProvider.php
* @since      2.0
*/

namespace ARK\Database\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\DBAL\Connection;
use ARK\Database\Configuration;
use ARK\Database\Database;

class ConfigurationServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        // Override the default DoctrineServiceProvider initializer
        $app['dbs.options.initializer'] = $app->protect(function () use ($app) {
            static $initialized = false;
            if ($initialized) {
                return;
            }
            $initialized = true;

            $app['dbs.settings'] = new Configuration($app['dir.config'].'/database.json', $app['dir.arks'].'/database.json');
            $conns = $app['dbs.settings']->connections();
            if (!count($conns)) {
                // If no connections configured, then use the defaults from DoctrineServiceProvider
                $conns = array('default' => $app['db.default_options']);
            }
            $app['dbs.options'] = $conns;
            $app['dbs.default'] = 'default';
        });

        // Lazy load the Data Database connection
        $app['db.data'] = function ($app) {
            if (isset($app['dbs.options']['data'])) {
                return $app['dbs']['data'];
            }
            return $app['db'];
        };

        // Lazy load the User Database connection
        $app['db.user'] = function ($app) {
            if (isset($app['dbs.options']['user'])) {
                return $app['dbs']['user'];
            }
            return $app['db'];
        };

        // Lazy load the Config Database connection
        $app['db.conf'] = function ($app) {
            if (isset($app['dbs.options']['conf'])) {
                return $app['dbs']['conf'];
            }
            return $app['db'];
        };

        // Lazy load the Spatial Database connection
        $app['db.spatial'] = function ($app) {
            if (isset($app['dbs.options']['spatial'])) {
                return $app['dbs']['spatial'];
            }
            return $app['db'];
        };

        // Lazy load the Database class
        $app['database'] = function ($app) {
            return new Database($app);
        };
    }
}
