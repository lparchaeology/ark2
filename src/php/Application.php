<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Application.php
*
* Ark Application
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Application.php
* @since      2.0
*/

namespace ARK;

use Symfony\Component\Debug\Debug;
use ARK\Translation\Profiler\TranslationProfilerServiceProvider;

class Application extends \Silex\Application
{
    use \Silex\Application\TwigTrait;
    use \Silex\Application\MonologTrait;
    use \Silex\Application\TranslationTrait;

    public function __construct()
    {
        // TODO Default to on during development, later load from config
        $debug = true;
        if ($debug) {
            Debug::enable();
        } else {
            ini_set('display_errors', 0);
        }

        parent::__construct();
        $app = $this;

        // Enable the debug mode
        if ($debug) {
            $app['debug'] = true;
        }

        // Configure directories
        $app['dir.root'] = __DIR__.'/../..';
        $app['dir.var'] = $app['dir.root'].'/var';
        // TODO MultiArk mode
        $app['dir.ark'] = $app['dir.root'].'/arks/default';
        $app['dir.config'] = $app['dir.ark'].'/config';
        $app['dir.data'] = $app['dir.ark'].'/data';
        // TODO configurable themes
        $app['dir.web'] = $app['dir.root'].'/web';
        $app['dir.theme'] = $app['dir.web'].'/themes/default';

        // Enable core providers
        $app->register(new \Silex\Provider\HttpFragmentServiceProvider());
        $app->register(new \Silex\Provider\ServiceControllerServiceProvider());

        // Enable the logger
        $app->register(new \Silex\Provider\MonologServiceProvider());
        $app['monolog.logfile'] = $app['dir.var'].'/logs/ark.log';
        $app['monolog.name'] = 'ark';
        if ($app['debug']) {
            $app['monolog.level'] = 'DEBUG';
        } else {
            $app['monolog.level'] = 'WARNING';
        }

        // Enable Locale/Translation
        $app->register(new \Silex\Provider\LocaleServiceProvider());
        $app->register(new \Silex\Provider\TranslationServiceProvider());
        // TODO Load from config
        $app['locale'] = 'en';
        $app['locale_fallbacks'] = array('en');
        $app->extend('translator', function($translator, $app) {
            // TODO Load translation files
            //$translator->addResource('xliff', $app['dir.root'].'/l10n/en.xliff', 'en');
            return $translator;
        });

        // Enable Twig templates
        $app->register(new \Silex\Provider\TwigServiceProvider());
        $app['twig.path'] = array($app['dir.theme'].'/templates');
        $app['twig.options'] = array('cache' => $app['dir.var'].'/cache/twig');

        // Enable other providers
        $app->register(new \Silex\Provider\AssetServiceProvider());

        // If debug mode also enable the profiler
        if ($app['debug']) {
            $app->register(new \Silex\Provider\WebProfilerServiceProvider(), array(
                'profiler.cache_dir' => $app['dir.var'].'/cache/profiler',
            ));
            $app->register(new TranslationProfilerServiceProvider());
        }
    }

}