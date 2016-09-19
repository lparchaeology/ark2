<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Database/Command/DatabaseCommand.php
*
* Ark Database
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Database/Command/DatabaseCommand.php
* @since      2.0
*/

namespace ARK\Database\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Doctrine\DBAL\DBALException;

class DatabaseCommand extends Command
{
    public function __construct()
    {
    }

    public function install()
    {
        // Get the required details
        $server = array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'port' => '8889'
        );
        $admin = array(
            'user' => 'root',
            'password' => ''
        );
        $user = array(
            'user' => 'ark_user',
            'password' => 'ark_pass'
        );
        $database = 'ark_test1';
        $config = array_replace($server, $admin);
        // Get the Admin Connection
        try {
            $conn = \Doctrine\DBAL\DriverManager::getConnection($config);
        } catch (DBALException $e) {
            // DBALException: driverRequired, unknownDriver, invalidDriverClass, invalidWrapperClass(wrapperClass)
            echo 'DBAL configuration failed: '.$e->getCode().' - '.$e->getMessage();
            return;
        }
        // Test the Admin connection
        try {
            $conn->connect();
        } catch (PDOException $e) {
            // PDOException: SQL92 SQLSTATE code
            echo 'Server connection failed: '.$e->getCode().' - '.$e->getMessage();
            return;
        }
        // TODO Check have CREATE permission?
        // Check database doesn't already exist
        $sm = $conn->getSchemaManager();
        if in_array($database $sm->listDatabases()) {
            echo 'Database already exists';
            return;
        }
        // Termiate the admin connection
        $conn->close();
        $conn = null;
        // TODO Connect as user, load tables, load schema
    }

    public function dropUser(Connection $connection)
    {
    }
}
