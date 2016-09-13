<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Condition.php
*
* ARK View Condition
*
* PHP version 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Heritage LLP.
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Condition.php
* @since      2.0
*
*/

namespace ARK\View;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use ARK\Database\Database;

class Condition
{
    private $function = '';
    private $arguments = array();
    private $valid = false;

    private function loadConfig(array $config)
    {
        $this->function = $config['func'];
        $this->arguments = explode(',', $config['args']);
        $this->valid = true;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function func()
    {
        return $this->function;
    }

    public function arguments()
    {
        return $this->arguments;
    }

    public function config()
    {
        if (!$this->isValid()) {
            return array();
        }
        $config['func'] = $this->func();
        $config['args'] = implode(',', $this->arguments());
        return $config;
    }

    public static function fetchConditions(Database $db, string $element)
    {
        $conditions = array();
        $rows = $db->getConditions($element);
        foreach ($rows as $row) {
            $condition = new Condition();
            $condition->loadConfig($row);
            if ($condition->isValid()) {
                $conditions[] = $condition;
            }
        }
        return $conditions;
    }
}
