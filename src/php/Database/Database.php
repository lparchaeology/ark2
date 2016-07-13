<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Database/Database.php
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
* @see        http://ark.lparchaeology.com/code/src/php/Database/Database.php
* @since      2.0
*/

namespace ARK\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Doctrine\DBAL\DBALException;

class Database
{
    private $_drivers = array('pdo_mysql', 'pdo_pgsql', 'pdo_sqlite');

    public function createInstance($instance, $user, $password)
    {
        // Get the required details
        $database = 'ark_'.$instance;
        $server = array(
            'driver' => 'pdo_sqlite',
            'path' => $database.'.sqlite'
        );
        $server = array(
            'driver' => 'pdo_mysql',
            'host' => '127.0.0.1',
            'port' => '8889'
        );
        $admin = array(
            'user' => $user,
            'password' => $password
        );
        $user = array(
            'dbname' => $database,
            'charset' => 'utf8',
            'user' => $database,
            'password' => 'ark_pass'
        );
        $config = array_replace($server, $admin);
        // Check only supported platfroms
        if (!in_array($server['driver'], $this->_drivers)) {
            echo 'Invalid or unsupported DBAL driver '.$server['driver'];
            return false;
        }
        // Get the Admin Connection
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
        // TODO Check have CREATE permission?
        // Check database doesn't already exist
        $sm = $conn->getSchemaManager();
        if (($server['driver'] == 'pdo_sqlite' && is_file($server['path']))
            || ($server['driver'] != 'pdo_sqlite' && in_array($database, $sm->listDatabases()))) {
            echo 'Database already exists';
            return false;
        }
        // Check user doesn't already exist
        if ($server['driver'] != 'pdo_sqlite' && in_array($user['user'], $this->listUsers($conn))) {
            echo 'User already exists';
            return false;
        }
        // Create the database
        try {
            $sm->createDatabase($database);
        } catch (DBALException $e) {
            // PDOException: SQL92 SQLSTATE code
            echo 'Create database failed: '.$e->getCode().' - '.$e->getMessage();
            return false;
        }
        // Set MySQL default charset and collation to utf8
        if ($this->_platform($conn) == 'mysql') {
            $conn->query("ALTER DATABASE $database CHARACTER SET utf8 COLLATE utf8_unicode_ci");
        }
        // Add the user
        try {
            $this->addUser($conn, $user['user'], $user['password'], $database);
        } catch (DBALException $e) {
            // PDOException: SQL92 SQLSTATE code
            echo 'Add user to database failed: '.$e->getCode().' - '.$e->getMessage();
            return false;
        }
        // Termiate the admin connection
        $sm = null;
        $conn->close();
        $conn = null;
        // TODO Connect as user, load tables, load schema
        // Get the User Connection
        $config = array_replace($server, $user);
        try {
            $conn = \Doctrine\DBAL\DriverManager::getConnection($config);
        } catch (DBALException $e) {
            // DBALException: driverRequired, unknownDriver, invalidDriverClass, invalidWrapperClass(wrapperClass)
            echo 'User DBAL configuration failed: '.$e->getCode().' - '.$e->getMessage();
            return false;
        }
        // Test the User connection
        try {
            $conn->connect();
        } catch (DBALException $e) {
            // PDOException: SQL92 SQLSTATE code
            echo 'User connection failed: '.$e->getCode().' - '.$e->getMessage();
            return false;
        }
        // Load the current database schema
        $this->loadSchema($conn, 'src/schema/core.xml');
        $this->loadSchema($conn, 'src/schema/conf.xml');
        $this->loadSchema($conn, 'src/schema/user.xml');
        $conn->close();
        $conn = null;
        return true;
    }

    public function addUser(Connection $connection, $user, $password, $database)
    {
        $this->createUser($connection, $user, $password);
        $this->grantUser($connection, $user, $database);
    }

    private function _platform($connection)
    {
        return $connection->getDriver()->getDatabasePlatform()->getName();
    }

    public function listUsers(Connection $connection)
    {
        $platform = $this->_platform($connection);
        if ($platform == 'mysql') {
            $sql = "SELECT CONCAT(QUOTE(User),'@',QUOTE(Host)) Identity FROM mysql.user ORDER BY User";
        } else if ($platform == 'postgresql') {
            $sql = 'SELECT rolname FROM pg_roles';
        } else {
            return;
        }
        return $connection->fetchAll($sql);
    }

    public function createUser(Connection $connection, $user, $password)
    {
        $platform = $this->_platform($connection);
        if ($platform == 'mysql') {
            $sql = 'CREATE USER ?@? IDENTIFIED BY ?';
            $host = $connection->getHost();
            if ($host == '127.0.0.1') {
                $connection->executeUpdate($sql, array($user, 'localhost', $password));
            }
            $params = array($user, $host, $password);
        } else if ($platform == 'postgresql') {
            $sql = 'CREATE USER ? WITH ENCRYPTED PASSWORD ?';
            $params = array($user, $password);
        } else {
            return;
        }
        $connection->executeUpdate($sql, $params);
    }

