<?php

/**
 * ARK Translation Service Provider
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

namespace ARK\Translation;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Provider\TranslationServiceProvider as CoreTranslationServiceProvider;
use ARK\Translation\Command\TranslationAddHandler;
use ARK\Translation\Command\TranslationAddMessage;
use ARK\Translation\Loader\ActorLoader;
use ARK\Translation\Loader\DatabaseLoader;

class TranslationServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container->register(new CoreTranslationServiceProvider());
        $container->extend('translator', function ($translator, $container) {
            $translator->addLoader('database', new DatabaseLoader());
            $translator->addLoader('actor', new ActorLoader());
            foreach ($app['locale_fallbacks'] as $language) {
                $translator->addResource('database', $app['database'], $language);
                $translator->addResource('actor', $app['database'], $language);
            }
            $app->loadTranslationFiles($translator, $app['locale_fallbacks'], $app['dir.site'].'/translations');
            $app->loadTranslationFiles($translator, $app['locale_fallbacks'], $app['dir.site'].'/translations/'.$app['ark']['web']['frontend']);
            return $translator;
        });
        $commands = [
            TranslationAddMessage::class => TranslationAddHandler::class,
        ];
        $container['bus.command.handlers'] = array_merge($container['bus.command.handlers'], $commands);
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
}
