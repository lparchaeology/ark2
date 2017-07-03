<?php

/**
 * ARK Debug Service Provider
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

namespace ARK\Framework\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\VarDumperServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Sorien\Provider\DoctrineProfilerServiceProvider;

class DebugServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        if ($container['debug']) {
            $container->register(new VarDumperServiceProvider());
            $container->register(new WebProfilerServiceProvider(), [
                'profiler.cache_dir' => $container['dir.var'].'/cache/profiler',
            ]);
            // HACK Fix to work-around bug in the profiler not finding the dump template
            $container['profiler.templates_path.debug'] = function () {
                $r = new \ReflectionClass('Symfony\Bundle\DebugBundle\DependencyInjection\Configuration');
                return dirname(dirname($r->getFileName())).'/Resources/views';
            };
            $container->register(new DoctrineProfilerServiceProvider());
            $container->extendArray(
                'security.firewalls',
                'dev_area',
                ['pattern' => '^/(_(profiler|wdt)|css|images|js)/', 'anonymous' => true]
            );
        }
    }
}
