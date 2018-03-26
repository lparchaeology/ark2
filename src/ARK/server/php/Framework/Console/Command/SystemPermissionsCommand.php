<?php

/**
 * ARK System Command.
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
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Filesystem\Filesystem;

class SystemPermissionsCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('system:permissions')
             ->setDescription('Set the system permissions');
    }

    protected function doExecute() : void
    {
        $chown = $this->askQuestion('Please enter the Owner to set');
        $chgrp = $this->askQuestion('Please enter the Group to set');

        $fs = new Filesystem();

        if ($chown) {
            $fs->chown(ARK::installDir(), $chown, true);
        }
        if ($chgrp) {
            $fs->chgrp(ARK::installDir(), $chgrp, true);
        }

        // By default, all files and directories are read-only by the owner/group only
        $this->write(ARK::installDir());
        $fs->chmod(ARK::installDir(), 440, 0000, true);
        // The scripts in bin need to be executble by the owner/group only
        $fs->chmod(ARK::installDir().'/bin', 550, 0000, true);
        // The contents of var need to be writable by the owner/group
        $fs->chmod(ARK::installDir().'/var', 660, 0000, true);

        $sites = ARK::sites();
        foreach ($sites as $site) {
            $siteDir = ARK::siteDir($site);
            // The scripts in bin need to be executble by the owner/group only
            $fs->chmod($siteDir.'/bin', 550, 0000, true);
            // The files need to be writable by the owner/group only
            $fs->chmod($siteDir.'/files', 660, 0000, true);
            // Public needs to be readable by the everyone
            if ($fs->exists($siteDir.'/public')) {
                $fs->chmod($siteDir.'/public', 444, 0000, true);
            } elseif ($fs->exists($siteDir.'/web')) {
                $fs->chmod($siteDir.'/web', 444, 0000, true);
            }
            // The contents of var need to be writable by the owner/group
            $fs->chmod($siteDir.'/translations', 660, 0000, true);
            // The contents of var need to be writable by the owner/group
            $fs->chmod($siteDir.'/var', 660, 0000, true);
        }

        // Frontend assets need to be readable by the everyone
        $frontends = ARK::frontends();
        foreach (array_keys($frontends) as $frontend) {
            $assetDir = ARK::frontendDir($frontends[$frontend], $frontend).'/assets';
            $fs->chgrp($assetDir, 444, 0000, true);
        }
    }

    protected function chmod($fs, string $path, $folder, $file) : void
    {
        if (is_file($path)) {
            $size = filesize($path) ?: 0;
        } else {
            $size = 0;
            $flags = RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::FOLLOW_SYMLINKS;
            $rdi = new RecursiveDirectoryIterator($path, $flags);
            $rii = new RecursiveIteratorIterator($rdi);
            foreach ($rii as $file) {
                if ($file->isDir()) {
                    $fs->chmod($file->getPathname(), $folder, 0000);
                } else {
                    $fs->chmod($file->getPathname(), $file, 0000);
                }
                $size += $file->getSize();
            }
        }
    }
}
