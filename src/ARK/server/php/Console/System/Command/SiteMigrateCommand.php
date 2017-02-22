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

namespace ARK\Console\System\Command;

use ARK\ARK;
use ARK\Console\ProcessTrait;
use ARK\Database\Command\DatabaseCommand;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class SiteMigrateCommand extends DatabaseCommand
{
    use ProcessTrait;

    protected function configure()
    {
        $this->setName('site:migrate')
             ->setDescription('Migrate an ARK 1.2 site');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        // Ask if into new or existing
        $choices = ['New', 'Existing'];
        $question = new ChoiceQuestion("Do you want to migrate to a new site or an existing site?", $choices, null);
        $question->setAutocompleterValues($choices);
        $migrate = $this->query->ask($this->input, $this->output, $question);

        // If new, create by calling create
        if (strtolower($migrate) == 'new') {
            $question = new Question("Please enter the new site name (e.g. 'mysite'): ", '');
            $site = $this->query->ask($this->input, $this->output, $question);
            $command = $this->getApplication()->find('site:create');
            $arguments = new ArrayInput([
                'site' => strtolower($site),
            ]);
            $returnCode = $command->run($arguments, $this->output);
            // get the site
        } else {
            // get the site
        }

        // Clone old database
        $command = $this->getApplication()->find('database:clone');
        $arguments = new ArrayInput([
            'site' => strtolower($site),
        ]);
        $returnCode = $command->run($arguments, $this->output);

        // Do any fixes?

        // Get clone and new database connections
        // Set up modules in new, loop through list asking required details, choose schema, etc, create data tables

        // Copy items
        // Copy fragments

        // Done!
    }
}
