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
use ARK\Database\Console\DatabaseCommand;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SiteCreateCommand extends DatabaseCommand
{
    use ProcessTrait;

    private $drivers = ['pdo_mysql', 'pdo_pgsql', 'pdo_sqlite'];

    protected function configure()
    {
        $this->setName('site:create')
             ->setDescription('Create a new site')
             ->addOptionalArgument('site', 'The site key');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $site = $this->getArgument('site');
        if (!$site) {
            $site = $this->askQuestion("Please enter the new site key (e.g. 'mysite')");
        }

        $frontends = array_keys(ARK::frontends());
        $frontend = $this->askChoice('Please choose the frontend to use', $frontends, 'core');
        $config = $this->chooseServerConfig();

        //$adminEmailQuestion = new Question('Please enter the Site Admin User email: ', '');
        //$adminPasswordQuestion = new Question('Please enter the Site Admin User password: ', '');
        //$adminEmail = $this->question->ask($this->input, $this->output, $adminEmailQuestion);
        //$adminPasswordQuestion->setHidden(true);
        //$adminPassword = $this->question->ask($this->input, $this->output, $adminPasswordQuestion);

        if ($this->createInstance($site, $config)) {
            $this->write('Site database created.');
            $returnCode = $this->runCommand('site:frontend', ['site' => $site, 'frontend' => $frontend]);
            $this->write('Site folder created.');
            $this->write('Please add an Admin User from the Site Admin Console.');

            /* TODO Need new Application with full DB comnnection created to do this, use Command Bus?
            $admin = $this->app['user.manager']->create($adminEmail, $adminPassword);
            $admin->setEnabled(true);
            $admin->addRole('ROLE_ADMIN');
            $this->app['user.manager']->save($admin);
            $this->output->writeln('ARK admin user created.');
            */
        } else {
            $this->write("\nFAILED: ARK site database not created.");
            return false;
        }
        dump('created');
        dump($site);
        return $site;
    }

    // TODO Make a Command via the Command Bus
    private function createInstance($site, $config)
    {
        $dbprefix = $site.'_ark_';
        $dbuser = 'ark_user';
        // TODO And change the password!
        $dbpass = 'ark_pass';

        $admin = $this->getConnection($config);

        // Add the restricted database user to server
        if ($admin->userExists($dbuser)) {
            $this->output->writeln('User already exists, continuing...');
        } else {
            try {
                $admin->createUser($dbuser, $dbpass);
            } catch (DBALException $e) {
                $this->writeException('Add user to database server failed', $e);
                return false;
            }
        }

        $actions = [];
        // Create the databases
        foreach (['core', 'data', 'spatial', 'user'] as $db) {
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
                $action = $this->askChoice(
                    "The database $dbname already exists on server, do you want to do with it?",
                    ['keep', 'drop', 'stop'],
                    'keep'
                );
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
                    $this->writeException("Create database $dbname failed", $e);
                    return false;
                }
            }

            // Add the user to database
            try {
                $admin->grantUser($dbuser, $dbname);
            } catch (DBALException $e) {
                $this->writeException("Add user to database $dbname failed: ", $e);
                return false;
            }
            $actions[$db] = $action;
        }

        // Load the schemas, not done above as need to connect to db itself
        // TODO add spatial when working
        foreach (['core', 'data', 'user'] as $db) {
            if ($actions[$db] != 'keep') {
                $admin->close();
                $dbname = $dbprefix.$db;
                $config['dbname'] = $dbname;
                $admin = $this->getConnection($config);
                $admin->connect();
                try {
                    $admin->loadSchema("../src/ARK/server/schema/database/$db.xml");
                } catch (DBALException $e) {
                    $this->writeException("Load Schema to database $dbname failed", $e);
                    return false;
                }
            }
        }

        // Termiate the admin connection
        $admin->close();
        // TODO Write out config file?
        return true;
    }
}
