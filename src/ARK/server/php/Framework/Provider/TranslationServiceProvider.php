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

use ARK\ARK;
use ARK\Translation\Console\Command\TranslationAddCommand;
use ARK\Translation\Console\Command\TranslationDumpCommand;
use ARK\Translation\Console\Command\TranslationImportCommand;
use ARK\Translation\Loader\ActorLoader;
use ARK\Translation\Loader\DatabaseLoader;
use ARK\Translation\TranslationService;
use ARK\Translation\Translator;
use Exception;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Api\EventListenerProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\EventListener\TranslatorListener;
use Symfony\Component\Translation\Formatter\MessageFormatter;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Loader\XliffFileLoader;

/**
 * Adapted from Silex\Provider\TranslationServiceProvider.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TranslationServiceProvider implements ServiceProviderInterface, EventListenerProviderInterface
{
    public function register(Container $app) : void
    {
        // Define the real Translator, i.e. not the logging Translator
        $app['translator.default'] = function ($app) {
            $translator = new Translator(
                $app['locale'],
                new MessageFormatter(),
                $app['debug'] ? null : ARK::translationsCacheDir($app['ark']['site']),
                $app['debug']
            );
            $translator->setFallbackLocales($app['locale_fallbacks']);
            $translator->addLoader('array', new ArrayLoader());
            $translator->addLoader('xliff', new XliffFileLoader());
            $translator->addLoader('actor', new ActorLoader());
            if ($app['debug']) {
                $translator->addLoader('database', new DatabaseLoader());
            }

            // Load Validation translations
            if (isset($app['validator'])) {
                $r = new \ReflectionClass('Symfony\Component\Validator\Validation');
                $dir = dirname($r->getFilename()).'/Resources/translations';
                $this->loadTranslationFiles($translator, $dir);
            }

            // Load Form translations
            if (isset($app['form.factory'])) {
                $r = new \ReflectionClass('Symfony\Component\Form\Form');
                $dir = dirname($r->getFilename()).'/Resources/translations';
                $this->loadTranslationFiles($translator, $dir);
            }

            // Load Actor names
            $translator->addResource('actor', $app['database'], $app['locale']);

            // Register default resources
            if ($app['debug']) {
                // In debug mode load direct from the database
                $languages = $this->allLanguages($translator);
                foreach ($languages as $language) {
                    $translator->addResource('database', $app['database'], $language);
                }
            } else {
                // In prod mode load from the site translation files and enable caching
                $this->loadTranslationFiles($translator, $app['dir.site'].'/translations');
                $this->loadTranslationFiles($translator, $app['dir.site'].'/translations/'.$app['ark']['view']['frontend']);
            }

            return $translator;
        };

        // Define the translator to use, by default the real translator, but can be overridden by a logging translator
        $app['translator'] = function ($app) {
            return $app['translator.default'];
        };

        if (isset($app['request_stack'])) {
            $app['translator.listener'] = function ($app) {
                return new TranslatorListener($app['translator'], $app['request_stack']);
            };
        }

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

    private function loadTranslationFiles(Translator $translator, string $dir) : void
    {
        try {
            $finder = new Finder();
            $finder->in($dir)->name('*.xlf');
            $languages = $this->allLanguages($translator);
            foreach ($finder as $file) {
                $parts = explode('.', $file->getFilename());
                $domain = $parts[0];
                if ($domain !== 'validators') {
                    $domain = 'messages';
                }
                $language = $parts[1];
                if (in_array($language, $languages, true)) {
                    $translator->addResource('xliff', $file->getPathname(), $language, $domain);
                }
            }
        } catch (Exception $e) {
        }
    }

    private function allLanguages(Translator $translator) : iterable
    {
        return array_unique(array_merge([$translator->getLocale()], $translator->getFallbackLocales()));
    }
}
