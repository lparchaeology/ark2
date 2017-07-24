<?php

/**
 * ARK Database Server Add Console Command
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
 */

namespace ARK\Database\Console;

use ARK\ARK;
use ARK\Database\Console\DatabaseCommand;
use ARK\Framework\Console\ProcessTrait;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;

class DatabaseServerAddCommand extends DatabaseCommand
{
    use ProcessTrait;

    protected function configure()
    {
        $this->setName('database:server:add')
             ->setDescription('Add a new database server')
             ->addOptionalArgument('server', 'The server key');
    }

    protected function doExecute()
    {
        $server = $this->getArgument('server');
        if (!$server) {
            $server = $this->askQuestion('Please enter the new server key');
        }

        // Check the current servers
        $servers = ARK::serversConfig();
        if (!$servers) {
            $servers['default'] = $server;
            $servers['servers']['sqlite']['driver'] = 'pdo_sqlite';
        } elseif (isset($servers['servers'][$server])) {
            $output->writeln("\nFAILED: Server already exists, please choose a new name.");
            return $this->errorCode();
        }

        // Get the new server details
        $type = $this->askChoice('Please enter the database server type', ['mysql', 'postgresql'], 'mysql');
        $host = $this->askQuestion('Please enter the database server host', '127.0.0.1');
        $port = $this->askQuestion('Please enter the database server port', '3306');
        $default = $this->askConfirmation('Do you want to make this the default server?', false);
        $root = $this->askQuestion('Please enter the database server root user', 'root');
        $password = $this->askPassword($root);

        // Test the new server
        $config = [
            'server' => $server,
            'driver' => "pdo_$type",
            'host' => $host,
            'port' => $port,
            'user' => $root,
            'password' => $password,
            'wrapperClass' => 'ARK\Database\AdminConnection',
        ];
        $admin = $this->getConnection($config);
        // TODO Check have root permissions
        $admin->close();

        // Save the new server
        unset($config['password']);
        unset($config['wrapperClass']);
        $servers['servers'][$server] = $config;
        if ($default) {
            $servers['default'] = $server;
        }
        file_put_contents(ARK::serversPath(), json_encode($servers));
        $this->result = $server;
        $this->write("\nServer $server created.");
        return $this->successCode();
    }
}
