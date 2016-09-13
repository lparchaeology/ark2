<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Alias.php
*
* ARK View Alias
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Alias.php
* @since      2.0
*
*/

namespace ARK\View;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use ARK\Database\Database;

class Alias
{
    private $table = '';
    private $column = '';
    private $key = '';
    private $type = '';
    private $attrType = '';
    private $language = '';
    private $valid = false;

    private function loadConfig(array $config)
    {
        if (count($config)) {
            $this->table = $config['tbl'];
            $this->column = $config['col'];
            $this->key = $config['src_key'];
            $this->type = $config['type'];
            $this->language = $config['lang'];
            if (isset($config['attributetype'])) {
                $this->attrType = $config['attributetype'];
            }
            $this->valid = true;
        }
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function table()
    {
        return $this->table;
    }

    public function column()
    {
        return $this->column;
    }

    public function key()
    {
        return $this->key;
    }

    public function type()
    {
        return $this->type;
    }

    public function language()
    {
        return $this->language;
    }

    public function keyword()
    {
        if (!$this->isValid()) {
            return false;
        }
        if ($this->attrType) {
            return $this->column().'.'.$this->attrType.'.'.$this->key().'.'.$this->type();
        }
        return $this->column().'.'.$this->key().'.'.$this->type();
    }

    public function config()
    {
        if (!$this->isValid()) {
            return false;
        }
        $config['alias_tbl'] = $this->table();
        $config['alias_col'] = $this->column();
        $config['alias_src_key'] = $this->key();
        $config['alias_type'] = $this->type();
        return $config;
    }

    public static function elementAlias(Database $db, string $element)
    {
        $alias = new Alias();
        $sql = "
            SELECT *
            FROM cor_conf_alias
            WHERE cor_conf_alias.element = :element
        ";
        $config = $db->config()->fetchAssoc($sql, array(':element' => $element));
        if (!$config) {
            return $alias;
        }
        $alias->loadConfig($config);
        return $alias;
    }

    public static function dataclassAlias(string $dataclass, string $classtype)
    {
        $alias = new Alias();
        $config['tbl'] = 'cor_lut_'.$dataclass.'type';
        $config['col'] = $dataclass.'type';
        $config['src_key'] = $classtype;
        $config['type'] = 'normal';
        $config['lang'] = null;
        $alias->loadConfig($config);
        return $alias;
    }

    public static function modtypeAlias(string $modtype)
    {
        $alias = new Alias();
        $config['tbl'] = 'ark_schema_modtype';
        $config['col'] = 'modtype';
        $config['src_key'] = $modtype;
        $config['type'] = 'normal';
        $config['lang'] = null;
        $alias->loadConfig($config);
        return $alias;
    }
}
