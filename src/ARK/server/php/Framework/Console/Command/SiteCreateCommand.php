<?php

/**
 * ARK Console Command.
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
 */

namespace ARK\Framework\Console\Command;

use ARK\ARK;
use ARK\Database\Console\DatabaseCommand;
use ARK\Framework\Console\ProcessTrait;
use Doctrine\DBAL\DBALException;
use Exception;

class SiteCreateCommand extends DatabaseCommand
{
    use ProcessTrait;

    private $drivers = ['pdo_mysql', 'pdo_pgsql', 'pdo_sqlite'];

    protected function configure() : void
    {
        $this->setName('site:create')
             ->setDescription('Create a new site')
             ->addOptionalArgument('site', 'The site key');
    }

    protected function doExecute()
    {
        $site = $this->getArgument('site');
        if (!$site) {
            $site = $this->askQuestion("Please enter the new site key (e.g. 'mysite')");
        }
        $site = strtolower($site);

        $frontends = array_keys(ARK::frontends());
        $frontend = $this->askChoice('Please choose the frontend to use', $frontends, 'ark2');
        $config['admin'] = $this->chooseServerConfig();
        $config['server'] = $config['admin'];
        unset($config['server']['wrapperClass']);
        $config['server']['user'] = $this->askQuestion('Please enter the site database user');
        $config['server']['password'] = $this->askPassword($config['server']['user']);
        foreach (['core', 'data', 'spatial', 'user'] as $db) {
            $config['connections'][$db]['dbname'] = $site.'_ark_'.$db;
            $config['connections'][$db]['server'] = $config['server']['server'];
        }

        if ($this->createInstance($site, $config)) {
            $this->write("Database created for $site.");
            $returnCode = $this->runCommand('site:frontend', ['site' => $site, 'frontend' => $frontend]);
            $database['servers'][$config['server']['server']] = $config['server'];
            $database['connections'] = $config['connections'];
            ARK::jsonEncodeWrite($database, ARK::siteDir($site).'/config/database.json');
            $config = ARK::siteConfig($site);
            $config['site'] = $site;
            ARK::writeSiteConfig($site, $config);
            $this->write('Site created.');
            $this->write('Please add an Admin User from the Site Admin Console.');
            $this->result = $site;
            return $this->successCode();

            /* TODO Need new Application with full DB connection created to do this, use Command Bus?
            $admin = $this->app['user.manager']->create($adminEmail, $adminPassword);
            $admin->setEnabled(true);
            $admin->addRole('ROLE_ADMIN');
            $this->app['user.manager']->save($admin);
            $this->output->writeln('ARK admin user created.');
            */
        }
        $this->write("\nFAILED: ARK site database not created.");
        return $this->errorCode();
    }

    // TODO Make a Command via the Command Bus
    private function createInstance($site, $config)
    {
        $admin = $this->getConnection($config['admin']);

        // Add the restricted database user to server
        if ($admin->userExists($config['server']['user'])) {
            $this->write('User already exists, continuing...');
        } else {
            try {
                $admin->createUser($config['server']['user'], $config['server']['password']);
            } catch (DBALException $e) {
                $this->writeException('Add user to database server failed', $e);
                $admin->close();
                return false;
            }
        }

        $actions = [];
        // Create the databases
        foreach ($config['connections'] as $db => $conn) {
            $this->write("Creating the $db database");
            $dbname = $conn['dbname'];
            $action = 'new';

            // Check database doesn't already exist
            if ($admin->databaseExists($dbname)) {
                $options = ['keep', 'drop', 'stop'];
                $action = $this->askChoice(
                    "The $db database $dbname already exists on server, do you want to do with it?",
                    ['keep', 'drop', 'stop'],
                    'keep'
                );
                if ($action !== 'keep') {
                    $admin->close();
                    return false;
                }
            }

            // Create the database
            if ($action !== 'keep') {
                // TODO drop action
                try {
                    $admin->createDatabase($dbname);
                } catch (DBALException $e) {
                    $this->writeException("Create database $dbname failed", $e);
                    $admin->close();
                    return false;
                }
            }

            // Add the user to database
            try {
                $admin->grantUser($config['server']['user'], $dbname);
            } catch (DBALException $e) {
                $this->writeException("Add user to database $dbname failed: ", $e);
                $admin->close();
                return false;
            }
            $actions[$db] = $action;
        }

        // Load the schemas, not done above as need to connect to db itself
        foreach ($config['connections'] as $db => $conn) {
            if ($actions[$db] !== 'keep') {
                $admin->close();
                $dbname = $conn['dbname'];
                $config['admin']['dbname'] = $dbname;
                $admin = $this->getConnection($config['admin']);
                $admin->connect();
                $this->write("Loading $db schema into database $dbname...");
                $admin->beginTransaction();
                try {
                    // TODO Need to add Doctrine spatial types!
                    if ($db !== 'spatial') {
                        $admin->loadSchema(ARK::namespaceDir('ARK')."/server/schema/database/$db.xml");
                        $admin->commit();
                    }
                    $this->write(" * Loaded $db schema...");
                } catch (DBALException $e) {
                    $this->writeException("Load Schema to database $dbname failed", $e);
                    $admin->rollBack();
                    $admin->enableForeignKeyChecks();
                    $admin->close();
                    return false;
                }
                try {
                    $admin->beginTransaction();
                    $admin->loadSql(ARK::namespaceDir('ARK')."/server/schema/database/$db.sql");
                    $admin->commit();
                    $this->write(" * Loaded $db data...");
                } catch (Exception $e) {
                    $this->writeException("Load Data to database $dbname failed", $e);
                    $admin->rollBack();
                    $admin->enableForeignKeyChecks();
                    $admin->close();
                    return false;
                }
            }
        }

        // Set up the Sysdmin user
        $this->write("Setting up the 'sysadmin' user for the site.");
        $password = $this->askPassword('sysadmin');
        $email = $this->askQuestion('Please enter the email for the site sysadmin user');
        $admin->close();
        $config['admin']['dbname'] = $config['connections']['user']['dbname'];
        $admin = $this->getConnection($config['admin']);
        $admin->connect();
        $admin->beginTransaction();
        try {
            $sql = '
                UPDATE ark_security_user
                SET enabled = :enabled, password = :password, email = :email
                WHERE user = :user
            ';
            $parms = [
                ':enabled' => true,
                ':email' => $email,
                ':password' => $password,
                ':user' => 'sysadmin',
            ];
            $admin->executeUpdate($sql, $parms);
            $admin->commit();
            $this->write('Site sysadmin user enabled');
        } catch (Exception $e) {
            $this->writeException('Enabling site sysadmin user failed, please enable manually', $e);
            $admin->rollBack();
        }

        // Termiate the admin connection
        $admin->close();
        return true;
    }
}
