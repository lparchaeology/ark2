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
use ARK\Model\AbstractResource;
use ARK\Form\Type\PanelType;

abstract class Group extends Element
{
    protected $grid = array();
    protected $elements = array();

    protected function __construct(Database $db, string $group)
    {
        parent::__construct($db, $group);
    }

    protected function init(array $config, AbstractResource $resource = null)
    {
        parent::init($config, $resource);
        $children = $this->db->getGroupForModule($this->id, $resource->module()->id(), $resource->modtype());
        foreach ($children as $child) {
            $element = Element::get($this->db, $child['child'], $resource);
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

    public function formData()
    {
        $data = array();
        foreach ($this->elements as $element) {
            $data = array_merge($data, $element->formData());
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
