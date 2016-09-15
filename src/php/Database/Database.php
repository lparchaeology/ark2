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
    const FetchFirst = 0;
    const FetchAll =1;

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

    private function getFragment($table, $module, $item, $property, $mode = Database::FetchFirst)
    {
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
        if ($mode == Database::FetchAll) {
            return $this->data()->fetchAll($sql, $params);
        }
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getAction($module, $item, $property, $mode = Database::FetchFirst)
    {
        return $this->getFragment('cor_tbl_action', $module, $item, $property, $mode);
    }

    public function getAttribute($module, $item, $property, $mode = Database::FetchFirst)
    {
        return $this->getFragment('cor_tbl_attribute', $module, $item, $property, $mode);
    }

    public function getBoolean($module, $item, $property, $mode = Database::FetchFirst)
    {
        return $this->getFragment('ark_data_boolean', $module, $item, $property, $mode);
    }

    public function getDate($module, $item, $property, $mode = Database::FetchFirst)
    {
        return $this->getFragment('ark_data_date', $module, $item, $property, $mode);
    }

    public function getInteger($module, $item, $property, $mode = Database::FetchFirst)
    {
        return $this->getFragment('ark_data_integer', $module, $item, $property, $mode);
    }

    public function getNumber($module, $item, $property, $mode = Database::FetchFirst)
    {
        return $this->getFragment('ark_data_number', $module, $item, $property, $mode);
    }

    public function getSpan($module, $item, $property, $mode = Database::FetchFirst)
    {
        return $this->getFragment('cor_tbl_span', $module, $item, $property, $mode);
    }

    public function getString($module, $item, $property, $lang, $mode = Database::FetchFirst)
    {
        $sql = "
            SELECT *
            FROM ark_data_string
            WHERE module = :module
            AND item = :item
            AND property = :property
            AND language = :language
        ";
        $params = array(
            ':module' => $module,
            ':item' => $item,
            ':property' => $property,
            ':language' => $lang,
        );
        if ($mode == Database::FetchAll) {
            return $this->data()->fetchAll($sql, $params);
        }
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getXmiItems($module, $item, $xmiModule, $xmiTable = null)
    {
        if (empty($mod_tbl)) {
            $mod_tbl = $this->getModuleTable($module);
        }
        $sql = "
            SELECT $xmiTable.*
            FROM ark_data_xmi, $xmiTable
            WHERE (ark_data_xmi.module = :module AND ark_data_xmi.item = :item AND ark_data_xmi.xmi_module = :xmi_module
                   AND $xmiTable.item = ark_data_xmi.xmi_item)
            OR (ark_data_xmi.xmi_module = :module AND ark_data_xmi.xmi_item = :item AND ark_data_xmi.module = :xmi_module
                AND $xmiTable.item = ark_data_xmi.item)
        ";
        $params = array(
            ':module' => $module,
            ':item' => $item,
            ':xmi_module' => $xmiModule,
        );
        return $this->data()->fetchAll($sql, $params);
    }

    public function getXmiItem($module, $item, $xmiModule, $xmiItem)
    {
        $sql = "
            SELECT *
            FROM ark_data_xmi
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

    private function switchXmi(&$row, $module, $item)
    {
        if ($row && $row['xmi_module'] == $module && $row['xmi_item'] == $item) {
            $row['xmi_module'] = $row['module'];
            $row['xmi_item'] = $row['item'];
            $row['module'] = $module;
            $row['item'] = $item;
        }
    }

    public function getFile($module, $item, $property, $mode = Database::FetchFirst)
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
        if ($mode == Database::FetchAll) {
            return $this->data()->fetchAll($sql, $params);
        }
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getActor($itemkey, $itemvalue, $mode = Database::FetchFirst, $mod_tbl = null)
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
        if ($mode == Database::FetchAll) {
            return $this->data()->fetchAll($sql, $params);
        }
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getActors($mod_tbl = null)
    {
        if (empty($mod_tbl)) {
            $mod_tbl = $this->getModuleTable('act');
        }
        $sql = "
            SELECT *
            FROM $mod_tbl
        ";
        $params = array();
        return $this->data()->fetchAll($sql, $params);
    }

    public function getSubmodules($module, $schema_id)
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
            ':schema_id' => $schema_id,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getSubmodule($module, $schema_id, $submodule)
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
            ':schema_id' => $schema_id,
            ':submodule' => $submodule,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getXmiModules($module, $schema_id)
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
            ':schema_id' => $schema_id,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getItem($module, $item, $mod_tbl = null)
    {
        if (empty($mod_tbl)) {
            $mod_tbl = $this->getModuleTable($module);
        }
        $sql = "
            SELECT *
            FROM $mod_tbl
            WHERE item = :item
        ";
        $params = array(
            ':item' => $item,
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getItemFromIndex($module, $parent, $index, $mod_tbl = null)
    {
        if (empty($mod_tbl)) {
            $mod_tbl = $this->getModuleTable($module);
        }
        $sql = "
            SELECT *
            FROM $mod_tbl
            WHERE parent = :parent
            AND idx = :idx
        ";
        $params = array(
            ':parent' => $parent,
            ':idx' => $index,
        );
        return $this->data()->fetchAssoc($sql, $params);
    }

    public function getItems($module, $parent = null, $mod_tbl = null)
    {
        if (!$mod_tbl) {
            $module = $this->getModule($module);
            $mod_tbl = $module['tbl'];
        }
        $sql = "
            SELECT *
            FROM $mod_tbl
        ";
        $params = array();
        if ($parent) {
            $sql .= "
                WHERE parent = :parent
            ";
            $params[':parent'] = $parent;
        }
        $sql .= "
            ORDER BY LENGTH(item), item
        ";
        return $this->data()->fetchAll($sql, $params);
    }

    public function countItems($module, $parent = null, $mod_tbl = null)
    {
        if (empty($mod_tbl)) {
            $mod_tbl = $this->getModuleTable($module);
        }
        $sql = "
            SELECT COUNT(*) as 'count'
            FROM $mod_tbl
        ";
        $params = array();
        if ($parent) {
            $sql .= "
                WHERE item LIKE :parent
            ";
            $params[':parent'] = $parent.'[_]%';
        }
        return $this->data()->fetchAssoc($sql, $params)['count'];
    }

    public function getRecentItems($module, $parent, $rows, $mod_tbl = null)
    {
        if (empty($mod_tbl)) {
            $mod_tbl = $this->getModuleTable($module);
        }
        $count = $this->countItems($module, $parent, $mod_tbl);
        $start = ($count > $rows) ? $count - $rows : 0;
        $params = array();
        $sql = "
            SELECT *
            FROM $mod_tbl
        ";
        if ($parent) {
            $sql .= "
                WHERE item LIKE :parent
            ";
            $params[':parent'] = $parent.'[_]%';
        }
        $sql .= "
            ORDER BY cre_on, LENGTH(item), item
            LIMIT $start, $rows
        ";
        return $this->data()->fetchAll($sql, $params);
    }

    public function getItemProperty($itemkey, $itemvalue, $property)
    {
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

    public function getModuleTable($itemkey)
    {
        return $this->getModule($itemkey)['tbl'];
    }

    public function getModule($module)
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

    public function getModtypes($module, $schema)
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

    public function getLayout($layout)
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

    public function getElement($element, $element_type = null)
    {
        $sql = "
            SELECT ark_view_element.*, ark_view_element_type.is_group, ark_view_element_type.tbl
            FROM ark_view_element, ark_view_element_type
            WHERE ark_view_element.element = :element
            AND ark_view_element.element_type = ark_view_element_type.element_type
        ";
        $params = array(
            ':element' => $element,
        );
        if ($element_type) {
            $sql .= ' AND ark_view_element.element_type = :element_type';
            $params[':element_type'] = $element_type;
        }
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getField($field)
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

    public function getSubform($subform)
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

    public function getGroupForModule($group, $module, $modtype = null)
    {
        $sql = "
            SELECT ark_view_group.*, ark_view_element.element_type AS child_type
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

    public function getGroup($element, $child_type = null, $enabled = true)
    {
        $sql = "
            SELECT ark_view_group.*, ark_view_element.element_type AS child_type
            FROM ark_view_group, ark_view_element
            WHERE ark_view_group.element = :element
            AND ark_view_group.child = ark_view_element.element
            ORDER BY ark_view_group.row, ark_view_group.col, ark_view_group.seq
        ";
        $params[':element'] = $element;
        if ($child_type) {
            $sql .= ' AND ark_view_element.element_type = :element_type';
            $params[':element_type'] = $child_type;
        }
        if ($enabled === true || $enabled === false) {
            $sql .= ' AND ark_view_group.enabled = :enabled';
            $params[':enabled'] = $enabled;
        }
        return $this->config()->fetchAll($sql, $params);
    }

    public function getRule($vld_rule)
    {
        $sql = "
            SELECT *
            FROM cor_conf_vld_rule
            WHERE vld_rule = :vld_rule
        ";
        $params = array(
            ':vld_rule' => $vld_rule,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getElementValidationGroup($element, $vld_role)
    {
        $sql = "
            SELECT *
            FROM cor_conf_element_vld
            WHERE element = :element
            AND vld_role = :vld_role
        ";
        $params = array(
            ':element' => $element,
            ':vld_role' => $vld_role,
        );
        return $this->config()->fetchAssoc($sql, $params);
    }

    public function getElementValidationGroups($element)
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

    public function getValidationGroup($vld_group)
    {
        $sql = "
            SELECT *
            FROM cor_conf_vld_group
            WHERE vld_group = :vld_group
        ";
        $params = array(
            ':vld_group' => $vld_group,
        );
        return $this->config()->fetchAll($sql, $params);
    }

    public function getConditions($element)
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

    public function getLink($link)
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

    public function getOption($element, $option)
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

    public function getOptions($element)
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

    public function getSchemaProperties($schema, $module)
    {
        $sql = "
            SELECT *, ark_model_property.format, ark_model_property.keyword, ark_model_format.keyword AS format_keyword
            FROM ark_model_module, ark_model_property
            LEFT JOIN ark_model_format ON ark_model_property.format = ark_model_format.format
            LEFT JOIN ark_model_number ON ark_model_property.format = ark_model_number.format
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

    public function getObjectProperties($object)
    {
        $sql = "
            SELECT *, ark_model_property.format, ark_model_property.keyword, ark_model_format.keyword as format_keyword
            FROM ark_model_object, ark_model_property
            LEFT JOIN ark_model_format ON ark_model_property.format = ark_model_format.format
            LEFT JOIN ark_model_number ON ark_model_property.format = ark_model_number.format
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

    public function getProperty($property)
    {
        $sql = "
            SELECT *, ark_model_property.format, ark_model_property.keyword, ark_model_format.keyword as format_keyword
            FROM ark_model_property
            LEFT JOIN ark_model_format ON ark_model_property.format = ark_model_format.format
            LEFT JOIN ark_model_number ON ark_model_property.format = ark_model_number.format
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

    public function getEnums($property)
    {
        $sql = "
            SELECT *
            FROM ark_model_enum
            WHERE property = :property
        ";
        $params = array(
            ':property' => $property,
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
