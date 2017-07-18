<?php

/**
 * Ark Database Console Command
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
use ARK\Console\AbstractCommand;
use ARK\Database\AdminConnection;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;

abstract class DatabaseCommand extends AbstractCommand
{
    protected function chooseServerConnection(string $text = null, string $user = null)
    {
        $server = $this->chooseServer($text);
        return $this->getServerConnection($server, $user);
    }

    protected function getServerConnection(string $server, string $user = null)
    {
        $config = $this->getServerConfig($server, $user);
        return $this->getConnection($config);
    }

    protected function getConnection(array $config)
    {
        if (!isset($config['password'])) {
            $config['password'] = $this->askPassword($config['user']);
        }
        try {
            $connection = DriverManager::getConnection($config);
            $connection->connect();
        } catch (DBALException $e) {
            $this->write('Database connection failed!');
            throw $e;
        }
        return $connection;
    }

    protected function chooseServerConfig(string $text = null, string $user = null)
    {
        $server = $this->chooseServer($text);
        return $this->getServerConfig($server, $user);
    }

    protected function getServerConfig(string $server, string $user = null)
    {
        $config = ARK::server($server);
        $config['wrapperClass'] = 'ARK\Database\AdminConnection';
        if ($user) {
            $config['user'] = $user;
        }
        $config['password'] = $this->askPassword($config['user']);
        return $config;
    }

    protected function chooseServer(string $text = null)
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

    protected function chooseDatabaseConnection(string $text = null, string $user = null)
    {
        $config = $this->chooseDatabaseConfig($text, $user);
        return $this->getConnection($config);
    }

    protected function chooseDatabaseConfig(string $text = null, string $user = null)
    {
        $conn = $this->chooseServerConnection(null, $user);
        $config = $conn->config();
        $config['dbname'] = $this->chooseDatabase($conn, $text);
        $conn->close();
        return $config;
    }

    protected function chooseDatabase(AdminConnection $conn, string $text = null)
    {
        if (!$text) {
            $text = 'Please choose a database';
        }
        return $this->askChoice("$text : ", $conn->listDatabases());
    }
}
