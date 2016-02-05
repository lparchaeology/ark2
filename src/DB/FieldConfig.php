<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* php/arkdb/group_config.php
*
* ArkDB Field Configuration
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
* @link       http://ark.lparchaeology.com/code/php/arkdb/field_config.php
* @since      2.0
*
*/

namespace LPArchaeology\ARK\DB;

class FieldConfig
{
    private $_id = '';
    private $_valid = FALSE;
    private $_dataclass = '';
    private $_classtype = '';
    private $_editable = FALSE;
    private $_hidden = FALSE;
    private $_alias = NULL;
    private $_options = array();
    private $_rules = array();

    // {{{ __construct()
    function __construct($field_id = NULL)
    {
        if ($field_id == NULL) {
            $this->_alias = new AliasConfig();
            return;
        }
        $this->_id = $field_id;
        global $ado;
        $config = $ado->fieldConfig($field_id, __METHOD__);
        if (count($config)) {
            $this->_valid = TRUE;
            $this->_dataclass = $config['dataclass'];
            $this->_classtype = $config['classtype'];
            $this->_editable = (bool)$config['editable'];
            $this->_hidden = (bool)$config['hidden'];
            $this->_alias = new AliasConfig($field_id);
            $this->_options = Option::elementOptions($field_id);
            $this->_rules = ValidationRule::elementRoles($field_id);
        } else {
            $this->_alias = new AliasConfig();
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
    // {{{ dataclass()
    function dataclass()
    {
        return $this->_dataclass;
    }
    // }}}
    // {{{ classtype()
    function classtype()
    {
        return $this->_classtype;
    }
    // }}}
    // {{{ editable()
    function editable()
    {
        return $this->_editable;
    }
    // }}}
    // {{{ hidden()
    function hidden()
    {
        return $this->_hidden;
    }
    // }}}
    // {{{ alias()
    function alias()
    {
        return $this->_alias;
    }
    // }}}
    // {{{ options()
    function options()
    {
        return $this->_options;
    }
    // }}}
    // {{{ validationRules()
    function validationRules($vld_role)
    {
        if (array_key_exists($vld_role, $this->_rules)) {
            return $this->_rules[$vld_role];
        } else {
            return array();
        }
    }
    // }}}
    // {{{ config()
    function config()
    {
        if (!$this->isValid()) {
            print(PHP_EOL.'Invalid field '.$this->id().PHP_EOL);
            return array();
        }
        $config['field_id'] = $this->id();
        $config['dataclass'] = $this->dataclass();
        $config['classtype'] = $this->classtype();
        $config['editable'] = $this->editable();
        $config['hidden'] = $this->hidden();
        $config['aliasinfo'] = $this->alias()->config();
        foreach ($this->options() as $option) {
            $config[$option->id()] = $option->value();
        }
        foreach ($this->validationRules('add') as $rule) {
            $config['add_validation'][] = $rule->config();
        }
        foreach ($this->validationRules('edt') as $rule) {
            $config['edt_validation'][] = $rule->config();
        }
        foreach ($this->validationRules('del') as $rule) {
            $config['del_validation'][] = $rule->config();
        }
        return $config;
    }
    // }}}
    // {{{ elementFields()
    static function elementFields($element_id, $enabled = TRUE)
    {
        global $ado;
        $children = $ado->elementGroup($element_id, 'field', $enabled, __METHOD__);
        $fields = array();
        foreach ($children as $child) {
            $field = new FieldConfig($child['child_id']);
            if ($field->isValid()) {
                $fields[] = $field;
            }
        }
        return $fields;
    }
    // }}}
}

?>
