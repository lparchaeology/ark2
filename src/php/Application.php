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

use ARK\Api\JsonApi\JsonApiRequest;
use ARK\Api\JsonApi\JsonApiServiceProvider;
use ARK\Database\Provider\ConfigurationServiceProvider;
use ARK\Translation\ActorLoader;
use ARK\Translation\DatabaseLoader;
use ARK\Translation\Profiler\TranslationProfilerServiceProvider;
use Psr\Log\LogLevel;
use Psr\Http\Message\ResponseInterface;
use rootLogin\UserProvider\Provider\UserProviderServiceProvider;
use Silex\Application as SilexApplication;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\RememberMeServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\VarDumperServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Sorien\Provider\DoctrineProfilerServiceProvider;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application extends SilexApplication
{
    use \Silex\Application\TwigTrait;
    use \Silex\Application\MonologTrait;
    use \Silex\Application\TranslationTrait;
    use \Silex\Application\FormTrait;
    use \Silex\Application\SecurityTrait;
    use \Silex\Application\SwiftmailerTrait;

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

        date_default_timezone_set('UTC');

        // Configure directories
        $app['dir.root'] = __DIR__.'/../..';
        $app['dir.var'] = $app['dir.root'].'/var';
        // TODO MultiArk mode
        $app['dir.arks'] = $app['dir.root'].'/arks';
        $app['dir.ark'] = $app['dir.arks'].'/default';
        $app['dir.config'] = $app['dir.ark'].'/config';
        $app['dir.data'] = $app['dir.ark'].'/data';
        // TODO configurable themes
        $app['dir.web'] = $app['dir.root'].'/web';
        $app['dir.theme'] = $app['dir.web'].'/themes/default';

        // Configure paths
        $app['path.api'] = '/api/v2';

        // Enable core providers
        $app->register(new HttpFragmentServiceProvider());
        $app->register(new ServiceControllerServiceProvider());
        $app->register(new SessionServiceProvider());

        // Enable the Database
        $app->register(new DoctrineServiceProvider());
        $app->register(new ConfigurationServiceProvider());

        // Enable the logger
        $app->register(new MonologServiceProvider());
        $app['monolog.logfile'] = $app['dir.var'].'/logs/ark.log';
        $app['monolog.name'] = 'ark';
        if ($app['debug']) {
            $app['monolog.level'] = 'DEBUG';
            $app['logger.level'] = LogLevel::DEBUG;
        } else {
            $app['monolog.level'] = 'WARNING';
            $app['logger.level'] = LogLevel::WARNING;
        }

        // Enable Locale/Translation
        $app->register(new LocaleServiceProvider());
        $app->register(new TranslationServiceProvider());
        // TODO Load from config
        $app['locale'] = 'en';
        $app['locale_fallbacks'] = array('en');
        $app->extend('translator', function ($translator, $app) {
            $translator->addLoader('database', new DatabaseLoader());
            $translator->addLoader('actor', new ActorLoader());
            // TODO Load translation files
            $translator->addResource('database', $app['database'], 'en', 'alias');
            $translator->addResource('database', $app['database'], 'en', 'markup');
            $translator->addResource('actor', $app['database'], 'en');
            $translator->addResource('xliff', $app['dir.theme'].'/translations/messages.en.xlf', 'en');
            $translator->addResource('xliff', $app['dir.theme'].'/translations/messages.pl.xlf', 'pl');
            return $translator;
        });

        // Enable Twig templates
        $app->register(new \Silex\Provider\TwigServiceProvider());
        $app['twig.path'] = array($app['dir.theme'].'/templates');
        $app['twig.form.templates'] = array('forms/layout.html.twig');
        $app['twig.options'] = array('cache' => $app['dir.var'].'/cache/twig');

        // Enable Forms and related providers
        $app->register(new ValidatorServiceProvider());
        $app->register(new FormServiceProvider());
        $app->register(new CsrfServiceProvider());

        // Enable mail provider
        $app->register(new SwiftmailerServiceProvider());
        $app['swiftmailer.options'] = array();

        // Enable Security and User providers
        $app->register(new SecurityServiceProvider());
        $app->register(new RememberMeServiceProvider());
        $app->register(new UserProviderServiceProvider());
        $app['user.options'] = array(
            'templates' => [
                'layout' => 'pages/page.html.twig',
            ],
            'userConnection' => 'user',
            'userClass' => 'rootLogin\UserProvider\Entity\LegacyUser',
            'userTableName' => 'ark_user',
            'userCustomFieldsTableName' => 'ark_user_field',
            'editCustomFields' => [],
        );
        $app['security.firewalls'] = array(
            // Ensure dev tools are available if anon access disabled
            'dev_area' => array(
                'pattern' => '^/(_(profiler|wdt)|css|images|js)/',
            ),
            // Ensure login / register are available if anon access disabled
            'login_area' => array(
                'pattern' => '(^/users/login$)|(^/users/register$)|(^/users/forgot-password$)',
            ),
            // FIXME Make API always available if anon access disabled
            'api_area' => array(
                'pattern' => '(^/api)',
            ),
            'secured_area' => array(
                'pattern' => '^.*$',
                'anonymous' => false,
                'remember_me' => array(),
                'form' => array(
                    'login_path' => '/users/login',
                    'check_path' => '/users/login_check',
                ),
                'logout' => array(
                    'logout_path' => '/users/logout',
                ),
                'users' => function ($app) {
                    return $app['user.manager'];
                },
            ),
        );

        // Enable other providers
        $app->register(new JsonApiServiceProvider());
        $app->register(new AssetServiceProvider());

        // If debug mode also enable the profiler
        if ($app['debug']) {
            $app->register(new VarDumperServiceProvider());
            $app->register(new WebProfilerServiceProvider(), array(
                'profiler.cache_dir' => $app['dir.var'].'/cache/profiler',
            ));
            $app->register(new TranslationProfilerServiceProvider());
            $app->register(new DoctrineProfilerServiceProvider());
        }
    }

    public function run(Request $request = null)
    {
        if ($request === null) {
            $path = $_SERVER['PATH_INFO'];
            $pos = strpos($path, $this['path.api']);
            if ($pos === 0) {
                $request = JsonApiRequest::createFromGlobals();
                $request->setResourcePath(substr($path, strlen($path)));
            }
        }
        parent::run($request);
    }
}
