<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Alias.php
*
* ARK Schema Alias
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Alias.php
* @since      2.0
*
*/

namespace ARK\Schema;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use ARK\Database\Database;

class Alias
{
    private $_table = '';
    private $_column = '';
    private $_key = '';
    private $_type = '';
    private $_attrType = '';
    private $_language = '';
    private $_valid = false;

    // {{{ _loadConfig()
    private function _loadConfig($config)
    {
        if (count($config)) {
            $this->_table = $config['tbl'];
            $this->_column = $config['col'];
            $this->_key = $config['src_key'];
            $this->_type = $config['type'];
            $this->_language = $config['lang'];
            if (isset($config['attributetype'])) {
                $_attrType = $config['attributetype'];
            }
            $this->_valid = true;
        }
    }
    // }}}
    // {{{ isValid()
    function isValid()
    {
        return $this->_valid;
    }
    // }}}
    // {{{ table()
    function table()
    {
        return $this->_table;
    }
    // }}}
    // {{{ column()
    function column()
    {
        return $this->_column;
    }
    // }}}
    // {{{ key()
    function key()
    {
        return $this->_key;
    }
    // }}}
    // {{{ type()
    function type()
    {
        return $this->_type;
    }
    // }}}
    // {{{ language()
    function language()
    {
        return $this->_language;
    }
    // }}}
    // {{{ tranKey()
    function tranKey()
    {
        if (!$this->isValid()) {
            return false;
        }
        if ($this->_attrType) {
            return $this->column().'.'.$this->_attrType.'.'.$this->key().'.'.$this->type();
        } else {
            return $this->column().'.'.$this->key().'.'.$this->type();
        }
    }
    // }}}
    // {{{ config()
    function config()
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
    // }}}
    // {{{ elementAlias()
    static function elementAlias(Database $db, $element_id)
    {
        $alias = new Alias();
        $sql = "
            SELECT *
            FROM cor_conf_alias
            WHERE cor_conf_alias.element_id = :element_id
        ";
        $config = $db->config()->fetchAssoc($sql, array(':element_id' => $element_id));
        if (!$config) {
            return $alias;
        }
        $alias->_loadConfig($config);
        return $alias;
    }
    // }}}
    // {{{ dataclassAlias()
    static function dataclassAlias($dataclass, $classtype)
    {
        $alias = new Alias();
        $config['tbl'] = 'cor_lut_'.$dataclass.'type';
        $config['col'] = $dataclass.'type';
        $config['src_key'] = $classtype;
        $config['type'] = 'normal';
        $config['lang'] = null;
        $alias->_loadConfig($config);
        return $alias;
    }
    // }}}
}
