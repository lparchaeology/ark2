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
    private $app = null;
    private $drivers = ['pdo_mysql', 'pdo_pgsql', 'pdo_sqlite'];
    private $modules = [];
    private $classes = [];
    private $fragmentTables = [];
    private $scalarTables = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function settings()
    {
        return $this->app['dbs.settings'];
    }

    public function data()
    {
        return $this->app['db.data'];
    }

    public function config()
    {
        return $this->app['db.conf'];
    }

    public function user()
    {
        return $this->app['db.user'];
    }

    public function spatial()
    {
        return $this->app['db.spatial'];
    }

    public function createInstance(string $instance, string $user, string $password)
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
        if (!in_array($server['driver'], $this->drivers)) {
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
        if ($this->platform($conn) == 'mysql') {
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

    public function addUser(string $user, string $password, string $database)
    {
        $this->createUser($user, $password);
        $this->grantUser($user, $database);
    }

    private function platform(Connection $connection)
    {
        return $connection->getDriver()->getDatabasePlatform()->getName();
    }

    public function listUsers()
    {
        $platform = $this->platform($this->user());
        if ($platform == 'mysql') {
            $sql = "SELECT CONCAT(QUOTE(User),'@',QUOTE(Host)) Identity FROM mysql.user ORDER BY User";
        } elseif ($platform == 'postgresql') {
            $sql = 'SELECT rolname FROM pg_roles';
        } else {
            return array();
        }
        return $this->user()->fetchAll($sql);
    }

    public function createUser(string $user, string $password)
    {
        $platform = $this->platform($this->user());
        if ($platform == 'mysql') {
            $sql = 'CREATE USER ?@? IDENTIFIED BY ?';
            $host = $this->user()->getHost();
            if ($host == '127.0.0.1') {
                $this->user()->executeUpdate($sql, array($user, 'localhost', $password));
            }
            $params = array($user, $host, $password);
        } elseif ($platform == 'postgresql') {
            $sql = 'CREATE USER ? WITH ENCRYPTED PASSWORD ?';
            $params = array($user, $password);
        } else {
            return;
        }
        $this->user()->executeUpdate($sql, $params);
    }

    private function applyPermissions(string $action, string $user, string $database)
    {
        $platform = $this->platform($this->user());
        if ($platform == 'mysql') {
            $clause = 'ON '.$database.'.* TO ?@?';
            $params = array($user, $this->user()->getHost());
        } elseif ($platform == 'postgresql') {
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

    public function grantUser(string $user, string $database)
    {
        $this->applyPermissions('GRANT', $user, $database);
    }

    public function revokeUser(string $user, string $database)
    {
        $this->applyPermissions('REVOKE', $user, $database);
    }

    public function dropUser(string $user)
    {
        $platform = $this->platform($this->user());
        if ($platform == 'mysql') {
            $sql = 'DROP USER ?@?';
            $params = array($user, $this->user()->getHost());
        } elseif ($platform == 'postgresql') {
            $sql = 'DROP USER ?';
            $params = array($user);
        } else {
            return;
        }
        $this->user()->executeUpdate($sql, $params);
    }

    public function loadSchema(Connection $connection, string $schemaPath)
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

    private function insertRows(Connection $connection, string $table, array $fields, array $rows)
    {
        $cols = count($fields);
        $fl = implode(', ', $fields);
        $vl = str_repeat('?, ', $cols - 1).'?';
        $sql = "
            INSERT INTO $table ($fl)
            VALUES ($vl)
        ";
        $values = array_shift($rows);
        foreach ($rows as $row) {
            $values = array_merge($values, $row);
            $sql .= "
                , ($vl)
            ";
        }
        $connection->executeUpdate($sql, $values);
    }

    private function loadModules()
    {
        if ($this->modules) {
            return;
        }
        $sql = "
            SELECT *
            FROM ark_config_module
        ";
        $modules = $this->config()->fetchAll($sql, array());
        foreach ($modules as $module) {
            $this->modules[$module['module']] = $module;
        }
    }

    private function getModuleTable(string $module)
    {
        $this->loadModules();
        return $this->modules[$module]['tbl'];
    }

    private function loadDataclasses()
    {
        if ($this->classes) {
            return;
        }
        $sql = "
            SELECT *
            FROM ark_model_dataclass
        ";
        $classes = $this->config()->fetchAll($sql, array());
        foreach ($classes as $class) {
            $this->classes[$class['dataclass']] = $class;
            $this->fragmentTables[] = $class['tbl'];
            if ($class['type'] = 'scalar') {
                $this->scalarTables[] = $class['tbl'];
            }
        }
    }

    private function getDataclassTable(string $dataclass)
    {
        $this->loadDataclasses();
        return $this->classes[$dataclass]['tbl'];
    }

    public function getScalarTables()
    {
        $this->loadDataclasses();
        return $this->scalarTables;
    }

    public function getFragmentTables()
    {
        $this->loadDataclasses();
        return $this->fragmentTables;
    }

    public function addItem(string $module, string $parent, string $index, string $name, string $modtype)
    {
        $table = $this->getModuleTable($module);
        $sql = "
            INSERT INTO $table
            (id, parent, idx, name, modtype)
            VALUES (:id, :parent, :idx, :name, :modtype)
        ";
        $params = [
            ':parent' => $parent,
            ':idx' => $index,
            ':name' => $name,
            ':modtype' => $modtype,
        ];
        $params[':id'] = ($parent ? $parent.'.'.$index : $index);
        return $this->data()->executeUpdate($sql, $params);
    }

    public function addItemFragments(string $module, string $item, array $dataclassFragments)
    {
        foreach ($dataclassFragments as $dataclass => $propertyFragments) {
            $this->addDataclassFragments($module, $item, $dataclass, $propertyFragments);
        }
    }

    public function addDataclassFragments(string $module, string $item, string $dataclass, array $propertyFragments)
    {
        $table = $this->getDataclassTable($dataclass);
        $fields = array_merge(['module', 'item'], array_keys($propertyFragments[0]));
        foreach ($propertyFragments as $fragment) {
            $rows[] = array_merge([$module, $item], array_values($fragment));
        }
        $this->insertRows($this->data(), $table, $fields, $rows);
    }

    public function addPropertyFragments(string $module, string $item, string $property, string $dataclass, array $fragments)
    {
        $table = $this->getDataclassTable($dataclass);
        $fields = array_merge(['module', 'item', 'property'], array_keys($fragments[0]));
        foreach ($fragments as $fragment) {
            $rows[] = array_merge([$module, $item, $property], array_values($fragment));
        }
        $this->insertRows($this->data(), $table, $fields, $rows);
    }

    public function deleteItem(string $module, string $item)
    {
        $sql = $this->deleteItemFragmentsSql();
        $table = $this->getModuleTable($module);
        $sql .= "
            UNION
            DELETE
            FROM $table
            WHERE id = :item
        ";
        $params = array(
            ':item' => $item,
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function deleteItemFragments(string $module, string $item)
    {
        $sql = $this->deleteItemFragmentsSql();
        $params = array(
            ':module' => $module,
            ':item' => $item,
        );
        return $this->data()->executeUpdate($sql, $params);
    }

    private function deleteItemFragmentsSql()
    {
        $tables = $this->getFragmentTables();
        $sql = '';
        foreach ($tables as $table) {
            if ($sql) {
                $sql .= "
                    UNION
                ";
            }
            $sql = "
                DELETE
                FROM $table
                WHERE module = :module
                AND item = :item
            ";
        }
        return $sql;
    }

    public function deletePropertyFragments(string $module, string $item, string $property, string $dataclass)
    {
        $table = $this->getDataclassTable($dataclass);
        $sql = "
            DELETE
            FROM $table
            WHERE module = :module
            AND item = :item
            AND property = :property
        ";
        $params = array(
            ':module' => $module,
            ':item' => $item,
            ':property' => $property,
        );
        return $this->data()->executeUpdate($sql, $params);
    }

    public function getItemFragments(string $module, string $item)
    {
        $sql = '';
        $tables = $this->getScalerTables();
        foreach ($tables as $table) {
            if ($sql) {
                $sql .= "
                    UNION ALL
                ";
            }
            $sql = "
                SELECT *
                FROM $table
                WHERE module = :module
                AND item = :item
            ";
        }
        $params = array(
            ':module' => $module,
            ':item' => $item,
        );
        return $this->data()->fetchAll($sql, $params);
    }

    public function getPropertyFragments(string $module, string $item, string $property, string $dataclass)
    {
        $table = $this->getDataclassTable($dataclass);
        if ($table) {
            $sql = "
                SELECT *
                FROM $table
                WHERE module = :module
                AND item = :item
                AND property = :property
            ";
            $params = array(
                ':module' => $module,
                ':item' => $item,
                ':property' => $property,
            );
            return $this->data()->fetchAll($sql, $params);
        }
        return array();
    }

    public function getXmiItems(string $module, string $item, string $xmiModule, string $xmiTable = null)
    {
        if (empty($xmiTable)) {
            $xmiTable = $this->getModuleTable($xmiModule);
        }
        $sql = "
            SELECT $xmiTable.*
            FROM ark_dataclass_xmi, $xmiTable
            WHERE (ark_dataclass_xmi.module = :module
                   AND ark_dataclass_xmi.item = :item
                   AND ark_dataclass_xmi.xmi_module = :xmi_module
                   AND $xmiTable.id = ark_dataclass_xmi.xmi_item)
            OR (ark_dataclass_xmi.xmi_module = :module
                AND ark_dataclass_xmi.xmi_item = :item
                AND ark_dataclass_xmi.module = :xmi_module
                AND $xmiTable.id = ark_dataclass_xmi.item)
        ";
        $params = array(
            ':module' => $module,
            ':item' => $item,
            ':xmi_module' => $xmiModule,
        );
        return $this->data()->fetchAll($sql, $params);
    }

    public function getXmiItem(string $module, string $item, string $xmiModule, string $xmiItem)
    {
        $sql = "
            SELECT *
            FROM ark_dataclass_xmi
            WHERE (module = :module AND item = :item AND xmi_module = :xmi_module AND xmi_item = :xmi_item)
            OR (module = :xmi_module AND item = :xmi_item AND xmi_module = :module AND xmi_item = :item)
        ";
        $params = array(
            ':module' => $module,
            ':item' => $item,
            ':xmi_module' => $xmiModule,
            ':xmi_item' => $xmiItem,
        );
        $row = $this->data()->fetchAssoc($sql, $params);
        $this->switchXmi($row);
        return $row;
    }

    private function switchXmi(array &$row, string $module, string $item)
    {
        if ($row && $row['xmi_module'] == $module && $row['xmi_item'] == $item) {
            $row['xmi_module'] = $row['module'];
            $row['xmi_item'] = $row['item'];
            $row['module'] = $module;
            $row['item'] = $item;
        }
    }

    public function getFile(string $module, string $item, string $property)
    {
        $sql = "
            SELECT *
            FROM cor_tbl_file, cor_lut_file
            WHERE cor_tbl_file.module = :module
            AND cor_tbl_file.item = :item
            AND cor_tbl_file.property = :property
            AND cor_tbl_file.file = cor_lut_file.file
        ";
        $params = array(
            ':module' => $module,
            ':item' => $item,
            ':property' => $property,
        );
        return $this->data()->fetchAll($sql, $params);
    }

    public function getActors(string $moduleTable = null)
    {
        if (empty($moduleTable)) {
            $moduleTable = $this->getModuleTable('act');
        }
        $sql = "
            SELECT *
            FROM $moduleTable
        ";
        $params = array();
        return $this->data()->fetchAll($sql, $params);
    }

    public function getSubmodules(string $module, string $schemaId)
    {
        $sql = "
            SELECT *
            FROM ark_model_submodule, ark_config_module
            WHERE ark_model_submodule.module = :module
            AND ark_model_submodule.schema_id = :schema_id
            AND ark_model_submodule.submodule = ark_config_module.module
        ";
        $params = array(
            ':module' => $module,
            ':schema_id' => $schemaId,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getSubmodule(string $module, string $schemaId, string $submodule)
    {
        $sql = "
            SELECT *
            FROM ark_model_submodule, ark_config_module
            WHERE ark_model_submodule.module = :module
            AND ark_model_submodule.schema_id = :schema_id
            AND ark_model_submodule.submodule = :submodule
            AND ark_config_module.module = ark_model_submodule.submodule
        ";
        $params = array(
            ':module' => $module,
            ':schema_id' => $schemaId,
            ':submodule' => $submodule,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getXmiModules(string $module, string $schemaId)
    {
        $sql = "
            SELECT *
            FROM ark_model_xmi, ark_config_module
            WHERE ark_model_xmi.module = :module
            AND ark_model_xmi.schema_id = :schema_id
            AND ark_config_module.module = ark_model_xmi.module
        ";
        $params = array(
            ':module' => $module,
            ':schema_id' => $schemaId,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getItem(string $module, string $id)
    {
        $table = $this->getModuleTable($module);
        $sql = "
            SELECT *
            FROM $table
            WHERE id = :id
        ";
        $params = array(
            ':id' => $id,
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getItemFromIndex(string $module, string $parent, string $index)
    {
        $table = $this->getModuleTable($module);
        $sql = "
            SELECT *
            FROM $table
            WHERE parent = :parent
            AND idx = :idx
        ";
        $params = array(
            ':parent' => $parent,
            ':idx' => $index,
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getItems($module, $parent = null)
    {
        $table = $this->getModuleTable($module);
        $sql = "
            SELECT *
            FROM $table
        ";
        $params = array();
        if ($parent) {
            $sql .= "
                WHERE parent = :parent
            ";
            $params[':parent'] = $parent;
        }
        $sql .= "
            ORDER BY LENGTH(id), id
        ";
        return $this->data()->fetchAll($sql, $params);
    }

    public function countItems(string $module, string $parent = null)
    {
        $table = $this->getModuleTable($module);
        $sql = "
            SELECT COUNT(*) as 'count'
            FROM $table
        ";
        $params = array();
        if ($parent) {
            $sql .= "
                WHERE parent = :parent
            ";
            $params[':parent'] = $parent;
        }
        return $this->data()->fetchAssoc($sql, $params)['count'];
    }

    public function getRecentItems(string $module, string $parent, string $rows)
    {
        $table = $this->getModuleTable($module);
        $count = $this->countItems($module, $parent, $table);
        $start = ($count > $rows) ? $count - $rows : 0;
        $params = array();
        $sql = "
            SELECT *
            FROM $table
        ";
        if ($parent) {
            $sql .= "
                WHERE parent = :parent
            ";
            $params[':parent'] = $parent;
        }
        $sql .= "
            ORDER BY cre_on, LENGTH(item), item
            LIMIT $start, $rows
        ";
        return $this->data()->fetchAll($sql, $params);
    }

    public function getLastItem(string $module, string $parent)
    {
        $table = $this->getModuleTable($module);
        $params = array();
        $sql = "
            SELECT *
            FROM $table
        ";
        if ($parent) {
            $sql .= "
                WHERE parent = :parent
            ";
            $params[':parent'] = $parent;
        }
        $sql .= "
            ORDER BY LENGTH(idx) DESC, idx DESC
        ";
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getModule(string $module)
    {
        $sql = "
            SELECT *
            FROM ark_config_module
            WHERE module = :module
            OR resource = :module
        ";
        $params = array(
            ':module' => strtolower($module),
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getModuleSchemas(string $module)
    {
        $sql = "
            SELECT *
            FROM ark_model_schema
            WHERE module = :module
        ";
        $params = array(
            ':module' => strtolower($module),
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getModtypes(string $module, string $schema)
    {
        $sql = "
            SELECT *
            FROM ark_model_modtype
            WHERE module = :module
            AND schema_id = :schema
        ";
        $params = array(
            ':module' => $module,
            ':schema' => $schema,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getLayout(string $layout)
    {
        $sql = "
            SELECT *
            FROM ark_view_layout
            WHERE layout = :layout
        ";
        $params = array(
            ':layout' => $layout,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getElement(string $element)
    {
        $sql = "
            SELECT *, ark_view_element.type AS type, ark_view_element_type.class AS class, ark_view_layout.class AS layout_class
            FROM ark_view_element, ark_view_element_type
            LEFT JOIN ark_view_field ON ark_view_field.field = :element
            LEFT JOIN ark_view_layout ON ark_view_layout.layout = :element
            LEFT JOIN cor_conf_link ON cor_conf_link.link = :element
            LEFT JOIN cor_conf_subform ON cor_conf_subform.subform = :element
            WHERE ark_view_element.element = :element
            AND ark_view_element.type = ark_view_element_type.type
        ";
        $params = array(
            ':element' => $element,
        );
        $results = $this->config()->fetchAssoc($sql, $params);
        if (empty($results['class']) && !empty($results['layout_class'])) {
            $results['class'] = $results['layout_class'];
        }
        return $results;
    }

    public function getField(string $field)
    {
        $sql = "
            SELECT *
            FROM ark_view_field, ark_model_property
            WHERE field = :field
            AND ark_view_field.property = ark_model_property.property
        ";
        $params = array(
            ':field' => $field,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getSubform(string $subform)
    {
        $sql = "
            SELECT *
            FROM cor_conf_subform
            WHERE subform = :subform
        ";
        $params = array(
            ':subform' => $subform,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getGroupForModule(string $group, string $module, string $modtype = null)
    {
        $sql = "
            SELECT ark_view_group.*, ark_view_element.type AS child_type
            FROM ark_view_group, ark_view_element
            WHERE ark_view_group.element = :element
            AND (ark_view_group.modtype = :module OR ark_view_group.modtype = :modtype OR ark_view_group.modtype = :cor)
            AND ark_view_group.enabled = :enabled
            AND ark_view_group.child = ark_view_element.element
            ORDER BY ark_view_group.row, ark_view_group.col, ark_view_group.seq
        ";
        $params = array(
            ':element' => $group,
            ':modtype' => $modtype,
            ':module' => $module,
            ':cor' => 'cor',
            ':enabled' => true,
        );
        if (!$modtype) {
            $params[':modtype'] = 'cor';
        }
        return $this->config()->fetchAll($sql, $params);
    }

    public function getGroup(string $element, string $childType = null, bool $enabled = true)
    {
        $sql = "
            SELECT ark_view_group.*, ark_view_element.type AS child_type
            FROM ark_view_group, ark_view_element
            WHERE ark_view_group.element = :element
            AND ark_view_group.child = ark_view_element.element
            ORDER BY ark_view_group.row, ark_view_group.col, ark_view_group.seq
        ";
        $params[':element'] = $element;
        if ($childType) {
            $sql .= ' AND ark_view_element.type = :type';
            $params[':type'] = $childType;
        }
        if ($enabled === true || $enabled === false) {
            $sql .= ' AND ark_view_group.enabled = :enabled';
            $params[':enabled'] = $enabled;
        }
        return $this->config()->fetchAll($sql, $params);
    }

    public function getRule(string $vldRule)
    {
        $sql = "
            SELECT *
            FROM cor_conf_vld_rule
            WHERE vld_rule = :vld_rule
        ";
        $params = array(
            ':vld_rule' => $vldRule,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getElementValidationGroup(string $element, string $vldRole)
    {
        $sql = "
            SELECT *
            FROM cor_conf_element_vld
            WHERE element = :element
            AND vld_role = :vld_role
        ";
        $params = array(
            ':element' => $element,
            ':vld_role' => $vldRole,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getElementValidationGroups(string $element)
    {
        $sql = "
            SELECT *
            FROM cor_conf_element_vld
            WHERE element = :element
        ";
        $params = array(
            ':element' => $element,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getValidationGroup(string $vldGroup)
    {
        $sql = "
            SELECT *
            FROM cor_conf_vld_group
            WHERE vld_group = :vld_group
        ";
        $params = array(
            ':vld_group' => $vldGroup,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getConditions(string $element)
    {
        $sql = "
            SELECT *
            FROM cor_conf_condition
            WHERE element = :element
        ";
        $params = array(
            ':element' => $element,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getLink(string $link)
    {
        $sql = "
            SELECT *
            FROM cor_conf_link
            WHERE link = :link
        ";
        $params = array(
            ':link' => $link,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getOption(string $element, string $option)
    {
        $sql = "
            SELECT *
            FROM ark_view_option
            WHERE element = :element
            AND option = :option
        ";
        $params = array(
            ':element' => $element,
            ':option' => $option,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getOptions(string $element)
    {
        $sql = "
            SELECT *
            FROM ark_view_option
            WHERE element = :element
        ";
        $params = array(
            ':element' => $element,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getSchemaProperties(string $schema, string $module)
    {
        $sql = "
            SELECT *, ark_model_property.format, ark_model_property.keyword, ark_model_format.keyword AS format_keyword
            FROM ark_model_module, ark_model_property
            LEFT JOIN ark_model_format ON ark_model_property.format = ark_model_format.format
            LEFT JOIN ark_model_float ON ark_model_property.format = ark_model_float.format
            LEFT JOIN ark_model_integer ON ark_model_property.format = ark_model_integer.format
            LEFT JOIN ark_model_string ON ark_model_property.format = ark_model_string.format
            WHERE ark_model_module.schema_id = :schema
            AND ark_model_module.module = :module
            AND ark_model_module.property = ark_model_property.property
        ";
        $params = array(
            ':schema' => $schema,
            ':module' => $module,
        );
        $results = $this->config()->fetchAll($sql, $params);
        foreach ($results as $result) {
            if ((!isset($result['keyword']) || !$result['keyword']) && isset($result['format_keyword'])) {
                $result['keyword'] = $result['format_keyword'];
            }
        }
        return $results;
    }

    public function getObjectProperties(string $object)
    {
        $sql = "
            SELECT *, ark_model_property.format, ark_model_property.keyword, ark_model_format.keyword as format_keyword
            FROM ark_model_object, ark_model_property
            LEFT JOIN ark_model_format ON ark_model_property.format = ark_model_format.format
            LEFT JOIN ark_model_float ON ark_model_property.format = ark_model_float.format
            LEFT JOIN ark_model_integer ON ark_model_property.format = ark_model_integer.format
            LEFT JOIN ark_model_string ON ark_model_property.format = ark_model_string.format
            WHERE ark_model_object.object = :object
            AND ark_model_object.property = ark_model_property.property
        ";
        $params = array(
            ':object' => $object,
        );
        $results = $this->config()->fetchAll($sql, $params);
        foreach ($results as $result) {
            if ((!isset($result['keyword']) || !$result['keyword']) && isset($result['format_keyword'])) {
                $result['keyword'] = $result['format_keyword'];
            }
        }
        return $results;
    }

    public function getProperty(string $property)
    {
        $sql = "
            SELECT *, ark_model_property.format, ark_model_property.keyword, ark_model_format.keyword as format_keyword
            FROM ark_model_property
            LEFT JOIN ark_model_format ON ark_model_property.format = ark_model_format.format
            LEFT JOIN ark_model_float ON ark_model_property.format = ark_model_float.format
            LEFT JOIN ark_model_integer ON ark_model_property.format = ark_model_integer.format
            LEFT JOIN ark_model_string ON ark_model_property.format = ark_model_string.format
            WHERE ark_model_property.property = :property
        ";
        $params = array(
            ':property' => $property,
        );
        $result = $this->config()->fetchAssoc($sql, $params);
        if ((!isset($result['keyword']) or !$result['keyword']) && isset($result['format_keyword'])) {
            $result['keyword'] = $result['format_keyword'];
        }
        return $result;
    }

    public function getAllowedValues(string $property)
    {
        $sql = "
            SELECT *
            FROM ark_model_value
            WHERE property = :property
        ";
        $params = array(
            ':property' => $property,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getTranslations(string $domain = null)
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

    public function getFlashes(string $language)
    {
        $sql = "
            SELECT *
            FROM ark_config_flash
            WHERE language = :language
            AND active = :active
        ";
        $params = array(
            ':language' => $language,
            ':active' => true,
        );
        return $this->config()->fetchAll($sql, $params);
    }
}
