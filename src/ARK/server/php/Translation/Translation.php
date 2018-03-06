<?php

/**
 * ARK Translation Namespace.
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

namespace ARK\Translation;

use ARK\ORM\ORM;
use ARK\Service;
use ARK\Translation\Dumper\JsonFileDumper;
use ARK\Translation\Loader\DatabaseLoader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Dumper\XliffFileDumper;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\MessageCatalogue;

class Translation
{
    public function translate($id, $role = null, $parameters = [], $domain = null, $locale = null) : string
    {
        return Service::translation()->translate($id, $role, $parameters, $domain, $locale);
    }

    public function translateChoice($id, int $count, $role = null, $parameters = [], $domain = null, $locale = null) : string
    {
        return Service::translation()->translateChoice($id, $number, $role, $parameters, $domain, $locale);
    }

    public function dump(string $path) : void
    {
        $loader = new DatabaseLoader();
        $xliff = new XliffFileDumper();
        $options = [
            'path' => $path,
            'xliff_version' => '2.0',
        ];
        $languages = Language::findAll();
        // Dump php translations as xliff file per domain and language
        $domains = Domain::findAll();
        foreach ($domains as $domain) {
            foreach ($languages as $language) {
                $catalogue = $loader->load(Service::database(), $language->code(), $domain->id());
                $xliff->dump($catalogue, $options);
            }
        }
        // Dump javascript translations as single json file per language called messages.<lang>.json
        $json = new JsonFileDumper();
        foreach ($languages as $language) {
            $catalogue = $loader->load(Service::database(), $language->code());
            $json->dump($catalogue, $options);
        }
    }

    public function importFiles(Finder $finder, bool $replace = true, callable $chooser = null) : void
    {
        $loader = new XliffFileLoader();
        foreach ($finder as $file) {
            $meta = explode('.', $file->getFilename());
            $domain = Domain::find($meta[0]);
            $language = $meta[1];
            $catalogue = $loader->load($file->getRealPath(), $language, $domain->id());
            self::importCatalogue($catalogue, $domain, $replace, $chooser);
        }
    }

    public function importCatalogue(
        MessageCatalogue $catalogue,
        Domain $domain,
        bool $replace = true,
        callable $chooser = null
    ) : void {
        $defaultRole = Role::find('default');
        $language = $catalogue->getLocale();
        $messages = $catalogue->all($domain->id());
        foreach ($messages as $id => $text) {
            $parts = explode('.', $id);
            $role = Role::find(end($parts));
            if ($role) {
                array_pop($parts);
                $id = implode('.', $parts);
            } else {
                $role = $defaultRole;
            }
            $keyword = Keyword::find($id);
            $setMessage = false;
            if ($keyword === null) {
                $keyword = new Keyword($id, $domain);
                $setMessage = true;
            } else {
                $message = $keyword->message($language, $role);
                if ($message === null) {
                    $setMessage = true;
                } else if ($chooser !== null) {
                    $setMessage = $chooser($keyword, $text, $message->text());
                } else {
                    $setMessage = $replace;
                }
            }
            if ($setMessage) {
                $keyword->setMessage($text, $language, $role);
                ORM::persist($keyword);
            }
        }
    }
}
