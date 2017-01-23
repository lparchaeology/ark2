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

    public function path($name, $parameters = [], $relative = false)
    {
        return self::$app['url_generator']->generate($name, $parameters, $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    public function url($name, $parameters = [], $schemeRelative = false)
    {
        return self::$app['url_generator']->generate($name, $parameters, $schemeRelative ? UrlGeneratorInterface::NETWORK_PATH : UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public static function templates()
    {
        return self::$app['twig'];
    }

    public function render($view, array $parameters = [], Response $response = null)
    {
        return self::$app->render($view, $parameters, $response);
    }

    public static function renderView($view, array $parameters = [])
    {
        return self::$app->renderView($view, $parameters);
    }

    public static function redirect($url, $status = 302)
    {
        return self::$app->redirect($url, $status);
    }

    public static function forms()
    {
        return self::$app['form.factory'];
    }

    public static function logger()
    {
        return self::$app['logger'];
    }

    public function log($message, array $context = [], $level = Logger::INFO)
    {
        return self::$app->log($message, $context, $level);
    }

    public function logError($message, array $context = [])
    {
        return self::$app->log($message, $context, Logger::ERROR);
    }

    public function logInfo($message, array $context = [])
    {
        return self::$app->log($message, $context, Logger::INFO);
    }

    public function logDebug($message, array $context = [])
    {
        return self::$app->log($message, $context, Logger::DEBUG);
    }

    public static function filesystem()
    {
        return self::$app['filesystem'];
    }

    public static function mailer()
    {
        return self::$app['mailer'];
    }

    public function translate($id, $role = 'default', array $parameters = [], $domain = 'messages', $locale = null)
    {
        return self::$app->translate($id, $role, $parameters, $domain, $locale);
    }

    public function translateChoice($id, $number, $role = 'default', array $parameters = [], $domain = 'messages', $locale = null)
    {
        return self::$app->translateChoice($id, $number, $role, $parameters, $domain, $locale);
    }

    public static function security()
    {
        return self::$app['security'];
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

    public static function serializer()
    {
        return self::$app['serializer'];
    }

    public static function jsonLint()
    {
        return self::$app['json.lint'];
    }

    public static function jsonSchema()
    {
        return self::$app['json.schema'];
    }
}
