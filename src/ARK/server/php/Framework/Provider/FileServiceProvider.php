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

use ARK\ARK;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use League\Glide\ServerFactory;
use League\Glide\Responses\SymfonyResponseFactory;
use League\Flysystem\Adapter\Local;
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
        $container['dir.files'] = $container['dir.site'].$container['ark']['file']['root'];
        $container['dir.web'] = $container['dir.site'].'/web';

        $container->register(new FlysystemServiceProvider());
        $data = $container['ark']['file']['data'];
        $data['path'] = ($data['adapter'] == 'Local' ? $container['dir.files'].$data['path'] : $data['path']);
        $data['adapter'] = 'League\\Flysystem\\Adapter\\'.$data['adapter'];
        $cache = $container['ark']['file']['cache'];
        $cache['path'] = ($cache['adapter'] == 'Local' ? $container['dir.files'].$cache['path'] : $cache['path']);
        $cache['adapter'] = 'League\\Flysystem\\Adapter\\'.$cache['adapter'];
        $container['flysystem.filesystems'] = [
            'tmp' => ['adapter' => Local::class, 'args' => [$container['dir.files'].'/tmp']],
            'download' => ['adapter' => Local::class, 'args' => [$container['dir.files'].'/download']],
            'upload' => ['adapter' => Local::class, 'args' => [$container['dir.files'].'/upload']],
            'data' => ['adapter' => $data['adapter'], 'args' => [$data['path']]],
            'cache' => ['adapter' => $cache['adapter'], 'args' => [$cache['path']]],
        ];
        $container['glide.server'] = function ($app) {
            $config = $app['ark']['image'];
            $config['source'] = $app['flysystems']['data'];
            $config['cache'] =  $app['flysystems']['cache'];
            $config['base_url'] = '/img/';
            $config['response'] = new SymfonyResponseFactory();
            return ServerFactory::create($config);
        };
    }
}
