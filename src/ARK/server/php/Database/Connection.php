<?php

/**
 * ARK Database Connection
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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Database;

use Doctrine\DBAL\Connection as DBALConnection;

class Connection extends DBALConnection
{
    public function platform()
    {
        return $this->getDriver()->getDatabasePlatform();
    }

    public function config()
    {
        return $this->getParams();
    }

    public function generateGuid()
    {
        $sql = 'SELECT '.$this->platform()->getGuidExpression();
        return $this->query($sql)->fetchColumn(0);
    }


    public function countRows($table)
    {
        return $this->executeQuery("SELECT COUNT(*) FROM $table")->fetch()["COUNT(*)"];
    }

    public function fetchAllTable($table)
    {
        return $this->fetchAll("SELECT * FROM $table");
    }

    public function fetchAllColumn($sql, $column, array $params = [], array $types = [])
    {
        return array_column($this->fetchAll($sql, $params, $types), $column);
    }

    public function insertRows($table, array $fields, array $rows)
    {
        $cols = count($fields);
        $fl = implode(', ', $fields);
        $vl = str_repeat('?, ', $cols - 1).'?';
        $sql = "
            INSERT INTO $table ($fl)
            VALUES ($vl)
        ";
        $values = array_values(array_shift($rows));
        foreach ($rows as $row) {
            $values = array_merge($values, array_values($row));
            $sql .= "
                , ($vl)
            ";
        }
        $this->executeUpdate($sql, $values);
    }
}
