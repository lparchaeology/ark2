<?php

/**
 * Ark Clone Database Command
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

namespace ARK\Database\Command;

use ARK\ARK;
use ARK\Database\AdminConnection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;

class DatabaseCloneCommand extends Command
{
    protected function configure()
    {
        $this->setName('database:clone')
             ->setDescription('Clone an existing database')
             ->addArgument('source', InputArgument::OPTIONAL, 'The source database server')
             ->addArgument('database', InputArgument::OPTIONAL, 'The database to clone')
             ->addArgument('destination', InputArgument::OPTIONAL, 'The destination database server')
             ->addArgument('new_database', InputArgument::OPTIONAL, 'The new database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $question = $this->getHelper('question');

        $sourceServer = $input->getArgument('source');
        $destinationServer = $input->getArgument('destination');
        $sourceDatabase = $input->getArgument('database');
        $destinationDatabase = $input->getArgument('new_database');

        $servers = array_keys(ARK::servers());
        $defaultServer = ARK::defaultServerName();

        // Get the Source Config
        if (!$sourceServer) {
            $serverQuestion = new ChoiceQuestion("Please enter the database server to copy from (default: $defaultServer): ", $servers, $defaultServer);
            $serverQuestion->setAutocompleterValues($servers);
            $sourceServer = $question->ask($input, $output, $serverQuestion);
        }
        $sourceConfig = ARK::server($sourceServer);
        $sourceConfig['wrapperClass'] = 'ARK\Database\AdminConnection';

        $passwordQuestion = new Question('Please enter the source server root password: ', '');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $passwordQuestion->setMaxAttempts(3);
        $password = $question->ask($input, $output, $passwordQuestion);
        $sourceConfig['password'] = $password;

        // Get the Source Server Connection
        try {
            $source = DriverManager::getConnection($sourceConfig);
            $source->connect();
        } catch (DBALException $e) {
            $output->writeln('Source root connection failed: '.$e->getCode().' - '.$e->getMessage());
            return false;
        }

        // Get the Source Database Name
        if ($sourceDatabase) {
            if (!$source->databaseExists($sourceDatabase)) {
                $output->writeln('Source database does not exist!');
                return false;
            }
        } else {
            $databases = $source->listDatabases();
            $databaseQuestion = new ChoiceQuestion("Please enter the database to clone: ", $databases);
            $databaseQuestion->setAutocompleterValues($databases);
            $sourceDatabase = $question->ask($input, $output, $databaseQuestion);
        }

        // Get the Destination Config
        if (!$destinationServer) {
            $serverQuestion = new ChoiceQuestion("Please enter the database server to copy to (default: $defaultServer): ", $servers, $defaultServer);
            $serverQuestion->setAutocompleterValues($servers);
            $destinationServer = $question->ask($input, $output, $serverQuestion);
        }
        $destinationConfig = ARK::server($destinationServer);
        $destinationConfig['wrapperClass'] = 'ARK\Database\AdminConnection';

        if ($sourceServer !== $destinationServer) {
            $passwordQuestion = new Question('Please enter the destination server root password: ', '');
            $passwordQuestion->setHidden(true);
            $passwordQuestion->setHiddenFallback(false);
            $passwordQuestion->setMaxAttempts(3);
            $password = $question->ask($input, $output, $passwordQuestion);
        }
        $destinationConfig['password'] = $password;

        // Get the Destination Connection
        try {
            $destination = DriverManager::getConnection($destinationConfig);
            $destination->connect();
        } catch (DBALException $e) {
            $output->writeln('Destination root connection failed: '.$e->getCode().' - '.$e->getMessage());
            return false;
        }

        // Get the Destination Database
        if (!$destinationDatabase) {
            $databaseQuestion = new Question('Please enter the new database name: ', '');
            $destinationDatabase = $question->ask($input, $output, $databaseQuestion);
        }
        if ($destination->databaseExists($destinationDatabase)) {
            $output->writeln('Destination database already exists!');
            return false;
        }

        // Create the Destination Database
        try {
            $destination->createDatabase($destinationDatabase);
        } catch (DBALException $e) {
            $output->writeln("Create database $destinationDatabase failed: ".$e->getCode().' - '.$e->getMessage());
            return false;
        }
        $output->writeln("Destination database $destinationDatabase created.");

        // Get the Source Database Connection
        try {
            $source->close();
            $sourceConfig['dbname'] = $sourceDatabase;
            $source = DriverManager::getConnection($sourceConfig);
            $source->connect();
        } catch (DBALException $e) {
            $output->writeln('Source database connection failed: '.$e->getCode().' - '.$e->getMessage());
            return false;
        }

        // Get the Destination Database Connection
        try {
            $destination->close();
            $destinationConfig['dbname'] = $destinationDatabase;
            $destination = DriverManager::getConnection($destinationConfig);
            $destination->connect();
        } catch (DBALException $e) {
            $output->writeln('Destination database connection failed: '.$e->getCode().' - '.$e->getMessage());
            return false;
        }

        // Create the Destination Schema
        $output->writeln("Creating database schema, please wait...");
        $schema = $source->schema();
        try {
            $destination->createSchema($schema);
        } catch (DBALException $e) {
            $output->writeln("Create database schema failed: ".$e->getCode().' - '.$e->getMessage());
            return false;
        }
        $output->writeln("Database schema created.");

        // Copy the data
        $output->writeln("Copying data, please wait...");
        $source->beginTransaction();
        $destination->executeQuery("SET FOREIGN_KEY_CHECKS=0");
        $destination->beginTransaction();
        try {
            $tables = $schema->getTables();
            foreach ($tables as $table) {
                $name = $table->getName();
                $count = $source->executeQuery("SELECT COUNT(*) FROM $name")->fetch()["COUNT(*)"];
                $output->writeln(" * Copying $count rows for table $name...");
                $rows = $source->fetchAll("SELECT * FROM $name");
                foreach ($rows as $row) {
                    $destination->insert($name, $row);
                }
            }
            $destination->commit();
            $destination->executeQuery("SET FOREIGN_KEY_CHECKS=1");
        } catch (DBALException $e) {
            $destination->rollBack();
            $output->writeln("Copy database failed: ".$e->getCode().' - '.$e->getMessage());
            return false;
        }

        // Done!
        $source->close();
        $destination->close();
        $output->writeln("SUCCESS: Database $sourceDatabase cloned.");
        return true;
    }
}