    private function _applyPermissions(Connection $connection, $action, $user, $database)
    {
        $platform = $this->_platform($connection);
        if ($platform == 'mysql') {
            $clause = 'ON '.$database.'.* TO ?@?';
            $params = array($user, $connection->getHost());
        } else if ($platform == 'postgresql') {
            $clause = 'ON '.$database.'.* TO ?';
            $params = array($user);
        } else {
            return;
        }
        $permissions = array('CREATE','SELECT', 'INSERT', 'UPDATE', 'DELETE');
        foreach ($permissions as $permission) {
            $sql = $action.' '.$permission.' '.$clause;
            $connection->executeUpdate($sql, $params);
        }
        if ($platform == 'mysql') {
            $connection->executeUpdate('FLUSH PRIVILEGES');
        }
    }

    public function grantUser(Connection $connection, $user, $database)
    {
        $this->_applyPermissions($connection, 'GRANT', $user, $database);
    }

    public function revokeUser(Connection $connection, $user, $database)
    {
        $this->_applyPermissions($connection, 'REVOKE', $user, $database);
    }

    public function dropUser(Connection $connection, $user)
    {
        $platform = $this->_platform($connection);
        if ($platform == 'mysql') {
            $sql = 'DROP USER ?@?';
            $params = array($identity, $connection->getHost());
        } else if ($platform == 'postgresql') {
            $sql = 'DROP USER ?';
            $params = array($user);
        } else {
            return;
        }
        $connection->executeUpdate($sql, $params);
    }

    public function loadSchema(Connection $connection, $schemaPath)
    {
        // Load the current database schema
        $platform = $connection->getDatabasePlatform();
        $schema = \DoctrineXml\Parser::fromFile($schemaPath, $platform);
        $diff = \Doctrine\DBAL\Schema\Comparator::compareSchemas(new \Doctrine\DBAL\Schema\Schema(), $schema);
        $queries = $diff->toSaveSql($platform);
        foreach ($queries as $query) {
            $connection->query($query);
        }
    }

    public function getText(Connection $connection, $item, $classtype, $lang)
    {
        $sql = "
            SELECT *
            FROM cor_tbl_txt, cor_lut_txttype
            WHERE cor_lut_txttype.txttype = :classtype
            AND cor_tbl_txt.txttype = cor_lut_txttype.id
            AND cor_tbl_txt.itemkey = :itemkey
            AND cor_tbl_txt.itemvalue = :itemvalue
            AND cor_tbl_txt.language = :lang
        ";
        $params = array(':classtype' => $classtype, ':itemkey' => $item['key'], ':itemvalue' => $item['value'], ':lang' => $lang);
        return $connection->fetchAssoc($sql, $params);
    }

    public function getNumber(Connection $connection, $item, $classtype)
    {
        $sql = "
            SELECT *
            FROM cor_tbl_number, cor_lut_numbertype
            WHERE cor_lut_numbertype.numbertype = :classtype
            AND cor_tbl_number.numbertype = cor_lut_numbertype.id
            AND cor_tbl_number.itemkey = :itemkey
            AND cor_tbl_number.itemvalue = :itemvalue
        ";
        $params = array(':classtype' => $classtype, ':itemkey' => $item['key'], ':itemvalue' => $item['value']);
        return $connection->fetchAssoc($sql, $params);
    }

    public function getDate(Connection $connection, $item, $classtype)
    {
        $sql = "
            SELECT *
            FROM cor_tbl_date, cor_lut_datetype
            WHERE cor_lut_datetype.datetype = :classtype
            AND cor_tbl_date.datetype = cor_lut_datetype.id
            AND cor_tbl_date.itemkey = :itemkey
            AND cor_tbl_date.itemvalue = :itemvalue
        ";
        $params = array(':classtype' => $classtype, ':itemkey' => $item['key'], ':itemvalue' => $item['value']);
        return $connection->fetchAssoc($sql, $params);
    }

    public function getAttribute(Connection $connection, $item, $classtype)
    {
        $sql = "
            SELECT *
            FROM cor_tbl_attribute, cor_lut_attributetype, cor_lut_attribute
            WHERE cor_lut_attributetype.attributetype = :classtype
            AND cor_lut_attribute.attributetype = cor_lut_attributetype.id
            AND cor_tbl_attribute.attribute = cor_lut_attribute.id
            AND cor_tbl_attribute.itemkey = :itemkey
            AND cor_tbl_attribute.itemvalue = :itemvalue
        ";
        $params = array(':classtype' => $classtype, ':itemkey' => $item['key'], ':itemvalue' => $item['value']);
        return $connection->fetchAssoc($sql, $params);
    }
}
