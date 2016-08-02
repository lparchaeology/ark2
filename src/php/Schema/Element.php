<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Element.php
*
* ARK Schema Element
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Element.php
* @since      2.0
*
*/

namespace ARK\Schema;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Form\FormBuilder;
use ARK\Database\Database;

abstract class Element
{
    protected $_id = '';
    protected $_valid = false;
    protected $_type = '';
    protected $_isGroup = false;
    protected $_title = '';
    protected $_description = '';
    protected $_table = '';
    protected $_key = '';
    protected $_module = '';
    protected $_modtype = '';
    protected $_alias = null;
    protected $_options = array();
    protected $_conditions = array();

    // {{{ __construct()
    function __construct(Database $db, $element_id = null, $element_type = null)
    {
        $this->_alias = new Alias($db);
        if (!$element_id) {
            return;
        }
        $this->_id = $element_id;
        $config = $db->getElement($element_id, $element_type);
        $this->_type = $config['element_type'];
        $this->_isGroup = $config['is_group'];
        $this->_title = $config['title'];
        $this->_description = $config['description'];
        $this->_table = $config['conf_table'];
        $this->_key = $config['conf_key'];
        $this->_module = $config['module_id'];
        $this->_modtype = $config['modtype'];
        $this->_alias = Alias::elementAlias($db, $element_id);
        $this->_options = Option::fetchOptions($db, $element_id);
        $this->_conditions = Condition::fetchConditions($db, $element_id);
    }

    function id()
    {
        return $this->_id;
    }

    function isValid()
    {
        return $this->_valid;
    }

    function type()
    {
        return $this->_type;
    }

    function isGroup()
    {
        return $this->_isGroup;
    }

    function title()
    {
        return $this->_title;
    }

    function description()
    {
        return $this->_description;
    }

    function table()
    {
        return $this->_table;
    }

    function key()
    {
        return $this->_key;
    }

    function module()
    {
        return $this->_module;
    }

    function modtype()
    {
        return $this->_modtype;
    }

    function alias()
    {
        return $this->_alias;
    }

    function option($key)
    {
        if (isset($this->_options[$key])) {
            return $this->_options[$key];
        }
        return new Option();
    }

    function optionValue($key, $default = null)
    {
        if (isset($this->_options[$key])) {
            return $this->_options[$key]->value();
        }
        return $default;
    }

    function options()
    {
        return array_values($this->_options);
    }

    function conditions()
    {
        return $this->_conditions;
    }

    function formData($itemKey)
    {
        return array();
    }

    function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        return;
    }

    function toJsonSchema()
    {
        return '';
    }

    function allFields()
    {
        return array();
    }

}
