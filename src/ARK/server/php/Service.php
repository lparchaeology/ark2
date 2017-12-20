<?php

/**
 * ARK Service Provider.
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
 * @copyright  2017 L - P : Heritage LLP
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK;

use ARK\Database\Database;
use ARK\Framework\Application;
use ARK\Security\Security;
use ARK\Spatial\Spatial;
use ARK\View\View;
use ARK\Workflow\WorkflowService;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\Filesystem;
use League\Glide\Server;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Seld\JsonLint\JsonParser;
use SimpleBus\Message\Bus\MessageBus;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Serializer;

class Service
{
    private static $app = null;

    public static function init(Application $app) : void
    {
        self::$app = $app;
    }

    public static function config() : iterable
    {
        return self::$app['ark'];
    }

    public static function configDir() : string
    {
        return self::$app['dir.config'];
    }

    public static function routes() : iterable
    {
        return self::$app['routes'];
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

    public static function imageServer(string $server = 'file') : Server
    {
        return self::$app['image'][$server];
    }

    public static function imageResponse(string $server, string $path, iterable $parameters = []) : Response
    {
        return self::imageServer($server)->getImageResponse($path, $parameters);
    }

    public static function imagePath(string $server, string $image, iterable $parameters = []) : string
    {
        $parameters['server'] = $server;
        $parameters['image'] = $image;
        return self::path('img', $parameters);
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

    public static function translate(
        ?string $id,
        string $role = 'default',
        iterable $parameters = [],
        string $domain = 'messages',
        string $locale = null
    ) : string {
        return self::$app->translate($id, $role, $parameters, $domain, $locale);
    }

    public static function translateChoice(
        ?string $id,
        int $number,
        string $role = 'default',
        iterable $parameters = [],
        string $domain = 'messages',
        string $locale = null
    ) : string {
        return self::$app->translateChoice($id, $number, $role, $parameters, $domain, $locale);
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

    public static function bus() : MessageBus
    {
        return self::$app['bus'];
    }

    public static function database() : Database
    {
        return self::$app['database'];
    }

    public static function security() : Security
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

    public static function spatial() : Spatial
    {
        return self::$app['spatial'];
    }

    public static function view() : View
    {
        return self::$app['view'];
    }

    public static function workflow() : WorkflowService
    {
        return self::$app['workflow'];
    }
}
