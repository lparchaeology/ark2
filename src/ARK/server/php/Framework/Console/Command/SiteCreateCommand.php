<?php

/**
 * ARK Console Command.
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

namespace ARK\Framework\Console\Command;

use ARK\ARK;
use ARK\Console\ProcessTrait;
use ARK\Database\Console\Command\DatabaseCommand;
use Doctrine\DBAL\DBALException;
use Exception;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

class SiteCreateCommand extends DatabaseCommand
{
    use ProcessTrait;

    protected function configure() : void
    {
        $this->setName('site:create')
             ->setDescription('Create a new site')
             ->addOptionalArgument('site', 'The site key');
    }

    protected function doExecute() : void
    {
        $site = $this->getArgument('site');
        if (!$site) {
            $site = $this->askQuestion("Please enter the new site key (e.g. 'mysite')");
        }
        $site = mb_strtolower($site);

        $frontends = array_keys(ARK::frontends());
        $frontend = $this->askChoice('Please choose the frontend to use', $frontends, 'ark2');
        $config['admin'] = $this->chooseServerConfig();
        $config['server'] = $config['admin'];
        unset($config['server']['wrapperClass']);
        $config['server']['user'] = $this->askQuestion('Please enter the site database user');
        $config['server']['password'] = $this->askPassword($config['server']['user']);

        $strategy = [
            'Separate databases for config, data, and users (recommended for large or multi-site installs)',
            'Separate databases for config and data (recommended for smaller or single site installs)',
            'Single database for config and data (not recommended, makes upgrades harder)',
        ];
        $strategy = $this->askChoice('Please choose a database strategy', $strategy, 0);

        $spatial = [
            'same' => 'Use the same database server',
            'new' => 'Use a different database server',
            'geos' => 'Use GEOS (processing only, no indexing)',
            'none' => 'No geospatial processing',
        ];
        $spatial = $this->askChoice('Please choose a geospatial indexing/processing option', $spatial, 0);

        foreach (['config', 'data', 'spatial', 'user'] as $db) {
            $config['connections'][$db]['dbname'] = $site.'_ark_'.$db;
            $config['connections'][$db]['server'] = $config['server']['server'];
        }

        if ($this->createInstance($site, $config)) {
            $this->write("Database created for $site.");
            $this->runCommand('site:frontend', ['site' => $site, 'frontend' => $frontend]);
            $database['servers'][$config['server']['server']] = $config['server'];
            $database['connections'] = $config['connections'];
            ARK::jsonEncodeWrite($database, ARK::siteDir($site).'/config/database.json');
            $config = ARK::siteConfig($site);
            $config['site'] = $site;
            $config['web']['frontend'] = $frontend;
            ARK::writeSiteConfig($site, $config);
            $this->write('Site created.');
            $this->result = $site;
            return;
        }
        $this->write("\nFAILED: ARK site database not created.");
    }

    // TODO Make a Command / Service / etc
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
                    $options,
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
                    $admin->loadSchema(ARK::namespaceDir('ARK')."/server/schema/database/$db.xml");
                    $admin->commit();
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
                    $admin->import(ARK::namespaceDir('ARK')."/server/schema/database/$db.sql");
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
        $encoder = new BCryptPasswordEncoder(13);
        $password = $encoder->encodePassword($password, null);
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
