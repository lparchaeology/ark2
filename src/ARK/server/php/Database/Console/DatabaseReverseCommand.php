<?php

/**
 * Ark Reverse Engineer Database Console Command
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

namespace ARK\Database\Console;

use ARK\ARK;
use ARK\Database\Command\DatabaseCommand;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;

class DatabaseReverseCommand extends DatabaseCommand
{
    protected function configure()
    {
        $this->setName('database:reverse')
             ->setDescription('Reverse engineer an existing database as DoctrineXML');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $site = $this->askQuestion('Please enter the site to reverse engineer');

        $config = $this->chooseServerConfig();
        $dbprefix = $site.'_ark_';
        $this->reverse($dbprefix, 'core', $config);
        $this->reverse($dbprefix, 'data', $config);
        $this->reverse($dbprefix, 'spatial', $config);
        $this->reverse($dbprefix, 'user', $config);
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
