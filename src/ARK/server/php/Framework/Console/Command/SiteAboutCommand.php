<?php

/**
 * ARK Site Command.
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

namespace ARK\Framework\Console\Command;

use ARK\ARK;
use ARK\Console\Command\AbstractCommand;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Style\SymfonyStyle;

class SiteAboutCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('site:about')
             ->setDescription('Display information about the site');
    }

    protected function doExecute() : void
    {
        $io = new SymfonyStyle($this->input, $this->output);

        $app = $this->app();
        $site = $app['ark']['site'];

        $this->write('');
        $io->table([], [
            ['<info>Site</>'],
            new TableSeparator(),
            ['Site name', $site],
            ['Site directory', ARK::siteDir($site)],
            [''],
            new TableSeparator(),
            ['<info>System</>'],
            new TableSeparator(),
            ['ARK Version', ARK::version()],
            ['Debug', $this->app('debug') ? 'true' : 'false'],
            ['Cache directory', $app->cacheDir().' (<comment>'.$this->formatFileSize($app->cacheDir()).'</>)'],
            ['Log directory', $app->logDir().' (<comment>'.$this->formatFileSize($app->logDir()).'</>)'],
            [''],
        ]);
    }
}
