<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Rule.php
*
* ARK Schema Rule
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Rule.php
* @since      2.0
*
*/

namespace ARK\Schema;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use ARK\Database\Database;

class Rule
{
    private $_id = '';
    private $_valid = false;
    private $_requestFunction = '';
    private $_validateFunction = '';
    private $_variableName = '';
    private $_liveVariableName = null;
    private $_variableLocation = null;
    private $_forceVariable = null;
    private $_requestKeyType = null;
    private $_returnKeyType = null;

    // {{{ __construct()
    function __construct(Database $db, $vld_rule_id = null)
    {
        if ($vld_rule_id == null) {
            return;
        }
        $config = $db->config()->fetchAssoc('SELECT * FROM cor_conf_vld_rule WHERE vld_rule_id = ?', array($vld_rule_id));
        $this->_loadConfig($config);
    }
    // }}}
    // {{{ _loadConfig()
    private function _loadConfig($config)
    {
        if (!count($config)) {
            return;
        }
        $this->_valid = TRUE;
        $this->_id = $config['vld_rule_id'];
        $this->_requestFunction = $config['rq_func'];
        $this->_validateFunction = $config['vd_func'];
        $this->_variableName = $config['var_name'];
        if (isset($config['lv_name'])) {
            $this->_liveVariableName = $config['lv_name'];
        }
        if (isset($config['var_locn'])) {
            $this->_variableLocation = $config['var_locn'];
        }
        if (isset($config['force_var'])) {
            $this->_forceVariable = $config['force_var'];
        }
        if (isset($config['req_keytype'])) {
            $this->_requestKeyType = $config['req_keytype'];
        }
        if (isset($config['ret_keytype'])) {
            $this->_returnKeyType = $config['ret_keytype'];
        }
    }
    // }}}
    // {{{ id()
    function id()
    {
        return $this->_id;
    }
    // }}}
    // {{{ isValid()
    function isValid()
    {
        return $this->_valid;
    }
    // }}}
    // {{{ config()
    function config()
    {
        if (!$this->isValid()) {
            return array();
        }
        $config['rq_func'] = $this->_requestFunction;
        $config['vd_func'] = $this->_validateFunction;
        $config['var_name'] = $this->_variableName;
        if ($this->_liveVariableName != null) {
            $config['lv_name'] = $this->_liveVariableName;
        }
        if ($this->_variableLocation != null) {
            $config['var_locn'] = $this->_variableLocation;
        }
        if ($this->_forceVariable != null) {
            $config['force_var'] = $this->_forceVariable;
        }
        if ($this->_requestKeyType != null) {
            $config['req_keytype'] = $this->_requestKeyType;
        }
        if ($this->_returnKeyType != null) {
            $config['ret_keytype'] = $this->_returnKeyType;
        }
        return $config;
    }
    // }}}
    // {{{ fetchGroupRules()
    static function fetchGroupRules(Database $db, $vld_group_id)
    {
        $rules = array();
        try {
            $rows = $db->config()->fetchAll('SELECT * FROM cor_conf_vld_group WHERE vld_group_id = ?', array($vld_group_id));
            foreach ($rows as $row) {
                $rule = new Rule($db, $row['vld_rule_id']);
                if ($rule->isValid()) {
                    $rules[] = $rule;
                }
            }
        } catch (DBALException $e) {
            return array();
        }
        return $rules;
    }
    // }}}
    // {{{ fetchRole()
    static function fetchValidationRole(Database $db, $element_id, $vld_role)
    {
        $rules = array();
        try {
            $row = $db-config()->fetchAssoc('SELECT * FROM cor_conf_element_vld WHERE element_id = ? AND vld_role = ?', array($element_id, $vld_role));
            $rows = $db->config()->fetchAll('SELECT * FROM cor_conf_vld_group WHERE vld_group_id = ?', array($row['vld_group_id']));
            foreach ($rows as $row) {
                $rule = new Rule($db, $row['vld_rule_id']);
                if ($rule->isValid()) {
                    $rules[] = $rule;
                }
            }
        } catch (DBALException $e) {
            return array();
        }
        return $rules;
    }
    // }}}
    // {{{ fetchAllRoles()
    static function fetchAllValidationRoles(Database $db, $element_id)
    {
        $roles = array();
        try {
            $role_rows = $db->config()->fetchAll('SELECT * FROM cor_conf_element_vld WHERE element_id = ?', array($element_id));
            foreach ($role_rows as $role_row) {
                $vld_role = $role_row['vld_role'];
                $rows = $db->config()->fetchAll('SELECT * FROM cor_conf_vld_group WHERE vld_group_id = ?', array($role_row['vld_group_id']));
                foreach ($rows as $row) {
                    $rule = new Rule($db, $row['vld_rule_id']);
                    if ($rule->isValid()) {
                        $roles[$vld_role][] = $rule;
                    }
                }
            }
        } catch (DBALException $e) {
            return array();
        }
        return $roles;
    }
    // }}}
}
