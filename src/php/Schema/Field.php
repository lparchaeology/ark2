<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Field.php
*
* ARK Schema Field
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Field.php
* @since      2.0
*
*/

namespace ARK\Schema;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type;

class Field extends Element
{
    private $_dataclass = '';
    private $_classtype = '';
    private $_editable = false;
    private $_hidden = false;
    private $_rules = array();
    private $_constraints = array();
    private $_attributes = array();

    // {{{ __construct()
    function __construct(Connection $db, $field_id = null)
    {
        if ($field_id == null) {
            return;
        }
        try {
            parent::__construct($db, $field_id, 'field');
            $config = $db->fetchAssoc('SELECT * FROM cor_conf_field WHERE field_id = ?', array($field_id));
            $this->_dataclass = $config['dataclass'];
            $this->_classtype = $config['classtype'];
            $this->_editable = (bool)$config['editable'];
            $this->_hidden = (bool)$config['hidden'];
            $this->_rules = Rule::fetchAllValidationRoles($db, $field_id);
            if ($this->_dataclass != 'xmi' && $this->_dataclass != 'geom') {
                $type = $config['dataclass'].'type';
                $tbl = 'cor_lut_'.$type;
                $class = $db->fetchAssoc("SELECT * FROM $tbl WHERE $type = ?", array($config['classtype']));
            }
            if ($this->_dataclass == 'attribute') {
                $attrs = $db->fetchAll('SELECT * FROM cor_lut_attribute WHERE attributetype = ?', array($class['id']));
                foreach ($attrs as $attr) {
                    $this->_attributes[] = $attr['attribute'];
                }
            }
            $this->_valid = true;
        } catch (DBALException $e) {
            echo 'Invalid config for field : '.$field_id;
            throw $e;
        }
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
    // {{{ constraints()
    function constraints()
    {
        return $this->_constraints;
    }
    // }}}
    // {{{ attributes()
    function attributes()
    {
        return $this->_attributes;
    }
    // }}}
    // {{{ buildForm()
    function buildForm(FormBuilder &$formBuilder)
    {
        if (!$this->isValid()) {
            return;
        }
        $options['label'] = $this->_title;
        switch ($this->dataclass()) {
            case 'action':
                $formBuilder->add($this->_id, Type\TextType::class, $options);
                break;
            case 'attribute':
                foreach ($this->_attributes as $val) {
                    $options['choices'][$val] = $val;
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
                $formBuilder->add($this->_id, Type\TextType::class, $options);
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
    // }}}
    // {{{ toJsonSchema()
    function toJsonSchema()
    {
        return '';
    }
    // }}}
    // {{{ fetchFields()
    static function fetchFields(Connection $db, $element_id, $enabled = true)
    {
        $children = Element::fetchGroupArrays($db, $element_id, 'field', $enabled);
        $fields = array();
        foreach ($children as $child) {
            $field = new Field($db, $child['child_id']);
            if ($field->isValid()) {
                $fields[] = $field;
            }
        }
        return $fields;
    }
    // }}}
}
