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

class Element
{
    protected $_id = '';
    protected $_valid = false;
    protected $_type = '';
    protected $_isGroup = false;
    protected $_title = '';
    protected $_description = '';
    protected $_alias = null;
    protected $_options = array();
    protected $_conditions = array();

    // {{{ __construct()
    function __construct(Database $db, $element_id = null, $element_type = '')
    {
        $this->_id = $element_id;
        $this->_alias = new Alias($db);
        if (!$element_id) {
            return;
        }
        $sql = "
            SELECT cor_conf_element.*, cor_conf_element_type.is_group, cor_conf_element_type.conf_table, cor_conf_element_type.conf_key
            FROM cor_conf_element
            LEFT JOIN cor_conf_element_type
            ON cor_conf_element.element_type = cor_conf_element_type.element_type
            WHERE cor_conf_element.element_id = ?
        ";
        $values[] = $element_id;
        if ($element_type) {
            $sql .= ' AND cor_conf_element.element_type = ?';
            $values[] = $element_type;
        }
        $config = $db->config()->fetchAssoc($sql, $values);
        $this->_type = $config['element_type'];
        $this->_isGroup = $config['is_group'];
        $this->_title = $config['markup'];
        $this->_description = $config['description'];
        $this->_table = $config['conf_table'];
        $this->_key = $config['conf_key'];
        $this->_alias = Alias::elementAlias($db, $element_id);
        $this->_options = Option::fetchOptions($db, $element_id);
        $this->_conditions = Condition::fetchConditions($db, $element_id);
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
    // {{{ type()
    function type()
    {
        return $this->_type;
    }
    // }}}
    // {{{ isGroup()
    function isGroup()
    {
        return $this->_isGroup;
    }
    // }}}
    // {{{ title()
    function title()
    {
        return $this->_title;
    }
    // }}}
    // {{{ description()
    function description()
    {
        return $this->_description;
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
    // {{{ conditions()
    function conditions()
    {
        return $this->_conditions;
    }
    // }}}
    // {{{ formData()
    function formData($itemKey)
    {
        return array();
    }
    // }}}
    // {{{ buildForm()
    function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        return;
    }
    // }}}
    // {{{ toJsonSchema()
    function toJsonSchema()
    {
        return '';
    }
    // }}}
    // {{{ allFields()
    function allFields()
    {
        return array();
    }
    // }}}
    // {{{ fetchGroupArrays()
    static function fetchGroupArrays(Database $db, $parent_id, $child_type = null, $enabled = true)
    {
        $where = 'cor_conf_group.element_id = ?';
        $values[] = $parent_id;
        if ($child_type) {
            $where .= ' AND cor_conf_element.element_type = ?';
            $values[] = $child_type;
        }
        if ($enabled != NULL) {
            $where .= ' AND cor_conf_group.enabled = ?';
            $values[] = $enabled;
        }
        $sql = "
            SELECT cor_conf_group.*, cor_conf_element.element_type AS child_type
            FROM cor_conf_group
            INNER JOIN cor_conf_element
            ON cor_conf_group.child_id = cor_conf_element.element_id
            WHERE $where
        ";
        try {
            return $db->config()->fetchAll($sql, $values);
        } catch (DBALException $e) {
            return array();
        }
    }
    // }}}
}
