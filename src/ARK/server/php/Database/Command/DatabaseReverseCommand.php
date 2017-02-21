<?php

/**
 * Ark Reverse Engineer Database Command
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

namespace ARK\Database\Command;

use ARK\ARK;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;

class DatabaseReverseCommand extends Command
{
    protected function configure()
    {
        $this->setName('database:reverse')
             ->setDescription('Reverse engineer an existing database as DoctrineXML');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $question = $this->getHelper('question');

        $siteQuestion = new Question('Please enter the site to reverse engineer: ', '');
        $site = $question->ask($input, $output, $siteQuestion);

        $servers = array_keys(ARK::servers());
        $defaultServer = ARK::defaultServerName();
        $serverQuestion = new ChoiceQuestion("Please enter the database server to use (default: $defaultServer): ", $servers, $defaultServer);
        $serverQuestion->setAutocompleterValues($servers);
        $server = $question->ask($input, $output, $serverQuestion);
        $config = ARK::server($server);

        $passwordQuestion = new Question('Please enter the root database password: ', '');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $passwordQuestion->setMaxAttempts(3);
        $password = $question->ask($input, $output, $passwordQuestion);
        $config['password'] = $password;

        $config['wrapperClass'] = 'ARK\Database\AdminConnection';
        $dbprefix = $site.'_ark_';
        $this->reverse($dbprefix, 'core', $config, $output);
        $this->reverse($dbprefix, 'data', $config, $output);
        $this->reverse($dbprefix, 'spatial', $config, $output);
        $this->reverse($dbprefix, 'user', $config, $output);
    }

    private function reverse($prefix, $name, $config, $output)
    {
        // Get the Admin Connection
        $dbname = $prefix.$name;
        $config['dbname'] = $dbname;
        try {
            $admin = DriverManager::getConnection($config);
        } catch (DBALException $e) {
            $output->writeln("Admin configuration failed for $dbname : ".$e->getCode().' - '.$e->getMessage());
            return false;
        }

        // Test the Admin connection
        try {
            $admin->connect();
        } catch (DBALException $e) {
            $output->writeln("Admin connection failed for $dbname : ".$e->getCode().' - '.$e->getMessage());
            return false;
        }

        $path = "../src/ARK/server/schema/database/$name.xml";
        try {
            $admin->extractSchema($path, true);
        } catch (DBALException $e) {
            $output->writeln("FAILED: Extract Schema from database $dbname failed: ".$e->getCode().' - '.$e->getMessage());
            return false;
        }

        $output->writeln("SUCCESS: Schema for $dbname extracted to file $path");
        $admin->close();
        return true;
    }
}
