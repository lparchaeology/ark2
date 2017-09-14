<?php

/**
 * ARK Debug Route Command.
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
use Symfony\Component\Filesystem\Filesystem;

/**
 * Adapted from Symfony\Bundle\FrameworkBundle\Command\AboutCommand.
 *
 * @author Roland Franssen <franssen.roland@gmail.com>
 */
class CacheClearCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('cache:clear')
             ->setDescription('Clear the system cache');
    }

    protected function doExecute() : void
    {
        $app = $this->app();

        $fs = new Filesystem();

        $all = true;
        $cacheDir = ARK::cacheDir();
        // Check for sub-directory only if --all/-a option wasn't passed to command
        if (!$all && ($dir = $this->input->getOption('dir'))) {
            $cacheSubDir = $cacheDir.DIRECTORY_SEPARATOR.$dir;
            if (!$fs->exists($cacheSubDir)) {
                $msg = sprintf('Directory "%s" does not exist under cache directory', $dir);
                // Only explicitely specified and non-existing paths throws exception
                if ($dir !== 'twig') {
                    throw new \InvalidArgumentException($msg);
                }
                // For default dir (twig) only display message and end command execution

                $this->output->writeln($msg.', nothing to do!');
                return;
            }
            $cacheDir = $cacheSubDir;
        }
        $this->output->writeln(sprintf('Clearing <comment>%s</comment>', realpath($cacheDir)));
        // Create recursive iterator for directory structure, with custom filter (callback) that keeps "dotfiles" (like .gitignore)
        $deleteIterator = new \RecursiveIteratorIterator(
            new \RecursiveCallbackFilterIterator(
                new \RecursiveDirectoryIterator($cacheDir, \FilesystemIterator::SKIP_DOTS),
                function ($fileInfo, $key, $iterator) {
                    // Only accept entries that do NOT start with an .
                    return substr($fileInfo->getFilename(), 0, 1) !== '.';
                }
            ),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        $toDelete = \iterator_count($deleteIterator);
        if ($toDelete > 0) {
            $fs->remove($deleteIterator);
            $this->output->writeln(sprintf('Deleted <info>%s</info> file%s', $toDelete, $toDelete > 1 ? 's' : null));
        } else {
            $this->output->writeln('No files to delete!');
        }
    }
}
