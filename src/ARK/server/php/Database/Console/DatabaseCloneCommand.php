<?php

/**
 * Ark Clone Database Console Command
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
use ARK\Database\Console\DatabaseCommand;
use Doctrine\DBAL\DBALException;

class DatabaseCloneCommand extends DatabaseCommand
{
    protected function configure()
    {
        $this->setName('database:clone')
             ->setDescription('Clone an existing database')
             ->addOptionalArgument('source', 'The source database server')
             ->addOptionalArgument('database', 'The database to clone')
             ->addOptionalArgument('destination', 'The destination database server')
             ->addOptionalArgument('new_database', 'The new database');
    }

    protected function do()
    {
        $sourceServer = $this->getArgument('source');
        $destinationServer = $this->getArgument('destination');
        $sourceDatabase = $this->getArgument('database');
        $destinationDatabase = $this->getArgument('new_database');

        // Get the Source Server Connection
        if (!$sourceServer) {
            $sourceServer = $this->chooseServer('Please choose the database server to copy from');
        }
        $source = $this->getServerConnection($sourceServer);

        // Get the Source Database Name
        if ($sourceDatabase) {
            if (!$source->databaseExists($sourceDatabase)) {
                $this->write('Source database does not exist!');
                return $this->errorCode();
            }
        } else {
            $sourceDatabase = $this->chooseDatabase($source, 'Please choose the database to clone');
        }

        // Get the Destination Server Connection
        if (!$destinationServer) {
            $destinationServer = $this->chooseServer('Please choose the database server to copy to');
        }
        if ($sourceServer === $destinationServer) {
            $config = $source->config();
            $destination = $this->getConnection($config);
        } else {
            $destination = $this->getServerConnection($destinationServer);
        }

        // Get the Destination Database Name
        if (!$destinationDatabase) {
            $destinationDatabase = $this->askQuestion('Please enter the new database name');
        }
        if ($destination->databaseExists($destinationDatabase)) {
            $this->write('Destination database already exists!');
            return $this->errorCode();
        }

        // Create the Destination Database
        try {
            $destination->createDatabase($destinationDatabase);
        } catch (DBALException $e) {
            $this->writeException("Create database $destinationDatabase failed", $e);
            return $this->errorCode();
        }
        $this->write("Destination database $destinationDatabase created.");

        // Get the Source Database Connection
        $config = $source->config();
        $source->close();
        $config['dbname'] = $sourceDatabase;
        $source = $this->getConnection($config);

        // Get the Destination Database Connection
        $config = $destination->config();
        $destination->close();
        $config['dbname'] = $destinationDatabase;
        $destination = $this->getConnection($config);

        // Create the Destination Schema
        $this->write("Creating database schema, please wait...");
        $schema = $source->schema();
        try {
            $destination->createSchema($schema);
        } catch (DBALException $e) {
            $this->writeException('Create database schema failed', $e);
            return $this->errorCode();
        }
        $this->write("Database schema created.");

        // Copy the data
        $this->write("Copying data, please wait...");
        $source->beginTransaction();
        $destination->executeQuery("SET FOREIGN_KEY_CHECKS=0");
        $destination->beginTransaction();
        try {
            $tables = $schema->getTables();
            foreach ($tables as $table) {
                $name = $table->getName();
                $count = $source->countRows($name);
                $this->write(" * Copying $count rows for table $name...");
                $rows = $source->fetchAllTable($name);
                // TODO Bulk insert?
                foreach ($rows as $row) {
                    $destination->insert($name, $row);
                }
            }
            $destination->commit();
            $destination->executeQuery("SET FOREIGN_KEY_CHECKS=1");
        } catch (DBALException $e) {
            $destination->rollBack();
            $this->writeException('Copy database failed', $e);
            return $this->errorCode();
        }

        // Done!
        $source->close();
        $destination->close();
        $this->write("SUCCESS: Database $sourceDatabase cloned.");
        $this->result = $config;
        return $this->successCode();
    }
}
