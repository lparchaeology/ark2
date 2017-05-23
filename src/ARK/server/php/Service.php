<?php

/**
 * ARK Service Provider
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

use ARK\Application;
use ARK\Error\Error;
use ARK\Error\ErrorException;
use ARK\View\Layout;
use ARK\ORM\ORM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Service
{
    private static $app = null;

    public static function init(Application $app)
    {
        self::$app = $app;
    }

    public static function configDir()
    {
        return self::$app['dir.config'];
    }

    public static function path($name, $parameters = [], $relative = false)
    {
        return self::$app['url_generator']->generate($name, $parameters, $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    public static function url($name, $parameters = [], $schemeRelative = false)
    {
        return self::$app['url_generator']->generate($name, $parameters, $schemeRelative ? UrlGeneratorInterface::NETWORK_PATH : UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public static function templates()
    {
        return self::$app['twig'];
    }

    public static function layout($name)
    {
        $layout =  ORM::find(Layout::class, $name);
        if ($layout) {
            return $layout;
        }
        throw new ErrorException(new Error('INVALID_LAYOUT_NAME', "Invalid Layout Name: $name", "Layout $name does not exist"));
    }

    public static function renderResponse($view, array $parameters = [], Response $response = null)
    {
        return self::$app->render($view, $parameters, $response);
    }

    public static function renderView($view, array $parameters = [])
    {
        return self::$app->renderView($view, $parameters);
    }

    public static function renderPdfResponse($view, array $parameters = [], $filename = 'file.pdf', Response $response = null)
    {
        $pdf = self::renderPdf($view, $parameters);
        $headers = ['Content-Type' => 'application/pdf', 'Content-Disposition' => 'filename="'.$filename.'"'];
        if ($response === null) {
            return new Response($pdf, 200, $headers);
        }
        $response->headers->add($headers);
        $response->setContent($pdf);
        return $response;
    }

    public static function renderPdf($view, array $parameters = [])
    {
        $html = self::renderView($view, $parameters);
        return self::$app['renderer.pdf']->getOutputFromHtml($html);
    }

    public static function generatePdf($view, $path, array $parameters = [])
    {
        $html = self::renderView($view, $parameters);
        self::$app['renderer.pdf']->generateFromHtml($html, $path);
    }

    public static function renderImageResponse($view, array $parameters = [], $filename = 'image.jpg', Response $response = null)
    {
        $pdf = self::renderImage($view, $parameters);
        $headers = ['Content-Type' => 'image/jpg', 'Content-Disposition' => 'filename="'.$filename.'"'];
        if ($response === null) {
            return new Response($pdf, 200, $headers);
        }
        $response->headers->add($headers);
        $response->setContent($pdf);
        return $response;
    }

    public static function renderImage($view, array $parameters = [])
    {
        $html = self::renderView($view, $parameters);
        return self::$app['renderer.image']->getOutputFromHtml($html);
    }

    public static function generateImage($view, $path, array $parameters = [])
    {
        $html = self::renderView($view, $parameters);
        self::$app['renderer.image']->generateFromHtml($html, $path);
    }

    public static function redirect($url, $status = 302)
    {
        return self::$app->redirect($url, $status);
    }

    public static function redirectPath($path, $parmameters = null, $status = 302)
    {
        return self::$app->redirect(self::path($path, $parmameters), $status);
    }

    public static function imageServer()
    {
        return self::$app['glide.server'];
    }

    public static function imageResponse($path, array $parameters = [])
    {
        return self::$app['glide.server']->getImageResponse($path, $parameters);
    }

    public static function forms()
    {
        return self::$app['form.factory'];
    }

    public static function logger()
    {
        return self::$app['logger'];
    }

    public static function log($message, array $context = [], $level = Logger::INFO)
    {
        return self::$app->log($message, $context, $level);
    }

    public static function logError($message, array $context = [])
    {
        return self::$app->log($message, $context, Logger::ERROR);
    }

    public static function logInfo($message, array $context = [])
    {
        return self::$app->log($message, $context, Logger::INFO);
    }

    public static function logDebug($message, array $context = [])
    {
        return self::$app->log($message, $context, Logger::DEBUG);
    }

    public static function filesystem($mount = 'data')
    {
        return self::$app['flysystems'][$mount];
    }

    public static function mailer()
    {
        return self::$app['mailer'];
    }

    public static function commandBus()
    {
        return self::$app['bus.command'];
    }

    public static function eventBus()
    {
        return self::$app['bus.event'];
    }

    public static function eventRecorder()
    {
        return self::$app['bus.event.recorder'];
    }

    public static function handleCommand($message)
    {
        return self::$app['bus.command']->handle($message);
    }

    public static function handleEvent($message)
    {
        return self::$app['bus.event']->handle($message);
    }

    public static function recordEvent($message)
    {
        return self::$app['bus.event.recorder']->record($message);
    }

    public static function translate($id, $role = 'default', array $parameters = [], $domain = 'messages', $locale = null)
    {
        return self::$app->translate($id, $role, $parameters, $domain, $locale);
    }

    public static function translateChoice($id, $number, $role = 'default', array $parameters = [], $domain = 'messages', $locale = null)
    {
        return self::$app->translateChoice($id, $number, $role, $parameters, $domain, $locale);
    }

    public static function security()
    {
        return self::$app['security'];
    }

    public static function userManager()
    {
        return self::$app['user.manager'];
    }

    public static function userProvider()
    {
        return self::$app['user.provider'];
    }

    public static function user()
    {
        return self::$app['user'];
    }

    public static function database()
    {
        return self::$app['database'];
    }

    public static function entityManager($em)
    {
        return self::$app['orm.ems'][$em];
    }

    public static function locale()
    {
        return self::$app['locale'];
    }

    public static function localeFallbacks()
    {
        return self::$app['locale_fallbacks'];
    }

    public static function workflow()
    {
        return self::$app['workflow.registry'];
    }

    public static function serializer()
    {
        return self::$app['serializer'];
    }

    public static function jsonLinter()
    {
        return self::$app['json.linter'];
    }

    public static function jsonSchema()
    {
        return self::$app['json.schema'];
    }
}
