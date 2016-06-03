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

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use ARK\Database\SchemaWriter;

class ReverseCommand extends \Symfony\Component\Console\Command\Command
{
    protected function configure()
    {
        $this->setName('database:reverse')
             ->setDescription('Reverse engineer an existing database as DoctrineXML')
             ->addArgument('database', InputArgument::REQUIRED, 'The database')
             ->addOption('filename', null, InputOption::VALUE_OPTIONAL, 'The file to write the DoctrineXML')
             ->addOption('overwrite', null, InputOption::VALUE_NONE, 'Overwrite the file if it already exists');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $database = $input->getArgument('database');
        $filename = $input->getOption('filename');
        $overwrite = $input->getOption('overwrite');

        $userQuestion = new Question('Please enter the root database user: (root) ', 'root');
        $passwordQuestion = new Question('Please enter the root password: ', '');
        $passwordQuestion->setHidden(true);

        $question = $this->getHelper('question');
        $user = $question->ask($input, $output, $userQuestion);
        $password = $question->ask($input, $output, $passwordQuestion);

        if ($filename && !$overwrite && is_file($filename)) {
            $overwriteQuestion = new ConfirmationQuestion('File already exists, do you want to overwrite this file? (n) ', false);
            $overwrite = $question->ask($input, $output, $overwriteQuestion);
            if (!$overwrite) {
                return;
            }
        }

        $config = array(
            'driver' => 'pdo_mysql',
            'host' => '127.0.0.1',
            'port' => '8889',
            'dbname' => $database,
            'charset' => 'utf8',
            'user' => $user,
            'password' => $password,
        );
        try {
            $conn = \Doctrine\DBAL\DriverManager::getConnection($config);
        } catch (DBALException $e) {
            // DBALException: driverRequired, unknownDriver, invalidDriverClass, invalidWrapperClass(wrapperClass)
            echo 'Admin configuration failed: '.$e->getCode().' - '.$e->getMessage();
            return false;
        }
        // Test the Admin connection
        try {
            $conn->connect();
        } catch (DBALException $e) {
            // PDOException: SQL92 SQLSTATE code
            echo 'Admin connection failed: '.$e->getCode().' - '.$e->getMessage();
            return false;
        }

        if ($filename) {
            SchemaWriter::fromConnection($conn, $filename, $overwrite);
            $output->writeln('Schema written to file '.$filename);
        } else {
            $output->writeln(SchemaWriter::fromConnection($conn));
        }
    }
}
