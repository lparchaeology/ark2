<?php

/**
 * ARK Database Server Add Command
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

namespace ARK\Console\System\Command;

use ARK\ARK;
use ARK\Console\ProcessTrait;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class DatabaseServerAddCommand extends Command
{
    use ProcessTrait;

    protected function configure()
    {
        $this->setName('database:server:add')
             ->setDescription('Add a new database server')
             ->addArgument('server', InputArgument::REQUIRED, 'The server key');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $question = $this->getHelper('question');

        $server = $input->getArgument('server');

        $path = ARK::sitesDir().'/servers.json';
        if (!file_exists($path)) {
            $servers['default'] = $server;
            $servers['servers']['sqlite']['driver'] = 'pdo_sqlite';
        } elseif (!$servers = json_decode(file_get_contents($path), true)) {
            if (isset($servers['servers'][$server])) {
                $output->writeln("\nFAILED: Server already exists, please choose a new name.");
                return;
            }
        }

        $typeQuestion = new ChoiceQuestion(
            "Please enter the database server type (default: 'mysql'): ",
            ['mysql', 'postgresql'],
            0
        );
        $typeQuestion->setAutocompleterValues(['mysql', 'postgresql']);

        $hostQuestion = new Question("Please enter the database server host (default: 127.0.0.1): ", '127.0.0.1');

        $portQuestion = new Question("Please enter the database server port (default: 3306): ", '3306');

        $defaultQuestion = new ConfirmationQuestion('Do you want to make this the default server? (y/n)', false);

        $rootQuestion = new Question("Please enter the database server root user (default: 'root'): ", 'root');

        $passQuestion = new Question('Please enter the database server root password (this will NOT be stored): ', '');
        $passQuestion->setHidden(true);
        $passQuestion->setHiddenFallback(false);
        $passQuestion->setMaxAttempts(3);

        $type = $question->ask($input, $output, $typeQuestion);
        $host = $question->ask($input, $output, $hostQuestion);
        $port = $question->ask($input, $output, $portQuestion);
        $default = $question->ask($input, $output, $defaultQuestion);
        $root = $question->ask($input, $output, $rootQuestion);
        $password = $question->ask($input, $output, $passQuestion);
        $config = [
            'driver' => "pdo_$type",
            'host' => $host,
            'port' => $port,
            'user' => $root,
        ];

        // Test the Connection
        try {
            $test = [
                'driver' => "pdo_$type",
                'host' => $host,
                'port' => $port,
                'user' => $root,
                'password' => $password,
                'wrapperClass' => 'ARK\\Database\\AdminConnection',
            ];
            $admin = DriverManager::getConnection($test);
            $admin->connect();
            // TODO Check have root permissions
            $admin->close();
        } catch (DBALException $e) {
            $output->writeln("\nFAILED: Invalid server settings: ".$e->getCode().' - '.$e->getMessage());
            return;
        }

        $servers['servers'][$server] = $config;
        if ($default) {
            $servers['default'] = $server;
        }
        file_put_contents($path, json_encode($servers));
        $output->writeln("\nServer created.");
    }
}
