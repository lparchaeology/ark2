<?php

/**
 * ARK Translation Service Provider.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework\Provider;

use ARK\Translation\Console\Command\TranslationAddCommand;
use ARK\Translation\Console\Command\TranslationDumpCommand;
use ARK\Translation\Console\Command\TranslationImportCommand;
use ARK\Translation\Loader\ActorLoader;
use ARK\Translation\Loader\DatabaseLoader;
use ARK\Translation\TranslationService;
use ARK\Translation\Translator;
use Exception;
use LogicException;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\EventListenerProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Finder\Finder;
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

            $translator = new Translator(
                $app['locale'],
                $app['translator.message_selector'],
                $app['translator.cache_dir'],
                $app['debug']
            );
            $translator->setFallbackLocales($app['locale_fallbacks']);
            $translator->addLoader('array', new ArrayLoader());
            $translator->addLoader('xliff', new XliffFileLoader());
            $translator->addLoader('actor', new ActorLoader());
            if ($app['debug']) {
                $translator->addLoader('database', new DatabaseLoader());
            }

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
                $translator->addResource('actor', $app['database'], $language);
                if ($app['debug']) {
                    $translator->addResource('database', $app['database'], $language);
                } else {
                    $this->loadTranslationFiles($translator, $app['locale_fallbacks'], $app['dir.site'].'/translations');
                    $this->loadTranslationFiles(
                        $translator,
                        $app['locale_fallbacks'],
                        $app['dir.site'].'/translations/'.$app['ark']['view']['frontend']
                    );
                }
            }

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
        $app['translator.cache_dir'] = null;

        $app->addCommands([
            TranslationAddCommand::class,
            TranslationDumpCommand::class,
            TranslationImportCommand::class,
        ]);

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
            $finder = new Finder();
            $finder->in($dir)->name('*.xlf');
            foreach ($finder as $file) {
                $parts = explode('.', $file->getFilename());
                $language = $parts[1];
                if (in_array($language, $languages, true)) {
                    $translator->addResource('xliff', $file->getPathname(), $language, 'messages');
                }
            }
        } catch (Exception $e) {
        }
    }
}
