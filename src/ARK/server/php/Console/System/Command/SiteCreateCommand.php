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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Console\System\Command;

use ARK\ARK;
use ARK\ConsoleApplication;
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
use Symfony\Component\Console\Question\Question;

class SiteCreateCommand extends Command
{
    use ProcessTrait;

    private $input = null;
    private $output = null;
    private $question = null;
    private $drivers = ['pdo_mysql', 'pdo_pgsql', 'pdo_sqlite'];

    protected function configure()
    {
        $this->setName('site:create')
             ->setDescription('Create a new site')
             ->addArgument('site', InputArgument::REQUIRED, 'The site key');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->question = $this->getHelper('question');

        $site = $this->input->getArgument('site');

        $frontends = [];
        foreach (scandir(ARK::installDir().'/src') as $namespace) {
            if ($namespace != '.' && $namespace != '..' && is_dir(ARK::installDir()."/src/$namespace/frontend")) {
                foreach (scandir(ARK::installDir()."/src/$namespace/frontend") as $dir) {
                    if ($dir != '.' && $dir != '..' && is_dir(ARK::installDir()."/src/$namespace/frontend/$dir")) {
                        $frontends[] = $dir;
                    }
                }
            }
        }

        $frontendQuestion = new ChoiceQuestion("Please enter the frontend to use (default: core): ", $frontends, 'core');
        $frontendQuestion->setAutocompleterValues($frontends);
        $frontend = $this->question->ask($this->input, $this->output, $frontendQuestion);

        $servers = array_keys(ARK::servers());
        $defaultServer = ARK::defaultServerName();

        $serverQuestion = new ChoiceQuestion("Please enter the database server to use (default: $defaultServer): ", $servers, $defaultServer);
        $serverQuestion->setAutocompleterValues($servers);
        $server = $this->question->ask($this->input, $this->output, $serverQuestion);
        $config = ARK::server($server);

        $passwordQuestion = new Question('Please enter the root database password: ', '');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);
        $passwordQuestion->setMaxAttempts(3);
        $password = $this->question->ask($this->input, $this->output, $passwordQuestion);
        $config['password'] = $password;

        //$adminEmailQuestion = new Question('Please enter the Site Admin User email: ', '');
        //$adminPasswordQuestion = new Question('Please enter the Site Admin User password: ', '');
        //$adminEmail = $this->question->ask($this->input, $this->output, $adminEmailQuestion);
        //$adminPasswordQuestion->setHidden(true);
        //$adminPassword = $this->question->ask($this->input, $this->output, $adminPasswordQuestion);

        if ($this->createInstance($site, $config)) {
            $this->output->writeln('Site database created.');
            $command = $this->getApplication()->find('site:frontend');
            $arguments = new ArrayInput([
                'site' => $site,
                'frontend' => $frontend,
            ]);
            $returnCode = $command->run($arguments, $this->output);
            $this->output->writeln('Site folder created.');
            $this->output->writeln('Please add an Admin User from the Site Admin Console.');

            /* TODO Need new Application with full DB comnnection created to do this, use Command Bus?
            $admin = $this->app['user.manager']->create($adminEmail, $adminPassword);
            $admin->setEnabled(true);
            $admin->addRole('ROLE_ADMIN');
            $this->app['user.manager']->save($admin);
            $this->output->writeln('ARK admin user created.');
            */
        } else {
            $this->output->writeln("\nFAILED: ARK site database not created.");
        }
    }

    // TODO Make a Command via the Command Bus
    private function createInstance($site, $config)
    {
        $config['wrapperClass'] = 'ARK\\Database\\AdminConnection';
        $dbprefix = $site.'_ark_';
        $dbuser = $dbprefix.'user';
        // TODO And change the password!
        $dbpass = $dbprefix.'pass';

        // Check only supported platfroms
        if (!in_array($config['driver'], $this->drivers)) {
            $this->output->writeln('Invalid or unsupported DBAL driver '.$config['driver']);
            return false;
        }

        // Get the Admin Connection
        try {
            $admin = DriverManager::getConnection($config);
        } catch (DBALException $e) {
            $this->output->writeln('Admin configuration failed: '.$e->getCode().' - '.$e->getMessage());
            return false;
        }

        // Test the Admin connection
        try {
            $admin->connect();
        } catch (DBALException $e) {
            $this->output->writeln('Admin connection failed: '.$e->getCode().' - '.$e->getMessage());
            return false;
        }

        // Add the restricted database user to server
        if ($admin->userExists($dbuser)) {
            $this->output->writeln('User already exists, continuing...');
        } else {
            try {
                $admin->createUser($dbuser, $dbpass);
            } catch (DBALException $e) {
                $this->output->writeln('Add user to database server failed: '.$e->getCode().' - '.$e->getMessage());
                return false;
            }
        }

        $actions = [];
        // Create the databases
        foreach (['core', 'data', 'user'] as $db) {
            $dbname = $dbprefix.$db;
            $action = 'new';

            // Check database doesn't already exist
            if ($admin->databaseExists($dbname)) {
                $options = ['keep', 'drop', 'stop'];
                $keepQuestion = new ChoiceQuestion(
                    "The database $dbname already exists on server, do you want to do with it? (default: keep): ",
                    $options,
                    'keep'
                );
                $keepQuestion->setAutocompleterValues($options);
                $action = $this->question->ask($this->input, $this->output, $keepQuestion);
                if ($action != 'keep') {
                    return false;
                }
            }

            // Create the database
            if ($action != 'keep') {
                // TODO drop action
                try {
                    $admin->createDatabase($dbname);
                } catch (DBALException $e) {
                    $this->output->writeln("Create database $dbname failed: ".$e->getCode().' - '.$e->getMessage());
                    return false;
                }
            }

            // Add the user to database
            try {
                $admin->grantUser($dbuser, $dbname);
            } catch (DBALException $e) {
                $this->output->writeln("Add user to database $dbname failed: ".$e->getCode().' - '.$e->getMessage());
                return false;
            }
            $actions[$db] = $action;
        }

        // Load the schemas, not done above as need to connect to db itself
        foreach (['core', 'data', 'user'] as $db) {
            if ($actions[$db] != 'keep') {
                $admin->close();
                $dbname = $dbprefix.$db;
                $config['dbname'] = $dbname;
                $admin = DriverManager::getConnection($config);
                $admin->connect();
                try {
                    $admin->loadSchema("../src/ARK/server/schema/database/$db.xml");
                } catch (DBALException $e) {
                    $this->output->writeln("Load Schema to database $dbname failed: ".$e->getCode().' - '.$e->getMessage());
                    return false;
                }
            }
        }

        // Termiate the admin connection
        $admin->close();
        // TODO Write out config file?
        $admin->close();
        return true;
    }
}
