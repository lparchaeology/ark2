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
use ARK\AbstractObject;
use ARK\Database\Database;
use ARK\Model\Item;

abstract class Element extends AbstractObject
{
    protected $isGroup = false;
    protected $alias = null;
    protected $options = array();
    protected $conditions = array();
    protected $item = null;

    protected function __construct(Database $db, string $element)
    {
        parent::__construct($db, $element);
    }

    protected function init(array $config, Item $item = null)
    {
        parent::init($config);
        $this->item = $item;
        $this->type = $config['type'];
        $this->isGroup = $config['is_group'];
        $this->keyword = $config['keyword'];
        $this->alias = Alias::elementAlias($this->db, $this->id);
        $this->options = Option::fetchOptions($this->db, $this->id);
        $this->conditions = Condition::fetchConditions($this->db, $this->id);
    }

    public function isGroup()
    {
        return $this->isGroup;
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

    public function formData()
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

    public static function get(Database $db, string $id, Item $item = null)
    {
        $config =  $db->getElement($id);
        if (!empty($config['class'])) {
            $element = new $config['class']($db, $id);
            $element->init($config, $item);
            return $element;
        }
        return new Layout($db, $id);
    }
}
