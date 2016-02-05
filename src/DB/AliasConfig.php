<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkdb/alias_config.php
*
* ArkDB Alias Configuration
* A class containing the configuration for an Ark Field
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
* @category   base
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP
* @license    http://ark.lparchaeology.com/license
* @link       http://ark.lparchaeology.com/code/php/arkdb/alias_config.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\DB;

class AliasConfig
{
    private $_valid = FALSE;
    private $_table = '';
    private $_column = '';
    private $_key = '';
    private $_type = '';
    private $_language = '';

    // {{{ __construct()
    function __construct($element_id = NULL)
    {
        if ($element_id == NULL) {
            return;
        }
        global $ado;
        $config = $ado->elementAlias($element_id, __METHOD__);
        if (count($config)) {
            $this->_valid = TRUE;
            $this->_table = $config['tbl'];
            $this->_column = $config['col'];
            $this->_key = $config['src_key'];
            $this->_type = $config['type'];
            $this->_language = $config['lang'];
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
    // {{{ config()
    function config()
    {
        if (!$this->isValid()) {
            return FALSE;
        }
        $config['alias_tbl'] = $this->table();
        $config['alias_col'] = $this->column();
        $config['alias_src_key'] = $this->key();
        $config['alias_type'] = $this->type();
        return $config;
    }
    // }}}
}

?>
