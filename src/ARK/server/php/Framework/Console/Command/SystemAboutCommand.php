<?php

/**
 * ARK Debug Route Command.
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

namespace ARK\Framework\Console\Command;

use ARK\ARK;
use ARK\Console\Command\AbstractCommand;
use DateTime;
use Locale;
use Silex\Application;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Adapted from Symfony\Bundle\FrameworkBundle\Command\AboutCommand.
 *
 * @author Roland Franssen <franssen.roland@gmail.com>
 * @license MIT
 */
class SystemAboutCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('system:about')
             ->setDescription('Display information about the system');
    }

    protected function doExecute() : void
    {
        $io = new SymfonyStyle($this->input, $this->output);

        $this->write('');
        $io->table([], [
            ['<info>ARK</>'],
            new TableSeparator(),
            ['Version', ARK::version()],
            ['Installation directory', ARK::installDir()],
            [''],
            new TableSeparator(),
            ['<info>Silex</>'],
            new TableSeparator(),
            ['Version', Application::VERSION],
            ['Debug', $this->app('debug') ? 'true' : 'false'],
            ['Charset', $this->app('charset')],
            ['Cache directory', ARK::cacheDir().' (<comment>'.$this->formatFileSize(ARK::cacheDir()).'</>)'],
            ['Log directory', ARK::logDir().' (<comment>'.$this->formatFileSize(ARK::logDir()).'</>)'],
            [''],
            new TableSeparator(),
            ['<info>Symfony</>'],
            new TableSeparator(),
            ['Version', Kernel::VERSION],
            ['End of maintenance', Kernel::END_OF_MAINTENANCE.($this->isExpired(Kernel::END_OF_MAINTENANCE) ? ' <error>Expired</>' : '')],
            ['End of life', Kernel::END_OF_LIFE.($this->isExpired(Kernel::END_OF_LIFE) ? ' <error>Expired</>' : '')],
            [''],
            new TableSeparator(),
            ['<info>PHP</>'],
            new TableSeparator(),
            ['Version', PHP_VERSION],
            ['Architecture', (PHP_INT_SIZE * 8).' bits'],
            ['Locale', Locale::getDefault() ?: 'n/a'],
            ['Timezone', date_default_timezone_get().' (<comment>'.(new \DateTime())->format(\DateTime::W3C).'</>)'],
            ['OPcache', extension_loaded('Zend OPcache') && ini_get('opcache.enable') ? 'true' : 'false'],
            ['APCu', extension_loaded('apcu') && ini_get('apc.enabled') ? 'true' : 'false'],
            ['Xdebug', extension_loaded('xdebug') ? 'true' : 'false'],
            ['Intl', extension_loaded('intl') ? 'true' : 'false'],
            ['GD', extension_loaded('gd') ? 'true' : 'false'],
            ['ImageMagick', extension_loaded('imagick') ? 'true' : 'false'],
            [''],
        ]);
    }

    private function isExpired($date)
    {
        $date = DateTime::createFromFormat('m/Y', $date);
        return $date !== false && new DateTime() > $date->modify('last day of this month 23:59:59');
    }
}
