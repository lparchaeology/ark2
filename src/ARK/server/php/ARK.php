<?php

/**
 * ARK Globals
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

namespace ARK;

class ARK
{
    public static function version()
    {
        return '2.0.0';
    }

    public static function installDir()
    {
        return realpath(__DIR__.'/../../../..');
    }

    public static function varDir()
    {
        return realpath(__DIR__.'/../../../../var');
    }

    public static function cacheDir()
    {
        return realpath(__DIR__.'/../../../../cache');
    }

    public static function sitesDir()
    {
        return realpath(__DIR__.'/../../../../sites');
    }

    public static function sites()
    {
        return json_decode(file_get_contents(self::sitesDir().'/sites.json'), true)['sites'];
    }

    public static function defaultSite()
    {
        return json_decode(file_get_contents(self::sitesDir().'/sites.json'), true)['default'];
    }

    public static function servers()
    {
        $config = json_decode(file_get_contents(self::sitesDir().'/servers.json'), true);
        if (isset($config['servers'])) {
            return $config['servers'];
        }
        return [];
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
        $config = json_decode(file_get_contents(self::sitesDir().'/servers.json'), true);
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
        $config = json_decode(file_get_contents(self::sitesDir().'/servers.json'), true);
        if (isset($config['default']) && isset($config['servers'][$config['default']])) {
            return $config['default'];
        }
        return '';
    }
}
