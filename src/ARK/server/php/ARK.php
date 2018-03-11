<?php

/**
 * ARK Installation Globals.
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
 * @copyright  2018 L - P : Heritage LLP
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK;

use DateTime;
use DateTimeZone;
use Symfony\Component\Filesystem\Filesystem;

class ARK
{
    public const VERSION = '1.9.80';
    public const VERSION_ID = 10980;
    public const MAJOR_VERSION = 1;
    public const MINOR_VERSION = 9;
    public const RELEASE_VERSION = 80;
    public const EXTRA_VERSION = '';

    public static function version() : string
    {
        return self::VERSION;
    }

    public static function timestamp() : DateTime
    {
        return new DateTime(null, new DateTimeZone('UTC'));
    }

    public static function installDir() : string
    {
        return realpath(__DIR__.'/../../../..');
    }

    public static function vendorDir() : string
    {
        return self::installDir().'/vendor';
    }

    public static function varDir() : string
    {
        return self::installDir().'/var';
    }

    public static function cacheDir() : string
    {
        return self::varDir().'/cache';
    }

    public static function logDir() : string
    {
        return self::varDir().'/log';
    }

    public static function srcDir() : string
    {
        return self::installDir().'/src';
    }

    public static function namespaceDir(string $namespace) : string
    {
        return self::srcDir().'/'.$namespace;
    }

    public static function autoloadDir(string $project = 'ARK') : string
    {
        return self::srcDir()."/$project/server/php";
    }

    public static function frontendDir(string $namespace, string $frontend) : string
    {
        return self::namespaceDir($namespace)."/frontend/$frontend";
    }

    public static function sitesDir() : string
    {
        return self::installDir().'/sites';
    }

    public static function siteDir(string $site) : string
    {
        return self::sitesDir().'/'.$site;
    }

    public static function siteVarDir(string $site) : string
    {
        return self::siteDir($site).'/var';
    }

    public static function siteCacheDir(string $site) : string
    {
        return self::siteVarDir($site).'/cache';
    }

    public static function siteLogDir(string $site) : string
    {
        return self::siteVarDir($site).'/log';
    }

    public static function templatesDir(string $site, string $frontend) : string
    {
        return self::siteDir($site).'/templates/'.$frontend;
    }

    public static function translationsDir(string $site, string $frontend) : string
    {
        return self::siteDir($site).'/translations/'.$frontend;
    }

    public static function assetsDir(string $site, string $frontend) : string
    {
        return self::siteDir($site).'/public/assets/'.$frontend;
    }

    public static function dirList(string $dir, bool $fullPath = false) : iterable
    {
        $dirs = [];
        foreach (scandir($dir) as $entry) {
            if ($entry !== '.' && $entry !== '..' && is_dir($dir.'/'.$entry)) {
                $dirs[] = $fullPath ? $dir.'/'.$entry : $entry;
            }
        }
        return $dirs;
    }

    public static function fileList(string $dir, bool $fullPath = false) : iterable
    {
        $files = [];
        foreach (scandir($dir) as $entry) {
            if ($entry !== '.' && $entry !== '..' && !is_dir($dir.'/'.$entry)) {
                $files[] = $fullPath ? $dir.'/'.$entry : $entry;
            }
        }
        return $files;
    }

    public static function pathList(string $dir, bool $fullPath = false) : iterable
    {
        $paths = [];
        foreach (scandir($dir) as $entry) {
            if ($entry !== '.' && $entry !== '..') {
                $paths[] = $fullPath ? $dir.'/'.$entry : $entry;
            }
        }
        return $paths;
    }

    public static function namespaces() : iterable
    {
        return self::dirList(self::srcDir());
    }

    public static function frontends() : iterable
    {
        $frontends = [];
        foreach (self::namespaces() as $namespace) {
            if (is_dir(self::namespaceDir($namespace).'/frontend')) {
                foreach (scandir(self::namespaceDir($namespace).'/frontend') as $frontend) {
                    if ($frontend !== '.' && $frontend !== '..' && is_dir(self::frontendDir($namespace, $frontend))) {
                        $frontends[$frontend] = $namespace;
                    }
                }
            }
        }

        return $frontends;
    }

    public static function sites() : iterable
    {
        return self::dirList(self::sitesDir());
    }

    public static function siteConfigPath(string $site) : string
    {
        return self::siteDir($site).'/config/site.json';
    }

    public static function siteConfig(string $site) : ?iterable
    {
        return json_decode(file_get_contents(self::siteConfigPath($site)), true);
    }

    public static function writeSiteConfig(string $site, array $config) : int
    {
        return self::jsonEncodeWrite($config, self::siteConfigPath($site));
    }

    public static function siteDatabaseConfig(string $site, bool $admin = false) : iterable
    {
        $settings = json_decode(file_get_contents(self::siteDir($site).'/config/database.json'), true);
        $conns = [];
        foreach ($settings['connections'] as $name => $config) {
            $config['wrapperClass'] = ($admin ? 'ARK\Database\AdminConnection' : 'ARK\Database\Connection');
            $server = $settings['servers'][$config['server']];
            $conns[$name] = array_merge($server, $config);
        }

        return $conns;
    }

    public static function serversPath() : string
    {
        return self::sitesDir().'/servers.json';
    }

    public static function serversConfig() : iterable
    {
        return json_decode(file_get_contents(self::serversPath()), true);
    }

    public static function servers() : iterable
    {
        $config = self::serversConfig();
        if (isset($config['servers'])) {
            return $config['servers'];
        }

        return [];
    }

    public static function serverNames() : iterable
    {
        return array_keys(self::servers());
    }

    public static function server(string $server) : iterable
    {
        $servers = self::servers();
        if (isset($servers[$server])) {
            return $servers[$server];
        }

        return [];
    }

    public static function defaultServer() : iterable
    {
        $config = self::serversConfig();
        if (isset($config['default']) && isset($config['servers'][$config['default']])) {
            return $config['servers'][$config['default']];
        }
        if (isset($config['servers']) && !empty($config['servers'])) {
            return current($servers['servers']);
        }

        return [];
    }

    public static function defaultServerName() : string
    {
        $config = self::serversConfig();
        if (isset($config['default']) && isset($config['servers'][$config['default']])) {
            return $config['default'];
        }

        return '';
    }

    public static function jsonDecodeFile(string $path) : iterable
    {
        return json_decode(file_get_contents($path), true);
    }

    public static function jsonEncodeWrite(array $data, string $path, bool $pretty = true) : int
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            $fs = new Filesystem();
            $fs->mkdir($dir);
        }
        return file_put_contents($path, self::jsonEncode($data, $pretty));
    }

    public static function jsonEncode(array $data, bool $pretty = true) : string
    {
        if ($pretty) {
            return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return json_encode($data);
    }
}
