<?php

/**
 * ARK Translation Service Provider.
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

namespace ARK\Framework\Provider;

use ARK\Translation\Loader\ActorLoader;
use ARK\Translation\Loader\DatabaseLoader;
use ARK\Translation\TranslationService;
use ARK\Translation\Translator;
use DirectoryIterator;
use Exception;
use LogicException;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\EventListenerProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\EventListener\TranslatorListener;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\MessageSelector;

/**
 * Adapted from Silex\Provider\TranslationServiceProvider.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TranslationServiceProvider implements ServiceProviderInterface, EventListenerProviderInterface
{
    public function register(Container $app) : void
    {
        $app['translator'] = function ($app) {
            if (!isset($app['locale'])) {
                throw new LogicException('You must define \'locale\' parameter or register the LocaleServiceProvider to use the TranslationServiceProvider');
            }

            $translator = new Translator($app['locale'], $app['translator.message_selector'], $app['translator.cache_dir'], $app['debug']);
            $translator->setFallbackLocales($app['locale_fallbacks']);
            $translator->addLoader('array', new ArrayLoader());
            $translator->addLoader('xliff', new XliffFileLoader());
            $translator->addLoader('database', new DatabaseLoader());
            $translator->addLoader('actor', new ActorLoader());

            if (isset($app['validator'])) {
                $r = new \ReflectionClass('Symfony\Component\Validator\Validation');
                $file = dirname($r->getFilename()).'/Resources/translations/validators.'.$app['locale'].'.xlf';
                if (file_exists($file)) {
                    $translator->addResource('xliff', $file, $app['locale'], 'validators');
                }
            }

            if (isset($app['form.factory'])) {
                $r = new \ReflectionClass('Symfony\Component\Form\Form');
                $file = dirname($r->getFilename()).'/Resources/translations/validators.'.$app['locale'].'.xlf';
                if (file_exists($file)) {
                    $translator->addResource('xliff', $file, $app['locale'], 'validators');
                }
            }

            // Register default resources
            foreach ($app['translator.resources'] as $resource) {
                $translator->addResource($resource[0], $resource[1], $resource[2], $resource[3]);
            }

            foreach ($app['translator.domains'] as $domain => $data) {
                foreach ($data as $locale => $messages) {
                    $translator->addResource('array', $messages, $locale, $domain);
                }
            }

            foreach ($app['locale_fallbacks'] as $language) {
                $translator->addResource('database', $app['database'], $language);
                $translator->addResource('actor', $app['database'], $language);
            }

            $this->loadTranslationFiles($translator, $app['locale_fallbacks'], $app['dir.site'].'/translations');
            $this->loadTranslationFiles($translator, $app['locale_fallbacks'], $app['dir.site'].'/translations/'.$app['ark']['view']['frontend']);

            return $translator;
        };

        if (isset($app['request_stack'])) {
            $app['translator.listener'] = function ($app) {
                return new TranslatorListener($app['translator'], $app['request_stack']);
            };
        }

        $app['translator.message_selector'] = function () {
            return new MessageSelector();
        };

        $app['translator.resources'] = function ($app) {
            return [];
        };

        $app['translator.domains'] = [];
        $app['locale_fallbacks'] = $app['ark']['locale']['locales'];
        $app['translator.cache_dir'] = null;

        $app['translation'] = function ($app) {
            return new TranslationService($app);
        };
    }

    public function subscribe(Container $app, EventDispatcherInterface $dispatcher) : void
    {
        if (isset($app['translator.listener'])) {
            $dispatcher->addSubscriber($app['translator.listener']);
        }
    }

    private function loadTranslationFiles($translator, array $languages, $dir) : void
    {
        try {
            $files = new DirectoryIterator($dir);
            foreach ($files as $file) {
                $parts = explode('.', $file->getFilename());
                if ($file->getExtension() === 'xlf' && in_array($parts[1], $languages, true)) {
                    $translator->addResource('xliff', $file->getPathname(), $parts[1], $parts[0]);
                }
            }
        } catch (Exception $e) {
        }
    }
}
