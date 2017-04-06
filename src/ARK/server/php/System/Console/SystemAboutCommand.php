<?php

/**
 * ARK Debug Route Command
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\System\Console;

use ARK\ARK;
use ARK\Console\AbstractCommand;
use ARK\Service;
use Silex\Application as SilexApplication;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Adapted from Symfony\Bundle\FrameworkBundle\Command\AboutCommand
 *
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class SystemAboutCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('system:about')
             ->setDescription('Display information about the system');
    }

    protected function do()
    {
        $io = new SymfonyStyle($this->input, $this->output);

        $app = $this->app();

        $io->table([], array(

            array('<info>ARK</>'),
            new TableSeparator(),
            array('Version', ARK::version()),
            array('Installation directory', ARK::installDir()),

            new TableSeparator(),
            array('<info>Silex</>'),
            new TableSeparator(),
            array('Version', SilexApplication::VERSION),
            array('Debug', $this->app('debug') ? 'true' : 'false'),
            array('Charset', $this->app('charset')),
            array('Cache directory', ARK::cacheDir().' (<comment>'.self::formatFileSize(ARK::cacheDir()).'</>)'),
            array('Log directory', ARK::logDir().' (<comment>'.self::formatFileSize(ARK::logDir()).'</>)'),

            new TableSeparator(),
            array('<info>Symfony</>'),
            new TableSeparator(),
            array('Version', Kernel::VERSION),
            array('End of maintenance', Kernel::END_OF_MAINTENANCE.(self::isExpired(Kernel::END_OF_MAINTENANCE) ? ' <error>Expired</>' : '')),
            array('End of life', Kernel::END_OF_LIFE.(self::isExpired(Kernel::END_OF_LIFE) ? ' <error>Expired</>' : '')),

            new TableSeparator(),
            array('<info>PHP</>'),
            new TableSeparator(),
            array('Version', PHP_VERSION),
            array('Architecture', (PHP_INT_SIZE * 8).' bits'),
            array('Intl locale', \Locale::getDefault() ?: 'n/a'),
            array('Timezone', date_default_timezone_get().' (<comment>'.(new \DateTime())->format(\DateTime::W3C).'</>)'),
            array('OPcache', extension_loaded('Zend OPcache') && ini_get('opcache.enable') ? 'true' : 'false'),
            array('APCu', extension_loaded('apcu') && ini_get('apc.enabled') ? 'true' : 'false'),
            array('Xdebug', extension_loaded('xdebug') ? 'true' : 'false'),
        ));
    }

    private static function formatFileSize($path)
    {
        if (is_file($path)) {
            $size = filesize($path) ?: 0;
        } else {
            $size = 0;
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS | \RecursiveDirectoryIterator::FOLLOW_SYMLINKS)) as $file) {
                $size += $file->getSize();
            }
        }

        return Helper::formatMemory($size);
    }

    private static function isExpired($date)
    {
        $date = \DateTime::createFromFormat('m/Y', $date);

        return false !== $date && new \DateTime() > $date->modify('last day of this month 23:59:59');
    }
}
