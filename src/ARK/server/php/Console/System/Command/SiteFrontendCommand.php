<?php

/**
 * ARK Console Command
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

namespace ARK\Console\System\Command;

use ARK\ARK;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;

class SiteFrontendCommand extends Command
{
    protected function configure()
    {
        $this->setName('site:frontend')
             ->setDescription('Install or replace a frontend. WARNING: Will delete the old frontend!')
             ->addArgument('site', InputArgument::REQUIRED, 'The site key')
             ->addArgument('frontend', InputArgument::OPTIONAL, 'The site frontend (default: core)', 'core');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $site = $input->getArgument('site');
        $frontend= $input->getArgument('frontend');
        $namespace = null;
        $question = $this->getHelper('question');

        foreach (scandir('../src') as $dir) {
            if ($dir != '.' && $dir != '..' && is_dir("../src/$dir/frontend/$frontend")) {
                $namespace = $dir;
                break;
            }
        }
        if (!$namespace) {
            $output->writeln("\nFAILED: Frontend $frontend not found, are you sure you built it?");
            return;
        }

        $siteDir = ARK::sitesDir().'/'.$site;
        $templatesDir = $siteDir.'/templates/'.$frontend;
        $translationsDir = $siteDir.'/translations/'.$frontend;
        $assetsDir = $siteDir.'/web/assets/'.$frontend;
        $srcDir = ARK::installDir().'/src/'.$namespace.'/frontend/'.$frontend;

        $fs = new Filesystem();
        if (!$fs->exists($siteDir)) {
            $fs->mkdir($siteDir);
            $fs->mkdir($siteDir.'/bin');
            $fs->mkdir($siteDir.'/files');
            $fs->mkdir($siteDir.'/files/download');
            $fs->mkdir($siteDir.'/files/upload');
            $fs->mkdir($siteDir.'/files/tmp');
            $fs->mkdir($siteDir.'/files/data');
            $fs->mkdir($siteDir.'/files/thumbs');
            $fs->mkdir($siteDir.'/schema');
            $fs->mirror($srcDir.'/bin', $siteDir.'/bin');
            $fs->mirror($srcDir.'/config', $siteDir.'/config');
            $fs->mirror($srcDir.'/web', $siteDir.'/web');
        } else {
            $refreshQuestion = new ConfirmationQuestion('Site folder already exists, refresh the site? (default: n):', false);
            $refresh = $question->ask($input, $output, $refreshQuestion);
            if ($refresh) {
                $fs->mirror($srcDir.'/bin', $siteDir.'/bin');
                $fs->mirror($srcDir.'/config', $siteDir.'/config');
                $fs->mirror($srcDir.'/web', $siteDir.'/web');
            }
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

        $linkQuestion = new Question('Do you want to copy or link the frontend source folder? (default: link) ', 'link');
        $symlink = strtolower($question->ask($input, $output, $linkQuestion));
        if ($symlink == 'copy') {
            $fs->mirror($srcDir.'/templates', $templatesDir);
            $fs->mirror($srcDir.'/translations', $translationsDir);
            $fs->mirror($srcDir.'/assets', $assetsDir);
        } else {
            $fs->symlink($srcDir.'/templates', $templatesDir, true);
            $fs->symlink($srcDir.'/translations', $translationsDir, true);
            $fs->symlink($srcDir.'/assets', $assetsDir, true);
        }
    }
}
