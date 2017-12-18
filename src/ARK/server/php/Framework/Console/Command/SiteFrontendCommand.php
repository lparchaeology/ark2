<?php

/**
 * ARK Console Command.
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

class SiteFrontendCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('site:frontend')
             ->setDescription('Install or replace a frontend. WARNING: Will delete the old frontend!')
             ->addRequiredArgument('site', 'The site key')
             ->addOptionalArgument('frontend', 'The site frontend (default: core)', 'core');
    }

    protected function doExecute() : void
    {
        $site = $this->getArgument('site');
        $frontend = $this->getArgument('frontend');
        $namespace = null;

        $frontends = ARK::frontends();
        if ($frontend) {
            if (!in_array($frontend, array_keys($frontends), true)) {
                $this->write("\nFAILED: Frontend $frontend not found, are you sure you built it?");
                return;
            }
        } else {
            $frontend = $this->askChoice('Please enter the frontend to use', array_keys($frontends), 'core');
        }

        $symlink = $this->askChoice('Do you want to link or copy the frontend source folder?', ['link', 'copy'], 'link');

        if (is_dir(ARK::siteDir($site))) {
            $refresh = $this->askConfirmation('Site folder already exists, refresh the site?', false);
        }

        // TODO Move to Bus Command
        // Inputs: Site, Frontend, Symlink = link, Refresh = false
        $siteDir = ARK::siteDir($site);
        $templatesDir = ARK::templatesDir($site, $frontend);
        $translationsDir = ARK::translationsDir($site, $frontend);
        $assetsDir = ARK::assetsDir($site, $frontend);
        $srcDir = ARK::frontendDir($frontends[$frontend], $frontend);

        $fs = new Filesystem();
        if (!$fs->exists($siteDir)) {
            $fs->mkdir($siteDir);
            $fs->mkdir($siteDir.'/bin');
            $fs->mkdir($siteDir.'/config');
            $fs->mkdir($siteDir.'/files');
            $fs->mkdir($siteDir.'/files/download');
            $fs->mkdir($siteDir.'/files/upload');
            $fs->mkdir($siteDir.'/files/tmp');
            $fs->mkdir($siteDir.'/files/data');
            $fs->mkdir($siteDir.'/files/cache');
            $fs->mkdir($siteDir.'/schema');
            $fs->mkdir($siteDir.'/public');
            $fs->mirror($srcDir.'/bin', $siteDir.'/bin');
            $fs->mirror($srcDir.'/config', $siteDir.'/config');
            $fs->mirror($srcDir.'/public', $siteDir.'/public');
        } elseif ($refresh) {
            $fs->mirror($srcDir.'/bin', $siteDir.'/bin');
            $fs->mirror($srcDir.'/public', $siteDir.'/public');
        }
        if ($fs->exists($templatesDir)) {
            $fs->remove($templatesDir);
        }
        if ($fs->exists($translationsDir)) {
            $fs->remove($translationsDir);
        }
        if ($fs->exists($assetsDir)) {
            $fs->remove($assetsDir);
        }

        if (mb_strtolower($symlink) === 'copy') {
            $fs->mirror($srcDir.'/templates', $templatesDir);
            $fs->mirror($srcDir.'/translations', $translationsDir);
            $fs->mirror($srcDir.'/assets', $assetsDir);
        } else {
            $fs->symlink($srcDir.'/templates', $templatesDir, true);
            $fs->symlink($srcDir.'/translations', $translationsDir, true);
            $fs->symlink($srcDir.'/assets', $assetsDir, true);
        }

        umask(0000);
        $fs->mkdir($siteDir.'/var');
        $fs->mkdir($siteDir.'/var/cache');
        $fs->mkdir($siteDir.'/var/cache/doctrine');
        $fs->mkdir($siteDir.'/var/cache/profiler');
        $fs->mkdir($siteDir.'/var/cache/twig');
        $fs->mkdir($siteDir.'/var/log');
    }
}
