<?php

/**
 * ARK Admin Database Connection
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

namespace ARK\Database;

use ARK\ARK;
use ARK\Database\Connection;
use ARK\Database\SchemaWriter;
use Doctrine\DBAL\Schema\Comparator;
use Doctrine\DBAL\Schema\Schema;
use DoctrineXml\Parser;

class AdminConnection extends Connection
{
    public function disableForeignKeyChecks()
    {
        // TODO Check Postgres and SQLite
        $this->executeQuery("SET FOREIGN_KEY_CHECKS=0");
    }

    public function enableForeignKeyChecks()
    {
        // TODO Check Postgres and SQLite
        $this->executeQuery("SET FOREIGN_KEY_CHECKS=1");
    }

    public function createDatabase($database)
    {
        $this->getSchemaManager()->createDatabase($database);
        // Set MySQL default charset and collation to utf8
        if ($this->platform()->getName() == 'mysql') {
            $this->query("ALTER DATABASE $database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }
    }

    public function listDatabases()
    {
        return $this->getSchemaManager()->listDatabases();
    }

    public function databaseExists($database)
    {
        return in_array($database, $this->getSchemaManager()->listDatabases());
    }

    public function schema()
    {
        return $this->getSchemaManager()->createSchema();
    }

    public function loadSql($sqlPath)
    {
        $this->disableForeignKeyChecks();
        $this->executeUpdate(file_get_contents($sqlPath));
        $this->enableForeignKeyChecks();
    }

    public function loadSchema($schemaPath)
    {
        $schema = Parser::fromFile($schemaPath, $this->platform());
        $this->createSchema($schema);
    }

    public function createSchema($schema)
    {
        $this->disableForeignKeyChecks();
        // TODO More efficient way???
        $diff = Comparator::compareSchemas(new Schema(), $schema);
        $queries = $diff->toSaveSql($this->platform());
        foreach ($queries as $query) {
            $this->query($query);
        }
        $this->enableForeignKeyChecks();
    }

    public function extractSchema($schemaPath, $overwrite = true)
    {
        SchemaWriter::fromConnection($this, $schemaPath, $overwrite);
    }

    public function tableExists($table)
    {
        return $this->getSchemaManager()->tablesExist([$table]);
    }

    public function createItemTable($module)
    {
        $table = 'ark_item_'.$module;
        $sm = $this->getSchemaManager();
        if ($sm->tablesExist([$table])) {
            throw new \Exception('Table exists!');
        }
        $schema = Parser::fromFile(ARK::namespaceDir('ARK').'/server/schema/database/ark_item_table.xml', $this->platform());
        $schema->renameTable('ark_item_table', $table);
        $sm->createTable($schema->getTable($table));
    }

    public function listUsers($identity = false)
    {
        switch ($this->platform()->getName()) {
            case 'mysql':
                if ($identity) {
                    $sql = "SELECT CONCAT(QUOTE(User),'@',QUOTE(Host)) Identity FROM mysql.user ORDER BY User";
                    $col = 'Identity';
                } else {
                    $sql = "SELECT User FROM mysql.user ORDER BY User";
                    $col = 'User';
                }
                return $this->fetchAllColumn($sql, $col);
                break;
            case 'postgresql':
                $sql = 'SELECT rolname FROM pg_roles';
                return $this->fetchAllColumn($sql, 'rolname');
                break;
            default:
                // SQLite doesn't support users
                return [];
        }
    }

    public function userExists($user)
    {
        return in_array($user, $this->listUsers());
    }

    public function createUser($user, $password)
    {
        switch ($this->platform()->getName()) {
            case 'mysql':
                $sql = 'CREATE USER ?@? IDENTIFIED BY ?';
                $host = $this->getHost();
                if ($host == '127.0.0.1' || $host == 'localhost') {
                    $this->executeUpdate($sql, [$user, '127.0.0.1', $password]);
                    $this->executeUpdate($sql, [$user, 'localhost', $password]);
                } else {
                    $this->executeUpdate($sql, [$user, $host, $password]);
                }
                break;
            case 'postgresql':
                $sql = 'CREATE USER ? WITH ENCRYPTED PASSWORD ?';
                $this->executeUpdate($sql, [$user, $password]);
                break;
            default:
                // SQLite doesn't support users
                return;
        }
    }

    private function applyPermissions($action, $user, $database)
    {
        switch ($this->platform()->getName()) {
            case 'mysql':
                $clause = 'ON '.$database.'.* TO ?@?';
                $params = [$user, $this->getHost()];
                break;
            case 'postgresql':
                $clause = 'ON '.$database.'.* TO ?';
                $params = [$user];
                break;
            default:
                // SQLite doesn't support users
                return;
        }
        $permissions = ['CREATE', 'SELECT', 'INSERT', 'UPDATE', 'DELETE'];
        foreach ($permissions as $permission) {
            $sql = $action.' '.$permission.' '.$clause;
            $this->executeUpdate($sql, $params);
        }
        if ($this->platform()->getName() == 'mysql') {
            $this->executeUpdate('FLUSH PRIVILEGES');
        }
    }

    public function grantUser($user, $database)
    {
        $this->applyPermissions('GRANT', $user, $database);
    }

    public function revokeUser($user, $database)
    {
        $this->applyPermissions('REVOKE', $user, $database);
    }

    public function dropUser($user)
    {
        switch ($this->platform()->getName()) {
            case 'mysql':
                $sql = 'DROP USER ?@?';
                $params = [$user, $this->getHost()];
                break;
            case 'postgresql':
                $sql = 'DROP USER ?';
                $params = [$user];
                break;
            default:
                // SQLite doesn't support users
                return;
        }
        return $this->executeUpdate($sql, $params);
    }
}
