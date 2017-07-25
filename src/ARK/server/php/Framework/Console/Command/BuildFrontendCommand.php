<?php

/**
 * ARK Build Console Command
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
 */

namespace ARK\Framework\Console\Command;

use ARK\ARK;
use ARK\Framework\Console\ProcessTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class BuildFrontendCommand extends Command
{
    use ProcessTrait;

    protected $name = 'all';
    protected $command = 'build';
    protected $description = 'Build an ARK frontend. (Args: frontend)';

    protected function configure()
    {
        $this->setName('frontend:'.$this->name)
             ->setDescription($this->description)
             ->addArgument('frontend', InputArgument::REQUIRED, 'The name of the frontend');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $frontend = $input->getArgument('frontend');
        $config = json_decode(file_get_contents(ARK::installDir()."/build/frontends/$frontend/config.json"), true);
        $namespace = $config['namespace'];
        $output->writeln('Runnning build, please wait...');
        $this->runProcess("npm run $this->command -- --namespace $namespace --frontend $frontend", $output);
    }
}