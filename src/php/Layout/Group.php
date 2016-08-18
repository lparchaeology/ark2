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

use Symfony\Component\Form\FormBuilder;
use ARK\Database\Database;
use ARK\Form\Type\PanelType;

class Group extends Element
{
    protected $_grid = array();
    protected $_elements = array();

    function __construct(Database $db = null, $group_id = null, $modname = null, $modtype = null)
    {
        if ($db == null || $group_id == null) {
            return;
        }
        parent::__construct($db, $group_id);
        if (!$this->_isGroup) {
            return;
        }
        $children = $db->getGroupForModule($group_id, $modname, $modtype);
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
                case 'layout':
                    $element = Layout::fetchLayout($db, $child['child_id'], $modname, $modtype);
                    break;
                case 'subform':
                    $element = new Subform($db, $child['child_id'], $modname, $modtype);
                    break;
                default: // Page, Column, Schema
                    $element = new Group($db, $child['child_id'], $modname, $modtype);
                    break;
            }
            if (!$element->isValid()) {
                echo 'Not valid child element!!! '.$child['child_id'].' '.$child['child_type'].'<br/>';
                $this->_elements = array();
                return;
            }
            $this->_elements[] = $element;
            $this->_grid[$child['row']][$child['col']][$child['seq']] = $element;
        }
        $this->_valid = true;
    }

    function elements()
    {
        return $this->_elements;
    }

    function formData($itemKey)
    {
        $data = array();
        foreach ($this->_elements as $element) {
            $data = array_merge($data, $element->formData($itemKey));
        }
        return $data;
    }

    function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        if (!$this->isValid()) {
            return;
        }
        foreach ($this->_elements as $element) {
            $element->buildForm($formBuilder, $options);
        }
    }

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
}
