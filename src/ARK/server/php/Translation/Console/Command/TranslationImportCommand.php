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
use ARK\Translation\Keyword;

class TranslationImportCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('translation:import')
             ->setDescription('Import site translations to database');
    }

    protected function doExecute() : void
    {
        $source = $this->askChoice(
            'Do you want to import the site translations or a separate file',
            ['site', 'file'],
            'site'
        );
        if ($source === 'file') {
            $path = $this->askFilePath('Please choose the .xlf file(s) to import');
        }
        $policies = [
            'ask' => 'Always ask which message to use',
            'import' => 'Always use the imported message',
            'database' => 'Always use the database message',
        ];
        $policy = $this->askChoice(
            'Please choose the policy to apply when an imported message already exists in the database',
            $policies,
            'ask'
        );
        if ($source === 'site') {
            if ($policy === 'ask') {
                Service::translation()->import(false, [$this, 'askReplace']);
            } else {
                Service::translation()->import($policy === 'import');
            }
        } else {
            $finder = new Finder();
            $finder->in($path)->name('*.xlf');
            if ($policy === 'ask') {
                Translation::importFiles($finder, false, [$this, 'askReplace']);
            } else {
                Translation::importFiles($finder, $policy === 'import');
            }
        }
        ORM::flush();
        $this->write('SUCCESS: Imported translation file(s)');
    }

    public function askReplace(Keyword $key, string $import, string $existing) : bool
    {
        if ($import === $existing) {
            return false;
        }
        $this->write("\nKeyword ".$key->id().' differs:');
        $this->write('  Import = '.$import);
        $this->write('  Database = '.$existing);
        $choice = $this->askChoice("\nPlease choose the message to use", ['import', 'database'], 'import');
        return $choice === 'import';
    }
}
