<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Console/Command/CreateArkCommand.php
*
* Ark Database
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Console/Command/CreateArkCommand.php
* @since      2.0
*/

namespace ARK\Console\Command;

use ARK\Database\Database;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateArkCommand extends \Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this->setName('ark:create')
             ->setDescription('Create a new ARK instance')
             ->addArgument('instance', InputArgument::REQUIRED, 'The ARK instance key')
             ->addOption('file', null, InputOption::VALUE_OPTIONAL, 'A config file to use for the new instance');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $instance = $input->getArgument('instance');

        $userQuestion = new Question('Please enter the root database user: ', 'root');
        $passwordQuestion = new Question('Please enter the root password: ', '');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $passwordQuestion->setMaxAttempts(3);

        $question = $this->getHelper('question');
        $user = $question->ask($input, $output, $userQuestion);
        $password = $question->ask($input, $output, $passwordQuestion);

        $db = new Database();
        if ($db->createInstance($instance, $user, $password)) {
            $output->writeln('ARK instance created.');
        } else {
            $output->writeln("\nFAILED: ARK instance not created.");
        }
    }
}
