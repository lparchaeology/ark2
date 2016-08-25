<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/DataClass.php
*
* ARK Model DataClass
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/DataClass.php
* @since      2.0
*
*/

namespace ARK\Model;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type;
use ARK\Database\Database;

class DataClass extends Element
{
    private $_dataclass = '';
    private $_classtype = '';
    private $_editable = false;
    private $_hidden = false;
    private $_rules = array();
    private $_constraints = array();
    private $_attributes = array();

    function __construct(Database $db = null, $field_id = null)
    {
        if ($db == null || $field_id == null) {
            return;
        }
        parent::__construct($db, $field_id, 'field');
        $config = $db->getDataClass($field_id);
        $this->_dataclass = $config['dataclass'];
        $this->_classtype = $config['classtype'];
        $this->_editable = (bool)$config['editable'];
        $this->_hidden = (bool)$config['hidden'];
        $this->_rules = Rule::fetchAllValidationRoles($db, $field_id);
        if ($this->_dataclass == 'attribute') {
            $type = $config['dataclass'].'type';
            $tbl = 'cor_lut_'.$type;
            $class = $db->data()->fetchAssoc("SELECT * FROM $tbl WHERE $type = ?", array($config['classtype']));
            $attrs = $db->data()->fetchAll('SELECT * FROM cor_lut_attribute WHERE attributetype = ?', array($class['attributetype']));
            foreach ($attrs as $attr) {
                $this->_attributes[] = $attr['attribute'];
            }
        }
        if (!$this->alias()->isValid()) {
            $this->_alias = Alias::dataclassAlias($this->_dataclass, $this->_classtype);
        }
        $this->_db = $db;
        $this->_valid = true;
    }

    function dataclass()
    {
        return $this->_dataclass;
    }

    function classtype()
    {
        return $this->_classtype;
    }

    function editable()
    {
        return $this->_editable;
    }

    function hidden()
    {
        return $this->_hidden;
    }

    function validationRules($vld_role)
    {
        if (array_key_exists($vld_role, $this->_rules)) {
            return $this->_rules[$vld_role];
        } else {
            return array();
        }
    }

    function constraints()
    {
        return $this->_constraints;
    }

    function attributes()
    {
        return $this->_attributes;
    }

    function formData($itemKey)
    {
        if (!$this->isValid()) {
            return array();
        }
        $data = array();
        switch ($this->dataclass()) {
            case 'txt':
                $row = $this->_db->getText($itemKey['key'], $itemKey['value'], $this->classtype(), 'en');
                if (isset($row['txt'])) {
                    $data[$this->id()] = $row['txt'];
                }
                break;
            case 'number':
                $row = $this->_db->getNumber($itemKey, $this->classtype());
                if (isset($row['number'])) {
                    $data[$this->id()] = $row['number'];
                }
                break;
            case 'date':
                $row = $this->_db->getDate($itemKey['key'], $itemKey['value'], $this->classtype());
                if (isset($row['date'])) {
                    $data[$this->id()] = new \DateTime($row['date']);
                }
                break;
            case 'attribute':
                $row = $this->_db->getAttribute($itemKey['key'], $itemKey['value'], $this->classtype());
                if (isset($row['attribute'])) {
                    $data[$this->id()] = $row['attribute'];
                }
                break;
            case 'file':
                $row = $this->_db->getFile($itemKey, $this->classtype());
                if (isset($row['file'])) {
                    //$data[$this->id()] = $row['filename'];
                }
                break;
            case 'action':
                $action = $this->_db->getAction($itemKey['key'], $itemKey['value'], $this->classtype());
                if (isset($action['actor_itemkey']) and isset($action['actor_itemvalue'])) {
                    $data[$this->id()] = $action['actor_itemkey'].'.'.$action['actor_itemvalue'];
                }
                break;
        }
        return $data;
    }

    function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        if (!$this->isValid()) {
            return;
        }
        $options['label'] = $this->alias()->tranKey();
        switch ($this->dataclass()) {
            case 'action':
                $options['choices']['--- Select One ---'] = null;
                $actors = $this->_db->getActors();
                foreach ($actors as $actor) {
                    $options['choices']['act_cd.'.$actor['act_cd'].'.name'] = 'act_cd.'.$actor['act_cd'];
                }
                $formBuilder->add($this->_id, Type\ChoiceType::class, $options);
                break;
            case 'attribute':
                //TODO Only add null if allowed null
                $options['choices']['--- Select One ---'] = null;
                foreach ($this->_attributes as $val) {
                    $options['choices']['attribute.'.$this->_classtype.'.'.$val.'.normal'] = $val;
                }
                $formBuilder->add($this->_id, Type\ChoiceType::class, $options);
                break;
            case 'date':
                $options['date_widget'] = 'single_text';
                $formBuilder->add($this->_id, Type\DateTimeType::class, $options);
                break;
            case 'file':
                $formBuilder->add($this->_id, Type\FileType::class, $options);
                break;
            case 'itemkey':
                $formBuilder->add($this->_id, Type\TextType::class, $options);
                break;
            case 'modtype':
                foreach ($this->_attributes as $val) {
                    $options['choices'][$val] = $val;
                }
                $formBuilder->add($this->_id, Type\ChoiceType::class, $options);
                break;
            case 'number':
                $formBuilder->add($this->_id, Type\NumberType::class, $options);
                break;
            case 'span':
                $option['entry_type'] = Type\TextType::class;
                $option['entry_options'] = array();
                $formBuilder->add($this->_id, Type\CollectionType::class, $options);
                break;
            case 'txt':
                $formBuilder->add($this->_id, Type\TextareaType::class, $options);
                break;
            case 'xmi':
                $option['entry_type'] = Type\TextType::class;
                $option['allow_add'] = true;
                $option['allow_delete'] = true;
                $option['entry_options'] = array();
                $formBuilder->add($this->_id, Type\CollectionType::class, $options);
                break;
        }
        return;
    }

    function schema()
    {
        $schema = array('title' => $this->_title);
        return array($this->_id => $schema);
    }

    static function fetchDataClasss(Database $db, $element_id, $enabled = true)
    {
        $children = $db->getGroup($element_id, 'field', $enabled);
        $fields = array();
        foreach ($children as $child) {
            $field = new DataClass($db, $child['child_id']);
            if ($field->isValid()) {
                $fields[] = $field;
            }
        }
        return $fields;
    }

}
