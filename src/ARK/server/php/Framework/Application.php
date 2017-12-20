<?php

/**
 * ARK Application.
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
 */

namespace ARK\Framework;

use ARK\Api\JsonApi\Http\JsonApiRequest;
use ARK\ARK;
use ARK\Framework\Provider\ApiServiceProvider;
use ARK\Framework\Provider\BusServiceProvider;
use ARK\Framework\Provider\DbalServiceProvider;
use ARK\Framework\Provider\DebugServiceProvider;
use ARK\Framework\Provider\FileServiceProvider;
use ARK\Framework\Provider\FormServiceProvider;
use ARK\Framework\Provider\JsonSchemaServiceProvider;
use ARK\Framework\Provider\LocaleServiceProvider;
use ARK\Framework\Provider\LoggerServiceProvider;
use ARK\Framework\Provider\MailerServiceProvider;
use ARK\Framework\Provider\OrmServiceProvider;
use ARK\Framework\Provider\RoutingServiceProvider;
use ARK\Framework\Provider\SecurityServiceProvider;
use ARK\Framework\Provider\SpatialServiceProvider;
use ARK\Framework\Provider\TranslationServiceProvider;
use ARK\Framework\Provider\ViewServiceProvider;
use ARK\Framework\Provider\WorkflowServiceProvider;
use ARK\Service;
use Saxulum\DoctrineOrmManagerRegistry\Provider\DoctrineOrmManagerRegistryProvider;
use Silex\Application\FormTrait;
use Silex\Application\MonologTrait;
use Silex\Application\SecurityTrait;
use Silex\Application\SwiftmailerTrait;
use Silex\Application\TranslationTrait;
use Silex\Application\TwigTrait;
use Silex\Application\UrlGeneratorTrait;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\SerializerServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

class Application extends AbstractApplication
{
    use TwigTrait;
    use MonologTrait;
    use TranslationTrait;
    use FormTrait;
    use SecurityTrait;
    use SwiftmailerTrait;
    use UrlGeneratorTrait;

    public function __construct(string $site)
    {
        parent::__construct();

        // Set up the Service Provider
        Service::init($this);

        $this['ark'] = ARK::siteConfig($site);
        if (!$this['ark']) {
            // TODO One day, run the first-run wizard!
            throw new \Exception('No valid site configuration found.');
        }

        // Enable the debug mode
        $this->setDebugMode($this['ark']['debug']);

        // Enable core providers
        // - No required on register
        $this->register(new FileServiceProvider());
        $this->register(new HttpFragmentServiceProvider());
        $this->register(new LocaleServiceProvider());
        $this->register(new LoggerServiceProvider($this['ark']['site']));
        $this->register(new MailerServiceProvider());
        $this->register(new ServiceControllerServiceProvider());
        $this->register(new SessionServiceProvider());

        // Enable the Message Bus and Event Bus
        // - Required on Use: Logger
        $this->register(new BusServiceProvider());

        // Enable the Database
        // - Optional on Use: Logger, Stopwatch
        $this->register(new DbalServiceProvider());
        // - Optional on Use: DBAL, Cache
        $this->register(new OrmServiceProvider());

        // Enable the Spatial functions
        // - Required on boot: DBAL
        $this->register(new SpatialServiceProvider());

        $this->register(new SerializerServiceProvider());
        $this->register(new ValidatorServiceProvider());

        // Enable Forms
        // - On Register: Intl
        // - Optional on Use: Translation, CSRF, Validator
        $this->register(new FormServiceProvider());

        // Enable Forms
        // - On Register: ORM, Validator, Form
        // - Optional on Use:
        $this->register(new DoctrineOrmManagerRegistryProvider());

        // Enable Security
        // - On Register: Forms, Validator, Mailer, DBAL/ORM
        // - Required on Use: Logger
        // - Optional on Use: Session, Twig, Mailer, URL Generator, Translator, Console, ORM
        $this->register(new SecurityServiceProvider());

        // Enable Translation
        // - Required on Use: Locale
        // - Optional on Use: Validator, Form
        $this->register(new TranslationServiceProvider());

        // Enable Workflow
        $this->register(new WorkflowServiceProvider());

        // Enable View
        // - Optional on Use: Security, Translation, Fragment, Assets, Form, Dumper, Workflow
        $this->register(new ViewServiceProvider());

        $this->register(new JsonSchemaServiceProvider());

        // Configure API
        $this->register(new ApiServiceProvider());

        // Enable the Debug Profiler
        $this->register(new DebugServiceProvider());

        // Define the routes
        $this->register(new RoutingServiceProvider());
    }

    public function boot() : void
    {
        if ($this->booted) {
            return;
        }
        parent::boot();

        // FIXME HACK Workaround the listener not firing for some reason
        if ($this['debug']) {
            $this['var_dumper.dump_listener']->configure();
        }
    }

    public function run(Request $request = null) : void
    {
        // TODO Use kernel event instead???
        if ($request === null) {
            $path = ($_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'] ?? '');
            $pos = mb_strpos($path, $this['path.api']);
            if ($pos === 0) {
                $request = JsonApiRequest::createFromGlobals();
                $request->setResourcePath(mb_substr($path, mb_strlen($path) - $pos));
            }
        }
        parent::run($request);
    }

    public function translate(
        ?string $id,
        string $role = 'default',
        iterable $parameters = [],
        string $domain = 'messages',
        strint $locale = null
    ) : string {
        if (!$id) {
            return  '';
        }
        if ($role !== null && $role !== 'default') {
            $lookup = $id.'.'.$role;
            $msg = $this->trans($lookup, $parameters, $domain, $locale);
            if ($msg !== $lookup) {
                return $msg;
            }
        }
        return $this->trans($id, $parameters, $domain, $locale);
    }

    public function translateChoice(
        ?string $id,
        int $number,
        string $role = 'default',
        iterable $parameters = [],
        string $domain = 'messages',
        strint $locale = null
    ) : string {
        if (!$id) {
            return  '';
        }
        if ($role !== null && $role !== 'default') {
            $lookup = $id.'.'.$role;
            $msg = $this->transChoice($lookup, $number, $parameters, $domain, $locale);
            if ($msg !== $lookup) {
                return $msg;
            }
        }
        return $this->transChoice($id, $number, $parameters, $domain, $locale);
    }

    public function cacheDir() : string
    {
        return  ARK::siteCacheDir($this['ark']['site']);
    }

    public function logDir() : string
    {
        return  ARK::siteLogDir($this['ark']['site']);
    }
}
