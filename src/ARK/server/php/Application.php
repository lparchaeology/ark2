<?php

/**
 * ARK Application
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

use ARK\ARK;
use ARK\Api\JsonApi\Http\JsonApiRequest;
use ARK\Api\JsonApi\JsonApiServiceProvider;
use ARK\Database\DbalServiceProvider;
use ARK\Http\Error\InternalServerError;
use ARK\ORM\OrmServiceProvider;
use ARK\Provider\SpatialServiceProvider;
use ARK\Provider\JsonSchemaServiceProvider;
use ARK\Translation\Loader\ActorLoader;
use ARK\Translation\Loader\DatabaseLoader;
use ARK\Translation\Twig\TranslateExtension;
use Bernard\Serializer;
use Psr\Log\LogLevel;
use Psr\Http\Message\ResponseInterface;
use rootLogin\UserProvider\Provider\UserProviderServiceProvider;
use Silex\Application as SilexApplication;
use Silex\Application\TwigTrait;
use Silex\Application\MonologTrait;
use Silex\Application\TranslationTrait;
use Silex\Application\FormTrait;
use Silex\Application\SecurityTrait;
use Silex\Application\SwiftmailerTrait;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\RememberMeServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SerializerServiceProvider;
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
use Symfony\Component\Debug\BufferingLogger;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WyriHaximus\SliFly\FlysystemServiceProvider;

class Application extends SilexApplication
{
    use TwigTrait;
    use MonologTrait;
    use TranslationTrait;
    use FormTrait;
    use SecurityTrait;
    use SwiftmailerTrait;

    private static $version = '';
    private static $debug = false;

    public function __construct($configPath)
    {
        self::$version = ARK::version();

        if (!$config = json_decode(file_get_contents($configPath), true)) {
            // TODO One day, run the first-run wizard!
            throw new \Exception('No valid site configuration found.');
        }
        $this['ark'] = $config;

        self::$debug = $config['debug'];
        if (self::$debug) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            Debug::enable();
        } else {
            error_reporting(E_ERROR | E_WARNING | E_PARSE);
            ini_set('display_errors', 0);
            // TODO Check is production safe, also need a custom Exception Handler to log?
            ErrorHandler::register();
            ExceptionHandler::register(false);
        }

        parent::__construct();

        // Enable the debug mode
        $this['debug'] = self::$debug;

        // Configure directories
        $this['dir.install'] = ARK::installDir();
        $this['dir.var'] = $this['dir.install'].'/var';
        $this['dir.cache'] = $this['dir.var'].'/cache';
        $this['dir.sites'] = $this['dir.install'].'/sites';
        $this['dir.site'] = $this['dir.sites'].'/'.$config['site'];
        $this['dir.config'] = $this['dir.site'].'/config';
        $this['dir.files'] = $this['dir.site'].'/files';
        $this['dir.web'] = $this['dir.site'].'/web';

        // Configure the File System
        $this->register(new FlysystemServiceProvider());
        $this['flysystem.filesystems'] = [
            'tmp' => ['adapter' => 'League\Flysystem\Adapter\Local', 'args' => [$this['dir.files'].'/tmp']],
            'download' => ['adapter' => 'League\Flysystem\Adapter\Local', 'args' => [$this['dir.files'].'/download']],
            'upload' => ['adapter' => 'League\Flysystem\Adapter\Local', 'args' => [$this['dir.files'].'/upload']],
            'data' => ['adapter' => 'League\Flysystem\Adapter\Local', 'args' => [$this['dir.files'].'/data']],
            'thumbs' => ['adapter' => 'League\Flysystem\Adapter\Local', 'args' => [$this['dir.files'].'/thumbs']],
        ];

        // Enable core providers
        $this->register(new HttpFragmentServiceProvider());
        $this->register(new ServiceControllerServiceProvider());
        $this->register(new SessionServiceProvider());

        // Enable the Locale
        $this->register(new LocaleServiceProvider());
        date_default_timezone_set(isset($config['timezone']) ? $config['timezone'] : 'UTC');
        $this['locale'] = (isset($config['locale']) ? $config['locale'] : 'en');
        $this['locale_fallbacks'] = (isset($config['locales']) ? $config['locales'] : [$this['locale']]);

        // Enable the mailer
        $this->register(new SwiftmailerServiceProvider());
        // TODO Configure mailer!
        $this['swiftmailer.options'] = [];

        // Enable the logger
        $this->register(new MonologServiceProvider());
        $this['monolog.logfile'] = $this['dir.var'].'/logs/'.$config['site'].'.log';
        $this['monolog.name'] = $config['site'];
        if (self::$debug) {
            $this['monolog.level'] = 'DEBUG';
            $this['logger.level'] = LogLevel::DEBUG;
        } else {
            $this['monolog.level'] = 'WARNING';
            $this['logger.level'] = LogLevel::WARNING;
        }

        // Enable the Database
        // - Optional on Use: Logger, Stopwatch
        $this->register(new DbalServiceProvider());
        // - Optional on Use: DBAL, Cache
        $this->register(new OrmServiceProvider());

        // Enable the Spatial functions
        // - Required on boot: DBAL
        if (isset($app['ark']['spatial'])) {
            $this->register(new SpatialServiceProvider());
        }

        $this->register(new SerializerServiceProvider());
        $this->register(new ValidatorServiceProvider());

        // Enable Security
        // - Required on Use: Logger
        $this->register(new SecurityServiceProvider());
        // - Required on Use: Security, Logger
        $this->register(new RememberMeServiceProvider());
        // - Optional on Use: Session
        $this->register(new CsrfServiceProvider());
        $this['security.firewalls'] = [];
        $this->addSecurityFirewall(
            'login_area',
            ['pattern' => '(^/users/login$)|(^/users/register$)|(^/users/forgot-password$)']
        );
        $this->addSecurityFirewall(
            'secured_area',
            ['pattern' => '^.*$',
             'anonymous' => $config['anonymous'],
             'remember_me' => [],
             'form' => [
                'login_path' => '/users/login',
                'check_path' => '/users/login_check',
             ],
             'logout' => [
                'logout_path' => '/users/logout',
             ],
             'users' => function ($app) {
                 return $app['user.manager'];
             },
            ]
        );

        // - On Register: Intl
        // - Optional on Use: Translation, CSRF, Validator
        $this->register(new FormServiceProvider());

        // Enable Translation
        // - Required on Use: Locale
        // - Optional on Use: Validator, Form
        $this->register(new TranslationServiceProvider());
        $this->extend('translator', function ($translator, $app) {
            $translator->addLoader('database', new DatabaseLoader());
            $translator->addLoader('actor', new ActorLoader());
            $translator->addResource('database', $app['database'], 'en');
            $translator->addResource('database', $app['database'], 'da');
            $translator->addResource('actor', $app['database'], 'en');
            $app->loadTranslationFiles($translator, $app['locale_fallbacks'], $this['dir.site'].'/translations');
            $app->loadTranslationFiles($translator, $app['locale_fallbacks'], $this['dir.site'].'/translations/'.$app['ark']['web']['frontend']);
            return $translator;
        });

        // Enable User Manager
        // - On Register: Security, Validator, Mailer, DBAL
        // - Optional on Use: Twig, Mailer, URL Generator, Translator, Forms, Console, ORM
        $this->register(new UserProviderServiceProvider(true));
        $this['user.options'] = [
            'userConnection' => 'user',
            'userClass' => 'rootLogin\UserProvider\Entity\LegacyUser',
            'userTableName' => 'ark_user',
            'userCustomFieldsTableName' => 'ark_user_field',
            'editCustomFields' => [],
            'templates'=> ['layout' => 'pages/page.html.twig'],
        ];

        // Enable the Assets
        $this['dir.assets'] = $this['dir.web'].'/assets/'.$config['web']['frontend'];
        $this['path.assets'] = '/assets/'.$config['web']['frontend'];
        $this->register(
            new AssetServiceProvider(),
            [
                'assets.version' => self::$version,
                'assets.version_format' => '%s?version=%s',
                'assets.named_packages' => [
                    'frontend' => [
                        'base_path' => $this['path.assets'],
                    ],
                ],
            ]
        );

        $this->register(new VarDumperServiceProvider());

        // Enable Twig templates
        // - Optional on Use: Security, Translation, Fragment, Assets, Form, Dumper
        $this->register(new TwigServiceProvider());
        $this->extend('twig', function ($twig, $app) {
            $twig->addExtension(new TranslateExtension($app['translator']));
            return $twig;
        });
        $this['twig.path'] = [
            $this['dir.site'].'/templates/'.$config['web']['frontend'],
        ];
        $this['twig.form.templates'] = [
            'forms/layout.html.twig',
        ];
        $this['twig.options'] = [
            'cache' => $this['dir.var'].'/cache/twig',
        ];

        // Configure API
        $path = $config['api']['path'];
        $this['path.api'] = $path;
        $this->register(new JsonSchemaServiceProvider());
        $this->register(new JsonApiServiceProvider());
        // FIXME Unsecured API access, secure with OAUTH2
        $this->addSecurityFirewall('api_area', ['pattern' => "(^$path)"]);

        // Enable the Profiler
        if ($this['debug']) {
            $this->register(new WebProfilerServiceProvider(), [
                'profiler.cache_dir' => $this['dir.var'].'/cache/profiler',
            ]);
            $this->register(new DoctrineProfilerServiceProvider());
            $this->addSecurityFirewall('dev_area', ['pattern' => '^/(_(profiler|wdt)|css|images|js)/']);
        }

        // Set up the Service Provider
        Service::init($this);
    }

    private function addSecurityFirewall($area, $firewall)
    {
        $firewalls = (isset($this['security.firewalls'])) ? $this['security.firewalls'] : [];
        $firewalls[$area] = $firewall;
        $this['security.firewalls'] = $firewalls;
    }

    private function loadTranslationFiles($translator, $languages, $dir)
    {
        try {
            $files = new \DirectoryIterator($dir);
            foreach ($files as $file) {
                $parts = explode('.', $file->getFilename());
                if ($file->getExtension() == 'xlf' && in_array($parts[1], $languages)) {
                    $translator->addResource('xliff', $file->getPathname(), $parts[1], $parts[0]);
                }
            }
        } catch (\Exception $e) {
        }
    }

    public function run(Request $request = null)
    {
        if ($request === null) {
            $path = (isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '');
            $pos = strpos($path, $this['path.api']);
            if ($pos === 0) {
                $request = JsonApiRequest::createFromGlobals();
                $request->setResourcePath(substr($path, strlen($path) - $pos));
            }
        }
        parent::run($request);
    }

    public function translate($id, $role = 'default', array $parameters = [], $domain = 'messages', $locale = null)
    {
        if ($role != null && $role != 'default') {
            $msg = $this->trans($id.'.'.$role, $parameters, $domain, $locale);
            if ($msg != $id) {
                return $msg;
            }
        }
        return $this->trans($id, $parameters, $domain, $locale);
    }

    public function translateChoice($id, $number, $role = 'default', array $parameters = [], $domain = 'messages', $locale = null)
    {
        if ($role != null && $role != 'default') {
            $msg = $this->transChoice($id.'.'.$role, $number, $parameters, $domain, $locale);
            if ($msg != $id) {
                return $msg;
            }
        }
        return $this->transChoice($id, $number, $parameters, $domain, $locale);
    }

    public static function debug()
    {
        return self::$debug;
    }
}
