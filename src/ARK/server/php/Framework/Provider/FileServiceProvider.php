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
 * @php        >=5.6, >=7.0
 */

namespace ARK\Framework\Provider;

use ARK\ARK;
use League\Flysystem\Adapter\Local;
use League\Glide\Responses\SymfonyResponseFactory;
use League\Glide\ServerFactory;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Filesystem\Filesystem;
use WyriHaximus\SliFly\FlysystemServiceProvider;

class FileServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container) : void
    {
        $fs = new Filesystem();

        // Configure various file paths depending on site and frontend
        $container['dir.install'] = ARK::installDir();
        $container['dir.var'] = ARK::siteVarDir($container['ark']['site']);
        $container['dir.cache'] = ARK::siteCacheDir($container['ark']['site']);
        $container['dir.sites'] = ARK::sitesDir();
        $container['dir.site'] = ARK::siteDir($container['ark']['site']);
        $container['dir.config'] = $container['dir.site'].'/config';
        $container['dir.files'] = $container['dir.site'].$container['ark']['file']['root'];
        // Backwards compatability for early DIME versions
        if ($fs->exists($container['dir.site'].'/web')) {
            $container['dir.webroot'] = $container['dir.site'].'/web';
        } else {
            $container['dir.webroot'] = $container['dir.site'].'/public';
        }
        $container['dir.assets'] = $container['dir.webroot'].'/assets/'.$container['ark']['view']['frontend'];

        // Configure Flysystem file systems as defined in the site.json config
        // * 'assets' are the frontend assets, e.g. icons
        // * 'tmp' is for temporary files
        // * 'download' is where files made available for user download are temporarily stored
        // * 'upload' is where files uploaded by users are temporarily stored
        // * 'data' is where actual real data files are stored
        // * 'cache' is the Glide image server caches files
        $container->register(new FlysystemServiceProvider());
        $data = $container['ark']['file']['data'];
        $data['path'] = ($data['adapter'] === 'Local' ? $container['dir.files'].$data['path'] : $data['path']);
        $data['adapter'] = 'League\\Flysystem\\Adapter\\'.$data['adapter'];
        $cache = $container['ark']['file']['cache'];
        $cache['path'] = ($cache['adapter'] === 'Local' ? $container['dir.files'].$cache['path'] : $cache['path']);
        $cache['adapter'] = 'League\\Flysystem\\Adapter\\'.$cache['adapter'];
        $container['flysystem.filesystems'] = [
            'assets' => ['adapter' => Local::class, 'args' => [$container['dir.assets'].'/images']],
            'tmp' => ['adapter' => Local::class, 'args' => [$container['dir.files'].'/tmp']],
            'download' => ['adapter' => Local::class, 'args' => [$container['dir.files'].'/download']],
            'upload' => ['adapter' => Local::class, 'args' => [$container['dir.files'].'/upload']],
            'data' => ['adapter' => $data['adapter'], 'args' => [$data['path']]],
            'cache' => ['adapter' => $cache['adapter'], 'args' => [$cache['path']]],
        ];

        // Configure Glide image server as defined in the site.json config
        // * 'file' is a server mounted at /img/data for the actual data files stored in the 'data' flysystem
        // * 'assets' is a server mounted at /img for frontend assets stored in the 'assets' flysystem
        $container['image'] = function ($app) {
            $image = new Container();
            $config = $app['ark']['image'];
            $flysystems = $app['flysystems'];
            $image['file'] = function ($image) use ($config, $flysystems) {
                $config = $config;
                $config['source'] = $flysystems['data'];
                $config['cache'] = $flysystems['cache'];
                $config['base_url'] = '/img/data/';
                $config['response'] = new SymfonyResponseFactory();
                return ServerFactory::create($config);
            };
            $image['assets'] = function ($image) use ($config, $flysystems) {
                $config = $config;
                $config['source'] = $flysystems['assets'];
                $config['cache'] = $flysystems['cache'];
                $config['base_url'] = '/img/';
                $config['response'] = new SymfonyResponseFactory();
                return ServerFactory::create($config);
            };
            return $image;
        };
    }
}
