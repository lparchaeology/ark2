<?php

/**
 * Ark Database Console Command.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Database\Console\Command;

use ARK\ARK;
use ARK\Console\Command\AbstractCommand;
use ARK\Database\AdminConnection;
use ARK\Database\Connection;
use ARK\Database\Database;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Symfony\Component\Console\Question\ChoiceQuestion;

abstract class DatabaseCommand extends AbstractCommand
{
    protected function confirmCommand(Connection $conn, string $text) : bool
    {
        $db = $conn->getDatabase();
        $regex = "/$db/i";
        $this->write("WARNING: $text");
        $confirm = $this->askConfirmation("To confirm, please type in the database name ($db)", false, false, $regex);
        if (!$confirm) {
            $this->write('FAILED: Database name does not match.');
        }
        return $confirm;
    }

    protected function chooseSiteConnection(string $user = null) : Connection
    {
        $site = $this->askSite();
        $connections = ARK::siteDatabaseConfig($site, true);
        $db = $this->askChoice('Please choose the site database:', array_keys($connections));
        return $this->getSiteConnection($site, $db, $user);
    }

    protected function getSiteConnection(string $site, string $db, string $user = null) : Connection
    {
        $connections = ARK::siteDatabaseConfig($site, true);
        $types = $connections['types'] ?? [];
        $this->loadTypes($types);
        $config = $connections[$db];
        if ($user) {
            $config['user'] = $user;
            $config['password'] = null;
        }
        return $this->getConnection($config);
    }

    protected function chooseServerConnection(string $text = null, string $user = null) : Connection
    {
        $server = $this->chooseServer($text);
        return $this->getServerConnection($server, $user);
    }

    protected function getServerConnection(string $server, string $user = null) : Connection
    {
        $config = $this->getServerConfig($server, $user);
        return $this->getConnection($config);
    }

    protected function getConnection(iterable $config) : Connection
    {
        $config['password'] = $config['password'] ?? $this->askPassword($config['user']);
        try {
            $connection = DriverManager::getConnection($config);
            $connection->connect();
        } catch (DBALException $e) {
            $this->write('Database connection failed!');
            throw $e;
        }
        return $connection;
    }

    protected function loadTypes($types = []) : void
    {
        $app = $this->app();
        if (!isset($app['dbs.types'])) {
            $types = array_merge($app['dbs.types.default'], $app['dbs.types.spatial'], $types);
            foreach ($types as $name => $class) {
                Database::setType($name, $class);
            }
            $app['dbs.types'] = $types;
        }
    }

    protected function chooseServerConfig(string $text = null, string $user = null) : iterable
    {
        $server = $this->chooseServer($text);
        return $this->getServerConfig($server, $user);
    }

    protected function getServerConfig(string $server, string $user = null) : iterable
    {
        $config = ARK::server($server);
        $config['wrapperClass'] = AdminConnection::class;
        if ($user) {
            $config['user'] = $user;
        }
        $config['password'] = $this->askPassword($config['user']);
        $types = $configs['types'] ?? [];
        $this->loadTypes($types);
        return $config;
    }

    protected function chooseServer(string $text = null) : string
    {
        if (!$text) {
            $text = 'Please choose the database server to use';
        }
        $server = ARK::defaultServerName();
        $text = "$text (default: $server) : ";
        $servers = ARK::serverNames();
        $question = new ChoiceQuestion($text, $servers, $server);
        $question->setAutocompleterValues($servers);
        $server = $this->ask($question);
        return $server;
    }

    protected function chooseDatabaseConnection(string $text = null, string $user = null) : Connection
    {
        $config = $this->chooseDatabaseConfig($text, $user);
        return $this->getConnection($config);
    }

    protected function chooseDatabaseConfig(string $text = null, string $user = null) : iterable
    {
        $conn = $this->chooseServerConnection(null, $user);
        $config = $conn->config();
        $config['dbname'] = $this->chooseDatabase($conn, $text);
        $conn->close();
        return $config;
    }

    protected function chooseDatabase(AdminConnection $conn, string $text = null) : string
    {
        if (!$text) {
            $text = 'Please choose a database';
        }
        return $this->askChoice("$text : ", $conn->listDatabases());
    }

    protected function createMigrationConfiguration(AdminConnection $conn, iterable $conf = []) : string
    {
        $config = new Configuration($conn, $conf['migrations.output_writer']);
        $config->setMigrationsDirectory($conf['directory']);
        $config->setName($conf['name'] ?? 'ARK');
        $config->setMigrationsNamespace($conf['namespace'] ?? 'ARK\Database\Migrations');
        $config->setMigrationsTableName($conf['table'] ?? 'ark_migrations');
        $config->registerMigrationsFromDirectory($conf['directory']);
        return $config;
    }
}
