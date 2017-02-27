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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\ORM\Console;

use ARK\Console\ConsoleCommand;
use ARK\ORM\Command\GenerateItemEntityMessage;
use ARK\Service;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateItemEntityCommand extends ConsoleCommand
{
    protected function configure()
    {
        $this->setName('orm:entity:generate')
             ->setDescription('Generate ORM Entities for ARK Modules');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $modules = Service::database()->getModules();
        foreach ($modules as $module) {
            $this->write('Generating '.$module['classname']);
            Service::handleCommand(new GenerateItemEntityMessage($module['project'], $module['namespace'], $module['classname']));
        }

        return ConsoleCommand::SUCCESS_CODE;
    }
}
