<?php

/**
 * ARK DBAL Service Provider
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

namespace ARK\Database;

use ARK\Database\Database;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration as DbalConfiguration;
use Doctrine\DBAL\Types\Type;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
// TODO See if we want to use the Bridge instead or Sorien?
//use Symfony\Bridge\Doctrine\Logger\DbalLogger;
use Sorien\Logger\DbalLogger;

class DbalServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['dbs.options.initializer'] = $app->protect(function () use ($app) {
            static $initialized = false;
            if ($initialized) {
                return;
            }
            $initialized = true;
            // TODO Better error checking for missing files and invalid JSON.
            $app['dbs.settings'] = json_decode(file_get_contents($app['dir.config'].'/database.json'), true);
            $options['core'] = $this->mergeConfig($app['dbs.settings'], 'core');
            $options['data'] = $this->mergeConfig($app['dbs.settings'], 'data');
            $options['user'] = $this->mergeConfig($app['dbs.settings'], 'user');
            if (isset($app['dbs.settings']['connections']['spatial'])) {
                $options['spatial'] = $this->mergeConfig($app['dbs.settings'], 'spatial');
            }
            $app['dbs.options'] = $options;
            $app['dbs.default'] = 'data';
        });

        $app['dbs.config'] = function ($app) {
            $app['dbs.options.initializer']();

            $configs = new Container();
            $addLogger = isset($app['logger']) && $app['logger'] !== null;
            $stopwatch = isset($app['stopwatch']) ? $app['stopwatch'] : null;
            foreach ($app['dbs.options'] as $name => $options) {
                $configs[$name] = new DbalConfiguration();
                if ($addLogger) {
                    $configs[$name]->setSQLLogger(new DbalLogger($app['logger'], $stopwatch));
                }
            }

            return $configs;
        };

        $app['dbs.event_manager'] = function ($app) {
            $app['dbs.options.initializer']();

            $managers = new Container();
            foreach ($app['dbs.options'] as $name => $options) {
                $managers[$name] = new EventManager();
            }

            return $managers;
        };

        $app['dbs.types'] = [];

        $app['dbs'] = function ($app) {
            $app['dbs.options.initializer']();

            $dbs = new Container();
            foreach ($app['dbs.options'] as $name => $options) {
                $config = $app['dbs.config'][$name];
                $manager = $app['dbs.event_manager'][$name];
                $dbs[$name] = function ($dbs) use ($options, $config, $manager) {
                    return DriverManager::getConnection($options, $config, $manager);
                };
            }

            foreach ((array) $app['dbs.types'] as $typeName => $typeClass) {
                if (Type::hasType($typeName)) {
                    Type::overrideType($typeName, $typeClass);
                } else {
                    Type::addType($typeName, $typeClass);
                }
            }

            return $dbs;
        };

        $app['db.config'] = function ($app) {
            $dbs = $app['dbs.config'];
            return $dbs[$app['dbs.default']];
        };

        $app['db.event_manager'] = function ($app) {
            $dbs = $app['dbs.event_manager'];
            return $dbs[$app['dbs.default']];
        };

        $app['db'] = function ($app) {
            $dbs = $app['dbs'];
            return $dbs[$app['dbs.default']];
        };

        $app['database'] = function ($app) {
            return new Database($app);
        };
    }

    private function mergeConfig($settings, $conn)
    {
        $connection = $settings['connections'][$conn];
        $connection['wrapperClass'] = 'ARK\\Database\\Connection';
        $server =  $settings['servers'][$connection['server']];
        return array_merge($server, $connection);
    }
}
