<?php

/**
 * ARK Installation Globals
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

namespace ARK;

class ARK
{
    public static function version()
    {
        return '1.9.80';
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

    public static function srcDir()
    {
        return self::installDir().'/src';
    }

    public static function namespaceDir($namespace)
    {
        return self::srcDir().'/'.$namespace;
    }

    public static function frontendDir($namespace, $frontend)
    {
        return self::namespaceDir().'/'.$frontend;
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

    public static function namespaces()
    {
        $namespaces = [];
        foreach (scandir(self::srcDir()) as $namespace) {
            if ($namespace != '.' && $namespace != '..' && is_dir(self::namespaceDir($namespace))) {
                $namespaces[] = $namespace;
            }
        }
        return $namespaces;
    }

    public static function frontends()
    {
        $frontends = [];
        foreach (self::namespaces() as $namespace) {
            if (is_dir(self::namespaceDir($namespace).'/frontend')) {
                foreach (scandir(self::namespaceDir($namespace).'/frontend') as $frontend) {
                    if ($frontend != '.' && $frontend != '..' && is_dir(self::frontendDir($namespace, $frontend))) {
                        $frontends[] = $frontend;
                    }
                }
            }
        }
        return $frontends;
    }

    public static function sites()
    {
        $sites = [];
        foreach (scandir(self::sitesDir()) as $site) {
            if ($site != '.' && $site != '..' && is_dir(self::siteDir($site))) {
                $sites[] = $site;
            }
        }
        return $sites;
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
}
