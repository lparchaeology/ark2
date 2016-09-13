<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Rule.php
*
* ARK View Rule
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Rule.php
* @since      2.0
*
*/

namespace ARK\View;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use ARK\Database\Database;

class Rule
{
    private $id = '';
    private $valid = false;
    private $requestFunction = '';
    private $validateFunction = '';
    private $variableName = '';
    private $liveVariableName = null;
    private $variableLocation = null;
    private $forceVariable = null;
    private $requestKeyType = null;
    private $returnKeyType = null;

    public function __construct(Database $db, string $vldRule = null)
    {
        if ($vldRule == null) {
            return;
        }
        $config = $db->getRule($vldRule);
        $this->loadConfig($config);
    }

    private function loadConfig(array $config)
    {
        if (!count($config)) {
            return;
        }
        $this->valid = true;
        $this->id = $config['vld_rule'];
        $this->requestFunction = $config['rq_func'];
        $this->validateFunction = $config['vd_func'];
        $this->variableName = $config['var_name'];
        if (isset($config['lv_name'])) {
            $this->liveVariableName = $config['lv_name'];
        }
        if (isset($config['var_locn'])) {
            $this->variableLocation = $config['var_locn'];
        }
        if (isset($config['force_var'])) {
            $this->forceVariable = $config['force_var'];
        }
        if (isset($config['req_keytype'])) {
            $this->requestKeyType = $config['req_keytype'];
        }
        if (isset($config['ret_keytype'])) {
            $this->returnKeyType = $config['ret_keytype'];
        }
    }

    public function id()
    {
        return $this->id;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function config()
    {
        if (!$this->isValid()) {
            return array();
        }
        $config['rq_func'] = $this->requestFunction;
        $config['vd_func'] = $this->validateFunction;
        $config['var_name'] = $this->variableName;
        if ($this->liveVariableName != null) {
            $config['lv_name'] = $this->liveVariableName;
        }
        if ($this->variableLocation != null) {
            $config['var_locn'] = $this->variableLocation;
        }
        if ($this->forceVariable != null) {
            $config['force_var'] = $this->forceVariable;
        }
        if ($this->requestKeyType != null) {
            $config['req_keytype'] = $this->requestKeyType;
        }
        if ($this->returnKeyType != null) {
            $config['ret_keytype'] = $this->returnKeyType;
        }
        return $config;
    }

    public static function fetchGroupRules(Database $db, string $vldGroup)
    {
        $rules = array();
        $rows = $db->getValidationGroup($vldGroup);
        foreach ($rows as $row) {
            $rule = new Rule($db, $row['vld_rule']);
            if ($rule->isValid()) {
                $rules[] = $rule;
            }
        }
        return $rules;
    }

    public static function fetchValidationRole(Database $db, string $element, string $vldRole)
    {
        $rules = array();
        $row = $db->getElementValidationGroup($element, $vldRole);
        $rows = $db->getValidationGroup($row['vld_group']);
        foreach ($rows as $row) {
            $rule = new Rule($db, $row['vld_rule']);
            if ($rule->isValid()) {
                $rules[] = $rule;
            }
        }
        return $rules;
    }

    public static function fetchAllValidationRoles(Database $db, string $element)
    {
        $roles = array();
        $role_rows = $db->getElementValidationGroups($element);
        foreach ($role_rows as $role_row) {
            $vld_role = $role_row['vld_role'];
            $rows = $db->getValidationGroup($role_row['vld_group']);
            foreach ($rows as $row) {
                $rule = new Rule($db, $row['vld_rule']);
                if ($rule->isValid()) {
                    $roles[$vld_role][] = $rule;
                }
            }
        }
        return $roles;
    }
}
