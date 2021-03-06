<?php

/**
 * ARK Debug Service Provider.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework\Provider;

use ARK\ARK;
use ARK\Form\Extension\DataCollector\FormDataCollector;
use ARK\Translation\DataCollectorTranslator;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\VarDumperServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Symfony\Bridge\Doctrine\DataCollector\DoctrineDataCollector;

class DebugServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container) : void
    {
        // Must always have registered, otherwise stray dump() calls will crash app
        $container->register(new VarDumperServiceProvider());

        // All other debug features only if turned on
        if ($container['debug']) {
            $container->register(new WebProfilerServiceProvider(), [
                'profiler.cache_dir' => $container['dir.cache'].'/profiler',
            ]);

            // HACK Fix to stop form profiler exhausting memory on large forms/tables
            $container->extend('data_collectors.form.collector', function ($app) {
                return new FormDataCollector();
            });

            // HACK Fix to work-around bug in the profiler not finding the dump template
            $container['profiler.templates_path.debug'] = function () {
                $r = new \ReflectionClass('Symfony\Bundle\DebugBundle\DependencyInjection\Configuration');
                return dirname(dirname($r->getFileName())).'/Resources/views';
            };

            // Doctrine Profiler
            $container->extend('data_collectors', function ($collectors, $app) {
                $collectors['db'] = function ($app) {
                    $collector = new DoctrineDataCollector($app['doctrine']);
                    foreach ($app['doctrine']->getConnections() as $name => $conn) {
                        $collector->addLogger($name, $conn->getConfiguration()->getSQLLogger());
                    }
                    return $collector;
                };
                return $collectors;
            });

            // Translation Profiler
            $container->extend('translator', function ($translator, $app) {
                return new DataCollectorTranslator($app['translator.default']);
            });
            $container['data_collector.templates'] = $container->extend('data_collector.templates', function ($templates) {
                // Cloned Database template
                $templates[] = ['db', 'profiler/db.html.twig'];
                // Modified Translation template for editing translations
                $templates[] = ['translation', 'profiler/translation.html.twig'];
                return $templates;
            });

            // Allow anonymous access to profiler!
            $container->extendArray(
                'security.firewalls',
                'dev_area',
                ['pattern' => '^/(_(profiler|wdt)|css|images|js)/', 'anonymous' => true]
            );
        }
    }
}
