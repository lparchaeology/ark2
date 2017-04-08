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

namespace ARK\File\Provider;

use ARK\ARK;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use League\Glide\ServerFactory;
use League\Glide\Responses\SymfonyResponseFactory;
use WyriHaximus\SliFly\FlysystemServiceProvider;

class FileServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        // Configure directories
        $container['dir.install'] = ARK::installDir();
        $container['dir.var'] = ARK::varDir();
        $container['dir.cache'] = ARK::cacheDir();
        $container['dir.sites'] = ARK::sitesDir();
        $container['dir.site'] = ARK::siteDir($container['ark']['site']);
        $container['dir.config'] = $container['dir.site'].'/config';
        $container['dir.files'] = $container['dir.site'].'/files';
        $container['dir.web'] = $container['dir.site'].'/web';

        $container->register(new FlysystemServiceProvider());
        $container['flysystem.filesystems'] = [
            'tmp' => ['adapter' => 'League\Flysystem\Adapter\Local', 'args' => [$container['dir.files'].'/tmp']],
            'download' => ['adapter' => 'League\Flysystem\Adapter\Local', 'args' => [$container['dir.files'].'/download']],
            'upload' => ['adapter' => 'League\Flysystem\Adapter\Local', 'args' => [$container['dir.files'].'/upload']],
            'data' => ['adapter' => 'League\Flysystem\Adapter\Local', 'args' => [$container['dir.files'].'/data']],
            'thumbs' => ['adapter' => 'League\Flysystem\Adapter\Local', 'args' => [$container['dir.files'].'/thumbs']],
        ];

        $container['glide.server'] = function ($app) {
            return ServerFactory::create([
                'source' => $app['flysystems']['data'],
                'cache' =>  $app['flysystems']['thumbs'],
                'driver' => $app['ark']['image'],
                'max_image_size' => $app['ark']['max_image_size'],
                //'defaults' =>                // Default image manipulations
                'presets' => [
                    'thumb' => [
                        'w' => 100,
                        'h' => 100,
                    ],
                    'preview' => [
                        'w' => 500,
                        'h' => 500,
                    ],
                ],
                'base_url' => '/img/',
                'response' => new SymfonyResponseFactory(),
            ]);
        };
    }
}
