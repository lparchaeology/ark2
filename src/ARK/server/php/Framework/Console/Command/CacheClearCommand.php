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
use Symfony\Component\Filesystem\Filesystem;

class CacheClearCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('cache:clear')
             ->setDescription('Clear the system cache')
             ->addOptionalArgument('cache', 'The specific cache to clear, e.g. twig or doctrine');
    }

    protected function doExecute() : void
    {
        $fs = new Filesystem();
        $cacheDir = $this->app()->cacheDir();
        $caches = ARK::dirList($cacheDir);
        $cache = $this->input->getArgument('cache');
        if ($cache) {
            if (!in_array($cache, $caches, true)) {
                $this->write("FAILURE: Cache $cache does not exist");
                return;
            }
            $caches = [$cache];
        }
        foreach ($caches as $cache) {
            $paths = ARK::pathList($cacheDir.'/'.$cache, true);
            $fs->remove($paths);
        }
        $this->write('SUCCESS: Cache cleared');
    }
}
