<?php

/**
 * ARK Installation Globals.
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
 *
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK;

use Symfony\Component\Filesystem\Filesystem;

class ARK
{
    const VERSION = '1.9.80';
    const VERSION_ID = 10980;
    const MAJOR_VERSION = 1;
    const MINOR_VERSION = 9;
    const RELEASE_VERSION = 80;
    const EXTRA_VERSION = '';

    public static function version()
    {
        return self::VERSION;
    }

    public static function timestamp()
    {
        return new \DateTime(null, new \DateTimeZone('UTC'));
    }

    public static function installDir()
    {
        return realpath(__DIR__.'/../../../..');
    }

    public static function varDir()
    {
        return self::installDir().'/var';
    }

    public static function cacheDir()
    {
        return self::varDir().'/cache';
    }

    public static function logDir()
    {
        return self::varDir().'/log';
    }

    public static function srcDir()
    {
        return self::installDir().'/src';
    }

    public static function namespaceDir($namespace)
    {
        return self::srcDir().'/'.$namespace;
    }

    public static function autoloadDir($project = 'ARK')
    {
        if ($project == 'ARK') {
            return self::srcDir().'/'.'ARK/server/php';
        }

        return self::srcDir().'/'.$project.'/php';
    }

    public static function frontendDir($namespace, $frontend)
    {
        return self::namespaceDir($namespace).'/frontend/'.$frontend;
    }

    public static function sitesDir()
    {
        return self::installDir().'/sites';
    }

    public static function siteDir($site)
    {
        return self::sitesDir().'/'.$site;
    }

    public static function templatesDir($site, $frontend)
    {
        return self::siteDir($site).'/templates/'.$frontend;
    }

    public static function translationsDir($site, $frontend)
    {
        return self::siteDir($site).'/translations/'.$frontend;
    }

    public static function assetsDir($site, $frontend)
    {
        return self::siteDir($site).'/web/assets/'.$frontend;
    }

    public static function dirList($dir, $fullPath = false)
    {
        $dirs = [];
        foreach (scandir($dir) as $entry) {
            if ($entry != '.' && $entry != '..' && is_dir($dir.'/'.$entry)) {
                $dirs[] = $fullPath ? $dir.'/'.$entry : $entry;
            }
        }

        return $dirs;
    }

    public static function fileList($dir, $fullPath = false)
    {
        $files = [];
        foreach (scandir($dir) as $entry) {
            if ($entry != '.' && $entry != '..' && !is_dir($dir.'/'.$entry)) {
                $files[] = $fullPath ? $dir.'/'.$entry : $entry;
            }
        }

        return $files;
    }

    public static function namespaces()
    {
        return self::dirList(self::srcDir());
    }

    public static function frontends()
    {
        $frontends = [];
        foreach (self::namespaces() as $namespace) {
            if (is_dir(self::namespaceDir($namespace).'/frontend')) {
                foreach (scandir(self::namespaceDir($namespace).'/frontend') as $frontend) {
                    if ($frontend != '.' && $frontend != '..' && is_dir(self::frontendDir($namespace, $frontend))) {
                        $frontends[$frontend] = $namespace;
                    }
                }
            }
        }

        return $frontends;
    }

    public static function sites()
    {
        return self::dirList(self::sitesDir());
    }

    public static function siteConfigPath(string $site)
    {
        return self::siteDir($site).'/config/site.json';
    }

    public static function siteConfig(string $site)
    {
        return json_decode(file_get_contents(self::siteConfigPath($site)), true);
    }

    public static function writeSiteConfig(string $site, array $config)
    {
        return self::jsonEncodeWrite($config, self::siteConfigPath($site));
    }

    public static function siteDatabaseConfig($site, $admin = false)
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

    public static function serversPath()
    {
        return self::sitesDir().'/servers.json';
    }

    public static function serversConfig()
    {
        return json_decode(file_get_contents(self::serversPath()), true);
    }

    public static function servers()
    {
        $config = self::serversConfig();
        if (isset($config['servers'])) {
            return $config['servers'];
        }

        return [];
    }

    public static function serverNames()
    {
        return array_keys(self::servers());
    }

    public static function server($server)
    {
        $servers = self::servers();
        if (isset($servers[$server])) {
            return $servers[$server];
        }

        return [];
    }

    public static function defaultServer()
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

    public static function defaultServerName()
    {
        $config = self::serversConfig();
        if (isset($config['default']) && isset($config['servers'][$config['default']])) {
            return $config['default'];
        }

        return '';
    }

    public static function jsonDecodeFile(string $path)
    {
        return json_decode(file_get_contents($path), true);
    }

    public static function jsonEncodeWrite(array $data, string $path, bool $pretty = true)
    {
        $dir = dirname($path);
        if (!is_dir($dir)) {
            $fs = new Filesystem();
            $fs->mkdir($dir);
        }
        file_put_contents($path, self::jsonEncode($data, $pretty));
    }

    public static function jsonEncode(array $data, bool $pretty = true)
    {
        if ($pretty) {
            return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return json_encode($data);
    }
}
