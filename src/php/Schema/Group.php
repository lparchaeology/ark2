<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Group.php
*
* ARK Schema Group
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Group.php
* @since      2.0
*
*/

namespace ARK\Schema;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Form\FormBuilder;
use ARK\Database\Database;
use ARK\Form\Type\PanelType;

class Group extends Element
{
    private $_viewState = '';
    private $_editState = '';
    private $_navType = '';
    private $_script = '';
    private $_label = NULL;
    private $_input = NULL;
    private $_elements = array();

    // {{{ __construct()
    function __construct(Database $db, $group_id = null)
    {
        if ($group_id == null) {
            return;
        }
        try {
            parent::__construct($db, $group_id);
            if (!$this->_isGroup) {
                return;
            }
            if ($this->type() == 'subform') {
                $sql = "
                    SELECT *
                    FROM cor_conf_subform
                    WHERE subform_id = ?
                ";
                $config = $db->config()->fetchAssoc($sql, array($group_id));
                $this->_viewState = $config['view_state'];
                $this->_editState = $config['edit_state'];
                $this->_navType = $config['nav_type'];
                $this->_title = $config['title'];
                $this->_script = $config['script'];
                $this->_label = $config['label'];
                $this->_input = $config['input'];
            }
            $sql = "
                SELECT cor_conf_group.*, cor_conf_element.element_type AS child_type
                FROM cor_conf_group
                LEFT JOIN cor_conf_element
                ON cor_conf_group.child_id = cor_conf_element.element_id
                WHERE cor_conf_group.element_id = ?
            ";
            $children = $db->config()->fetchAll($sql, array($group_id));
            foreach ($children as $child) {
                switch ($child['child_type']) {
                    case 'field':
                        $element = new Field($db, $child['child_id']);
                        break;
                    case 'link':
                        $element = new Link($db, $child['child_id']);
                        break;
                    case 'event':
                        $element = new Event($db, $child['child_id']);
                        break;
                    default:
                        $element = new Group($db, $child['child_id']);
                        break;
                }
                if (!$element->isValid()) {
                    echo 'Not valid element!!! '.$child['child_id'].' '.$child['child_type'].'<br/>';
                    $this->_elements = array();
                    return;
                }
                $this->_elements[] = $element;
            }
            $this->_valid = true;
        } catch (DBALException $e) {
            throw $e;
            return;
        }
    }
    // }}}
    // {{{ elements()
    function elements()
    {
        return $this->_elements;
    }
    // }}}
    // {{{ buildForm()
    function formData($itemKey)
    {
        $data = array();
        foreach ($this->_elements as $element) {
            $data = array_merge($data, $element->formData($itemKey));
        }
        return $data;
    }
    // }}}
    // {{{ buildForm()
    function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        if (!$this->isValid()) {
            return;
        }
        if ($this->_type == 'subform') {
            $options['label'] = false;
            $options['title'] = $this->_title;
            $options['elements'] = $this->_elements;
            $formBuilder->add($this->_id, PanelType::class, $options);
        } else {
            foreach ($this->_elements as $element) {
                $element->buildForm($formBuilder, $options);
            }
        }
    }
    // }}}
    // {{{ toSchema()
    function toSchema()
    {
        if (!$this->isValid()) {
            return '';
        }
        $schema = array();
        $schema['type'] = 'object';
        $schema['title'] = $this->_title;
        $schema['description'] = $this->_description;
        if (count($this->_elements)) {
            $schema['properties'] = array();
            foreach ($this->_elements as $element) {
                $schema['properties'] = array_merge($schema['properties'], $element->toSchema());
            }
        }
        $schema['additionalProperties'] = false;
        return array($this->_id => $schema);
    }
    // }}}
    // {{{ allFields()
    function allFields()
    {
        $fields = array();
        foreach ($this->_elements as $element) {
            if ($element->type() == 'field') {
                $fields[] = $element;
            } else {
                $fields = array_merge($fields, $element->allFields());
            }
        }
        return $fields;
    }
    // }}}
}
