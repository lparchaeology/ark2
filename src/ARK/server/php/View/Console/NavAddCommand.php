<?php

/**
 * ARK Nav Add Command
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

namespace ARK\View\Console;

use ARK\Console\ConsoleCommand;
use ARK\Service;
use ARK\View\Command\NavAddMessage;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateItemEntityCommand extends ConsoleCommand
{
    protected function configure()
    {
        $this->setName('view:nav:add')
             ->setDescription('Add a new Nav view element')
             ->addOptionalArgument('element', 'The Nav view element key');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $element = $this->getArgument('element');
        if (!$element) {
            $element = $this->askQuestion("Please enter the new Nav view element key (e.g. 'site_nav_home')");
        }
        $element = strtolower($element);

        $parent = $this->askQuestion("Please enter the parent Nav view element key (e.g. 'site_nav_home', default none)");

        $seq = $this->askQuestion("Please enter the sequence number (e.g. 3)", 0);

        $separator = null;
        $route = null;
        $uri = null;
        $type = $this->askChoice("Please choose the Nav type (Default: route)", ['route', 'uri', 'separator'], 'route');

        $separator = $this->askConfirmation("Please enter if this is a separator the sequence number (e.g. 3)");

        Service::handleCommand(new GenerateItemEntityMessage($module['project'], $module['namespace'], $module['classname']));

        return ConsoleCommand::SUCCESS_CODE;
    }
}
