<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Group.php
*
* ARK View Group
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Group.php
* @since      2.0
*
*/

namespace ARK\View;

use Symfony\Component\Form\FormBuilder;
use ARK\Database\Database;
use ARK\Model\Item;
use ARK\Model\Module;
use ARK\Form\Type\PanelType;

class Group extends Element
{
    protected $grid = array();
    protected $elements = array();

    public function __construct(Database $db = null, string $group = null, Module $module = null, string $modtype = null)
    {
        if ($db == null || $group == null) {
            return;
        }
        parent::__construct($db, $group);
        if (!$this->isGroup) {
            return;
        }
        $children = $db->getGroupForModule($group, $module->id(), $modtype);
        foreach ($children as $child) {
            switch ($child['child_type']) {
                case 'field':
                    $element = new Field($db, $child['child']);
                    break;
                case 'link':
                    $element = new Link($db, $child['child']);
                    break;
                case 'event':
                    $element = new Event($db, $child['child']);
                    break;
                case 'layout':
                    $element = Layout::fetchLayout($db, $child['child'], $module, $modtype);
                    break;
                case 'subform':
                    $element = new Subform($db, $child['child'], $module, $modtype);
                    break;
                default: // Page, Column
                    $element = new Group($db, $child['child'], $module, $modtype);
                    break;
            }
            if ($element->isValid()) {
                $this->elements[] = $element;
                $this->grid[$child['row']][$child['col']][$child['seq']] = $element;
            }
        }
        $this->valid = true;
    }

    public function elements()
    {
        return $this->elements;
    }

    public function formData(Item $item)
    {
        $data = array();
        foreach ($this->elements as $element) {
            $data = array_merge($data, $element->formData($item));
        }
        return $data;
    }

    public function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        if (!$this->isValid()) {
            return;
        }
        foreach ($this->elements as $element) {
            $element->buildForm($formBuilder, $options);
        }
    }

    public function allFields()
    {
        $fields = array();
        foreach ($this->elements as $element) {
            if ($element->type() == 'field') {
                $fields[] = $element;
            } else {
                $fields = array_merge($fields, $element->allFields());
            }
        }
        return $fields;
    }
}
