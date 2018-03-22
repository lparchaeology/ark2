<?php

/**
 * ARK Service Provider.
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

use ARK\Database\Connection;
use ARK\Database\Database;
use ARK\Framework\Application;
use ARK\Model\Item;
use ARK\Security\SecurityService;
use ARK\Spatial\SpatialService;
use ARK\Translation\TranslationService;
use ARK\View\ViewService;
use ARK\Workflow\WorkflowService;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\Filesystem;
use League\Glide\Server;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Seld\JsonLint\JsonParser;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Serializer\Serializer;

class Service
{
    private static $app = null;

    public static function init(Application $app) : void
    {
        self::$app = $app;
    }

    public static function config($key = null)
    {
        if ($key) {
            return self::$app['ark'][$key] ?? null;
        }
        return self::$app['ark'];
    }

    public static function debugMode() : bool
    {
        return self::$app['debug'];
    }

    public static function site() : string
    {
        return self::config('site');
    }

    public static function siteDir() : string
    {
        return ARK::siteDir(self::site());
    }

    public static function siteCacheDir($cache = null) : string
    {
        return ARK::siteCacheDir(self::site(), $cache);
    }

    public static function configDir() : string
    {
        return self::$app['dir.config'];
    }

    public static function context() : RequestContext
    {
        return self::$app['request_context'];
    }

    public static function routes() : iterable
    {
        return self::$app['routes'];
    }

    public static function route(string $name) : Route
    {
        return self::$app['routes']->get($name);
    }

    public static function path(string $name, iterable $parameters = [], bool $relative = false) : string
    {
        return self::$app['url_generator']->generate(
            $name,
            $parameters,
            $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH
        );
    }

    public static function url(string $name, iterable $parameters = [], bool $schemeRelative = false) : string
    {
        return self::$app['url_generator']->generate(
            $name,
            $parameters,
            $schemeRelative ? UrlGeneratorInterface::NETWORK_PATH : UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

    public static function redirect(iterable $url, int $status = 302) : Response
    {
        return self::$app->redirect($url, $status);
    }

    public static function redirectPath(string $path, iterable $parmameters = [], int $status = 302) : Response
    {
        return self::$app->redirect(self::path($path, $parmameters), $status);
    }

    public static function itemPath(Item $item, iterable $parameters = [], bool $relative = false) : string
    {
        $parameters['id'] = $item->id();
        return self::path($item->schema()->route()->id(), $parameters, $relative);
    }

    public static function itemUrl(Item $item, iterable $parameters = [], bool $relative = false) : string
    {
        $parameters['id'] = $item->id();
        return self::url($item->schema()->route()->id(), $parameters, $relative);
    }

    public static function filePath(string $id, iterable $parameters = [], bool $relative = false) : string
    {
        $parameters['id'] = $id;
        return self::path('core.api.file', $parameters, $relative);
    }

    public static function fileUrl(string $id, iterable $parameters = [], bool $relative = false) : string
    {
        $parameters['id'] = $id;
        return self::url('core.api.file', $parameters, $relative);
    }

    public static function imageServer(string $server = 'file') : ?Server
    {
        return self::$app['image'][$server];
    }

    public static function imageResponse(string $server, string $path, iterable $parameters = []) : Response
    {
        $server = self::imageServer($server);
        if ($server) {
            return $server->getImageResponse($path, $parameters);
        }
        return new Response();
    }

    public static function imagePath(string $server, string $image, iterable $parameters = [], bool $relative = false) : string
    {
        $parameters['server'] = $server;
        $parameters['image'] = $image;
        return self::path('core.api.image', $parameters, $relative);
    }

    public static function imageUrl(string $server, string $image, iterable $parameters = [], bool $relative = false) : string
    {
        $parameters['server'] = $server;
        $parameters['image'] = $image;
        return self::url('core.api.image', $parameters, $relative);
    }

    public static function forms() : FormFactory
    {
        return self::$app['form.factory'];
    }

    public static function logger() : LoggerInterface
    {
        return self::$app['logger'];
    }

    public static function log(string $message, iterable $context = [], $level = Logger::INFO) : bool
    {
        return self::$app->log($message, $context, $level);
    }

    public static function logError($message, iterable $context = []) : bool
    {
        return self::$app->log($message, $context, Logger::ERROR);
    }

    public static function logInfo($message, iterable $context = []) : bool
    {
        return self::$app->log($message, $context, Logger::INFO);
    }

    public static function logDebug($message, iterable $context = []) : bool
    {
        return self::$app->log($message, $context, Logger::DEBUG);
    }

    public static function filesystem($mount = 'data') : Filesystem
    {
        return self::$app['flysystems'][$mount];
    }

    public static function mailer() : Swift_Mailer
    {
        return self::$app['mailer'];
    }

    public static function sendEmail(string $fromEmail, string $toEmail, string $template, iterable $context = []) : void
    {
        $context = self::view()->templates()->mergeGlobals($context);
        $template = self::view()->templates()->loadTemplate($template);
        $subject = $template->renderBlock('subject', $context);
        $textBody = $template->renderBlock('body_text', $context);
        $htmlBody = $template->renderBlock('body_html', $context);

        $message = new Swift_Message($subject);
        $message->setFrom($fromEmail)->setTo($toEmail);

        if (!empty($htmlBody)) {
            $message->setBody($htmlBody, 'text/html')
                ->addPart($textBody, 'text/plain');
        } else {
            $message->setBody($textBody);
        }

        if (self::$app['ark']['mailer']['enabled']) {
            self::mailer()->send($message);
        } elseif (self::$app['debug']) {
            dump($message);
        }
    }

    public static function entityManager(string $em) : EntityManagerInterface
    {
        return self::$app['orm.ems'][$em];
    }

    public static function locale() : string
    {
        return self::$app['locale'];
    }

    public static function localeFallbacks() : iterable
    {
        return self::$app['locale_fallbacks'];
    }

    public static function jsonLinter() : JsonParser
    {
        return self::$app['json.linter'];
    }

    public static function connection(string $name) : Connection
    {
        return self::$app['dbs'][$name];
    }

    public static function database() : Database
    {
        return self::$app['database'];
    }

    public static function security() : SecurityService
    {
        return self::$app['security'];
    }

    public static function serializer() : Serializer
    {
        return self::$app['serializer'];
    }

    public static function session() : SessionInterface
    {
        return self::$app['session'];
    }

    public static function spatial() : SpatialService
    {
        return self::$app['spatial'];
    }

    public static function translation() : TranslationService
    {
        return self::$app['translation'];
    }

    public static function view() : ViewService
    {
        return self::$app['view'];
    }

    public static function workflow() : WorkflowService
    {
        return self::$app['workflow'];
    }
}
