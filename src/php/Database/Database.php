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

use Silex\Application;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;
use Doctrine\DBAL\DBALException;

class Database
{
    private $_app = null;
    private $_drivers = array('pdo_mysql', 'pdo_pgsql', 'pdo_sqlite');

    public function __construct(Application $app)
    {
        $this->_app = $app;
    }

    public function settings()
    {
        return $this->_app['dbs.settings'];
    }

    public function data()
    {
        return $this->_app['db.data'];
    }

    public function config()
    {
        return $this->_app['db.conf'];
    }

    public function user()
    {
        return $this->_app['db.user'];
    }

    public function spatial()
    {
        return $this->_app['db.spatial'];
    }

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
        $this->loadSchema($this->data(), 'src/schema/core.xml');
        $this->loadSchema($this->config(), 'src/schema/conf.xml');
        $this->loadSchema($this->user(), 'src/schema/user.xml');
        $conn->close();
        $conn = null;
        return true;
    }

    public function addUser($user, $password, $database)
    {
        $this->createUser($user, $password);
        $this->grantUser($user, $database);
    }

    private function _platform($connection)
    {
        return $connection->getDriver()->getDatabasePlatform()->getName();
    }

    public function listUsers()
    {
        $platform = $this->_platform($this->user());
        if ($platform == 'mysql') {
            $sql = "SELECT CONCAT(QUOTE(User),'@',QUOTE(Host)) Identity FROM mysql.user ORDER BY User";
        } else if ($platform == 'postgresql') {
            $sql = 'SELECT rolname FROM pg_roles';
        } else {
            return;
        }
        return $this->user()->fetchAll($sql);
    }

    public function createUser($user, $password)
    {
        $platform = $this->_platform($this->user());
        if ($platform == 'mysql') {
            $sql = 'CREATE USER ?@? IDENTIFIED BY ?';
            $host = $this->user()->getHost();
            if ($host == '127.0.0.1') {
                $this->user()->executeUpdate($sql, array($user, 'localhost', $password));
            }
            $params = array($user, $host, $password);
        } else if ($platform == 'postgresql') {
            $sql = 'CREATE USER ? WITH ENCRYPTED PASSWORD ?';
            $params = array($user, $password);
        } else {
            return;
        }
        $this->user()->executeUpdate($sql, $params);
    }

    private function _applyPermissions($action, $user, $database)
    {
        $platform = $this->_platform($this->user());
        if ($platform == 'mysql') {
            $clause = 'ON '.$database.'.* TO ?@?';
            $params = array($user, $this->user()->getHost());
        } else if ($platform == 'postgresql') {
            $clause = 'ON '.$database.'.* TO ?';
            $params = array($user);
        } else {
            return;
        }
        $permissions = array('CREATE','SELECT', 'INSERT', 'UPDATE', 'DELETE');
        foreach ($permissions as $permission) {
            $sql = $action.' '.$permission.' '.$clause;
            $this->user()->executeUpdate($sql, $params);
        }
        if ($platform == 'mysql') {
            $this->user()->executeUpdate('FLUSH PRIVILEGES');
        }
    }

    public function grantUser($user, $database)
    {
        $this->_applyPermissions('GRANT', $user, $database);
    }

    public function revokeUser($user, $database)
    {
        $this->_applyPermissions('REVOKE', $user, $database);
    }

    public function dropUser($user)
    {
        $platform = $this->_platform($this->user());
        if ($platform == 'mysql') {
            $sql = 'DROP USER ?@?';
            $params = array($identity, $this->user()->getHost());
        } else if ($platform == 'postgresql') {
            $sql = 'DROP USER ?';
            $params = array($user);
        } else {
            return;
        }
        $this->user()->executeUpdate($sql, $params);
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

    public function getText($itemkey, $itemvalue, $txttype, $lang)
    {
        $sql = "
            SELECT *
            FROM cor_tbl_txt
            WHERE itemkey = :itemkey
            AND itemvalue = :itemvalue
            AND txttype = :txttype
            AND language = :lang
        ";
        $params = array(
            ':itemkey' => $itemkey,
            ':itemvalue' => $itemvalue,
            ':txttype' => $txttype,
            ':lang' => $lang,
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getNumber($item, $classtype)
    {
        $sql = "
            SELECT *
            FROM cor_tbl_number, cor_lut_numbertype
            WHERE cor_lut_numbertype.numbertype = :classtype
            AND cor_tbl_number.numbertype = cor_lut_numbertype.id
            AND cor_tbl_number.itemkey = :itemkey
            AND cor_tbl_number.itemvalue = :itemvalue
        ";
        $params = array(
            ':classtype' => $classtype,
            ':itemkey' => $item['key'],
            ':itemvalue' => $item['value'],
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getDate($itemkey, $itemvalue, $datetype)
    {
        $sql = "
            SELECT *
            FROM cor_tbl_date
            WHERE itemkey = :itemkey
            AND itemvalue = :itemvalue
            AND datetype = :datetype
        ";
        $params = array(
            ':itemkey' => $itemkey,
            ':itemvalue' => $itemvalue,
            ':datetype' => $datetype,
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getAttribute($itemkey, $itemvalue, $attributetype)
    {
        $sql = "
            SELECT *
            FROM cor_tbl_attribute
            WHERE itemkey = :itemkey
            AND itemvalue = :itemvalue
            AND attributetype = :attributetype
        ";
        $params = array(
            ':itemkey' => $itemkey,
            ':itemvalue' => $itemvalue,
            ':attributetype' => $attributetype,
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getFile($item, $classtype)
    {
        $sql = "
            SELECT *
            FROM cor_tbl_file, cor_lut_filetype, cor_lut_file
            WHERE cor_lut_filetype.filetype = :classtype
            AND cor_lut_file.filetype = cor_lut_filetype.id
            AND cor_tbl_file.file = cor_lut_file.id
            AND cor_tbl_file.itemkey = :itemkey
            AND cor_tbl_file.itemvalue = :itemvalue
        ";
        $params = array(
            ':classtype' => $classtype,
            ':itemkey' => $item['key'],
            ':itemvalue' => $item['value'],
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getAction($itemkey, $itemvalue, $actiontype)
    {
        $sql = "
            SELECT *
            FROM cor_tbl_action
            WHERE itemkey = :itemkey
            AND itemvalue = :itemvalue
            AND actiontype = :actiontype
        ";
        $params = array(
            ':itemkey' => $itemkey,
            ':itemvalue' => $itemvalue,
            ':actiontype' => $actiontype,
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getActor($itemkey, $itemvalue, $mod_tbl = null)
    {
        if (empty($mod_tbl)) {
            $mod_tbl = $this->getModuleTable($itemkey);
        }
        $sql = "
            SELECT *
            FROM $mod_tbl
            WHERE $itemkey = :itemvalue
        ";
        $params = array(
            ':itemvalue' => $itemvalue,
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getActors($mod_tbl = null)
    {
        if (empty($mod_tbl)) {
            $mod_tbl = $this->getModuleTable('abk');
        }
        $sql = "
            SELECT *
            FROM $mod_tbl
        ";
        $params = array();
        return $this->data()->fetchAll($sql, $params);
    }

    public function getItem($itemkey, $itemvalue, $mod_tbl = null)
    {
        if (empty($mod_tbl)) {
            $mod_tbl = $this->getModuleTable($itemkey);
        }
        $sql = "
            SELECT *
            FROM $mod_tbl
            WHERE $mod_tbl.$itemkey = :itemvalue
        ";
        $params = array(
            ':itemvalue' => $itemvalue,
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getItems($ste_cd, $module_id, $mod_tbl = null)
    {
        if (!$mod_tbl) {
            $module = $this->getModule($module_id);
            $mod_tbl = $module['tbl'];
        }
        $sql = "
            SELECT *
            FROM $mod_tbl
            WHERE ste_cd = :ste_cd
        ";
        $params = array(
            ':ste_cd' => $ste_cd,
        );
        return $this->data()->fetchAll($sql, $params);
    }

    public function countItems($ste_cd, $module_id, $mod_tbl = null)
    {
        if (empty($mod_tbl)) {
            $mod_tbl = $this->getModuleTable($module_id);
        }
        $sql = "
            SELECT COUNT(*) as 'count'
            FROM $mod_tbl
            WHERE ste_cd = :ste_cd
        ";
        $params = array(
            ':ste_cd' => $ste_cd,
        );
        return $this->data()->fetchAssoc($sql, $params)['count'];
    }

    public function getRecentItems($ste_cd, $module_id, $rows)
    {
        $module = $this->getModule($module_id);
        $itemkey = $module['itemkey'];
        $mod_tbl = $module['tbl'];
        $count = $this->countItems($ste_cd, $module_id, $mod_tbl);
        $start = ($count > $rows) ? $count - $rows : 0;
        $sql = "
            SELECT *
            FROM $mod_tbl
            WHERE ste_cd = :ste_cd
            ORDER BY cre_on
            LIMIT $start, $rows
        ";
        $params = array(
            ':ste_cd' => $ste_cd,
        );
        return $this->data()->fetchAll($sql, $params);
    }

    public function getModuleTable($itemkey)
    {
        return $this->getModule($itemkey)['tbl'];
    }

    public function getModule($module_id)
    {
        $sql = "
            SELECT *
            FROM ark_config_module
            WHERE module_id = :module_id
            OR modname = :module_id
            OR itemkey = :module_id
            OR url = :module_id
        ";
        $params = array(
            ':module_id' => $module_id,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getLayout($layout_id)
    {
        $sql = "
            SELECT *
            FROM ark_config_layout
            WHERE layout_id = :layout_id
        ";
        $params = array(
            ':layout_id' => $layout_id,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getElement($element_id, $element_type = null)
    {
        $sql = "
            SELECT ark_config_element.*, ark_config_element_type.is_group, ark_config_element_type.conf_table, ark_config_element_type.conf_key
            FROM ark_config_element, ark_config_element_type
            WHERE ark_config_element.element_id = :element_id
            AND ark_config_element.element_type = ark_config_element_type.element_type
        ";
        $params = array(
            ':element_id' => $element_id,
        );
        if ($element_type) {
            $sql .= ' AND ark_config_element.element_type = :element_type';
            $params[':element_type'] = $element_type;
        }
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getField($field_id)
    {
        $sql = "
            SELECT *
            FROM ark_config_field
            WHERE field_id = :field_id
        ";
        $params = array(
            ':field_id' => $field_id,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getGroupForModule($group_id, $modname, $modtype = null)
    {
        $sql = "
            SELECT ark_config_group.*, ark_config_element.element_type AS child_type
            FROM ark_config_group, ark_config_element
            WHERE ark_config_group.element_id = :element_id
            AND (ark_config_group.modtype = :modname OR ark_config_group.modtype = :modtype OR ark_config_group.modtype = :mod_cor)
            AND ark_config_group.enabled = :enabled
            AND ark_config_group.child_id = ark_config_element.element_id
            ORDER BY ark_config_group.row, ark_config_group.col, ark_config_group.seq
        ";
        $params = array(
            ':element_id' => $group_id,
            ':modtype' => $modtype,
            ':modname' => $modname,
            ':mod_cor' => 'mod_cor',
            ':enabled' => true,
        );
        if (!$modtype) {
            $params[':modtype'] = 'mod_cor';
        }
        return $this->config()->fetchAll($sql, $params);
    }

    public function getGroup($element_id, $child_type = null, $enabled = true)
    {
        $sql = "
            SELECT ark_config_group.*, ark_config_element.element_type AS child_type
            FROM ark_config_group, ark_config_element
            WHERE ark_config_group.element_id = :element_id
            AND ark_config_group.child_id = ark_config_element.element_id
            ORDER BY ark_config_group.row, ark_config_group.col, ark_config_group.seq
        ";
        $params[':element_id'] = $element_id;
        if ($child_type) {
            $sql .= ' AND ark_config_element.element_type = :element_type';
            $params[':element_type'] = $child_type;
        }
        if ($enabled === true || $enabled === false) {
            $sql .= ' AND ark_config_group.enabled = :enabled';
            $params[':enabled'] = $enabled;
        }
        return $this->config()->fetchAll($sql, $params);
    }

    public function getOption($element_id, $option_id)
    {
        $sql = "
            SELECT *
            FROM ark_config_option
            WHERE element_id = :element_id
            AND option_id = :option_id
        ";
        $params = array(
            ':element_id' => $element_id,
            ':option_id' => $option_id,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getOptions($element_id)
    {
        $sql = "
            SELECT *
            FROM ark_config_option
            WHERE element_id = :element_id
        ";
        $params = array(
            ':element_id' => $element_id,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getTranslations($domain = null)
    {
        $sql = "
            SELECT *
            FROM ark_config_translation
        ";
        $params = array();
        if ($domain) {
            $sql .= "
                WHERE domain = :domain
            ";
            $params[':domain'] = $domain;
        }
        return $this->config()->fetchAll($sql, $params);
    }
}
