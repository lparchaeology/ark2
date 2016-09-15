<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Element.php
*
* ARK View Element
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Element.php
* @since      2.0
*
*/

namespace ARK\View;

use Symfony\Component\Form\FormBuilder;
use ARK\Database\Database;
use ARK\Model\Item;

abstract class Element
{
    protected $id = '';
    protected $valid = false;
    protected $type = '';
    protected $isGroup = false;
    protected $title = '';
    protected $description = '';
    protected $table = '';
    protected $module = '';
    protected $modtype = '';
    protected $alias = null;
    protected $options = array();
    protected $conditions = array();

    // {{{ __construct()
    public function __construct(Database $db, string $element = null, string $elementType = null)
    {
        $this->alias = new Alias($db);
        if (!$element) {
            return;
        }
        $this->id = $element;
        $config = $db->getElement($element, $elementType);
        $this->type = $config['element_type'];
        $this->isGroup = $config['is_group'];
        $this->keyword = $config['keyword'];
        $this->table = $config['tbl'];
        $this->moduleId = $config['module'];
        $this->modtype = $config['modtype'];
        $this->alias = Alias::elementAlias($db, $element);
        $this->options = Option::fetchOptions($db, $element);
        $this->conditions = Condition::fetchConditions($db, $element);
    }

    public function id()
    {
        return $this->id;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function type()
    {
        return $this->type;
    }

    public function isGroup()
    {
        return $this->isGroup;
    }

    public function keyword()
    {
        dump($this->keyword);
        return $this->keyword;
    }

    public function table()
    {
        return $this->table;
    }

    public function moduleId()
    {
        return $this->moduleId;
    }

    public function modtype()
    {
        return $this->modtype;
    }

    public function alias()
    {
        return $this->alias;
    }

    public function option(string $key)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key];
        }
        return new Option();
    }

    public function optionValue(string $key, $default = null)
    {
        if (isset($this->options[$key])) {
            return $this->options[$key]->value();
        }
        return $default;
    }

    public function options()
    {
        return array_values($this->options);
    }

    public function conditions()
    {
        return $this->conditions;
    }

    public function formData(Item $item)
    {
        return array();
    }

    public function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        return;
    }

    public function allFields()
    {
        return array();
    }
}
