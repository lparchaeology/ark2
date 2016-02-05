<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkdb/validation_rule.php
*
* ArkDB Validation Rule
* A class containing an Ark Validation Rule
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
* @link       http://ark.lparchaeology.com/code/php/arkdb/validation_rule.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\DB;

class ValidationRule
{
    private $_id = '';
    private $_valid = FALSE;
    private $_requestFunction = '';
    private $_validateFunction = '';
    private $_variableName = '';
    private $_liveVariableName = NULL;
    private $_variableLocation = NULL;
    private $_forceVariable = NULL;
    private $_requestKeyType = NULL;
    private $_returnKeyType = NULL;

    // {{{ __construct()
    function __construct($vld_rule_id = NULL)
    {
        if ($vld_rule_id == NULL) {
            return;
        }
        global $ado;
        $config = $ado->validationRule($vld_rule_id);
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
        if (array_key_exists('lv_name', $config)) {
            $this->_liveVariableName = $config['lv_name'];
        }
        if (array_key_exists('var_locn', $config)) {
            $this->_variableLocation = $config['var_locn'];
        }
        if (array_key_exists('force_var', $config)) {
            $this->_forceVariable = $config['force_var'];
        }
        if (array_key_exists('req_keytype', $config)) {
            $this->_requestKeyType = $config['req_keytype'];
        }
        if (array_key_exists('ret_keytype', $config)) {
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
        if ($this->_liveVariableName != NULL) {
            $config['lv_name'] = $this->_liveVariableName;
        }
        if ($this->_variableLocation != NULL) {
            $config['var_locn'] = $this->_variableLocation;
        }
        if ($this->_forceVariable != NULL) {
            $config['force_var'] = $this->_forceVariable;
        }
        if ($this->_requestKeyType != NULL) {
            $config['req_keytype'] = $this->_requestKeyType;
        }
        if ($this->_returnKeyType != NULL) {
            $config['ret_keytype'] = $this->_returnKeyType;
        }
        return $config;
    }
    // }}}
    // {{{ groupRules()
    static function groupRules($vld_group_id)
    {
        global $ado;
        $rules = array();
        $rows = $ado->validationGroup($vld_group_id, __METHOD__);
        foreach ($rows as $row) {
            $rule = new ValidationRule();
            $rule->_loadConfig($row);
            if ($rule->isValid()) {
                $rules[] = $rule;
            }
        }
        return $rules;
    }
    // }}}
    // {{{ elementRoles()
    static function elementRole($element_id, $vld_role)
    {
        global $ado;
        $rules = array();
        $rows = $ado->validationRole($element_id, $vld_role, __METHOD__);
        foreach ($rows as $row) {
            $rule = new ValidationRule();
            $rule->_loadConfig($row);
            if ($rule->isValid()) {
                $rules[] = $rule;
            }
        }
        return $rules;
    }
    // }}}
    // {{{ elementRoles()
    static function elementRoles($element_id)
    {
        global $ado;
        $roles = array();
        $rows = $ado->validationRoles($element_id, __METHOD__);
        foreach ($rows as $vld_role => $vld_rules) {
            foreach ($vld_rules as $vld_rule) {
                $rule = new ValidationRule();
                $rule->_loadConfig($vld_rule);
                if ($rule->isValid()) {
                    $roles[$vld_role][] = $rule;
                }
            }
        }
        return $roles;
    }
    // }}}
}

?>
