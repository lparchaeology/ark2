<?php

/**
 * ARK Translation Command.
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

namespace ARK\Translation\Console\Command;

use ARK\Console\Command\AbstractCommand;
use ARK\Service;
use ARK\Translation\Dumper\JsonFileDumper;
use ARK\Translation\Loader\DatabaseLoader;
use Symfony\Component\Translation\Dumper\XliffFileDumper;

class TranslationDumpCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('translation:dump')
             ->setDescription('Dump site translations to file');
    }

    protected function doExecute() : void
    {
        $this->write('Loading translations...');
        $loader = new DatabaseLoader();
        $xliff = new XliffFileDumper();
        $json = new JsonFileDumper();
        $options['path'] = Service::siteDir().'/translations';
        foreach (Service::localeFallbacks() as $locale) {
            $this->write('Dumping '.$locale);
            $catalogue = $loader->load(Service::database(), $locale);
            $xliff->dump($catalogue, $options);
            $json->dump($catalogue, $options);
        }
        $this->write('SUCCESS: Dumped site translation files to '.$options['path']);
    }
}
