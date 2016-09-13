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
    private $dataclass = '';
    private $classtype = '';
    private $editable = false;
    private $hidden = false;
    private $rules = array();
    private $constraints = array();
    private $attributes = array();

    public function __construct(Database $db = null, $field = null)
    {
        if ($db == null || $field == null) {
            return;
        }
        parent::__construct($db, $field, 'field');
        $config = $db->getDataClass($field);
        $this->dataclass = $config['dataclass'];
        $this->classtype = $config['classtype'];
        $this->editable = (bool)$config['editable'];
        $this->hidden = (bool)$config['hidden'];
        $this->rules = Rule::fetchAllValidationRoles($db, $field);
        if ($this->dataclass == 'attribute') {
            $type = $config['dataclass'].'type';
            $tbl = 'cor_lut_'.$type;
            $class = $db->data()->fetchAssoc("SELECT * FROM $tbl WHERE $type = ?", array($config['classtype']));
            $attrs = $db->data()->fetchAll('SELECT * FROM cor_lut_attribute WHERE attributetype = ?', array($class['attributetype']));
            foreach ($attrs as $attr) {
                $this->attributes[] = $attr['attribute'];
            }
        }
        if (!$this->alias()->isValid()) {
            $this->alias = Alias::dataclassAlias($this->dataclass, $this->classtype);
        }
        $this->db = $db;
        $this->valid = true;
    }

    public function dataclass()
    {
        return $this->dataclass;
    }

    public function classtype()
    {
        return $this->classtype;
    }

    public function editable()
    {
        return $this->editable;
    }

    public function hidden()
    {
        return $this->hidden;
    }

    public function validationRules($vldRole)
    {
        if (array_key_exists($vldRole, $this->rules)) {
            return $this->rules[$vldRole];
        }
        return array();
    }

    public function constraints()
    {
        return $this->constraints;
    }

    public function attributes()
    {
        return $this->attributes;
    }

    public function formData(Item $item)
    {
        if (!$this->isValid()) {
            return array();
        }
        dump($item);
        $data = array();
        switch ($this->dataclass()) {
            case 'action':
                $action = $this->db->getAction($item->module()->id(), $item->id(), $this->classtype());
                if (isset($action['actor_itemkey']) and isset($action['actor_itemvalue'])) {
                    $data[$this->id()] = $action['actor_itemkey'].'.'.$action['actor_itemvalue'];
                }
                break;
            case 'attribute':
                $row = $this->db->getAttribute($item->module()->id(), $item->id(), $this->classtype());
                if (isset($row['attribute'])) {
                    $data[$this->id()] = $row['attribute'];
                }
                break;
            case 'date':
                $row = $this->db->getDate($item->module()->id(), $item->id(), $this->classtype());
                if (isset($row['value'])) {
                    $data[$this->id()] = new \DateTime($row['value']);
                }
                break;
            case 'file':
                $row = $this->db->getFile($item->module()->id(), $item->id(), $this->classtype());
                if (isset($row['filename'])) {
                    $data[$this->id()] = $row['filename'];
                }
                break;
            case 'number':
                $row = $this->db->getNumber($item->module()->id(), $item->id(), $this->classtype());
                if (isset($row['value'])) {
                    $data[$this->id()] = $row['value'];
                }
                break;
            case 'span':
                $row = $this->db->getSpan($item->module()->id(), $item->id(), , $this->classtype());
                if (isset($row['beg']) && isset($row['end'])) {
                    $data[$this->id()] = array($row['beg'], $row['end']);
                }
                break;
            case 'txt':
                $row = $this->db->getString($item->module()->id(), $item->id(), $this->classtype(), 'en');
                debug($row);
                if (isset($row['value'])) {
                    $data[$this->id()] = $row['value'];
                }
                break;
            case 'xmi':
                $row = $this->db->getXmi($item->module()->id(), $item->id(), , $this->classtype());
                if (isset($row['xmi_itemkey']) && isset($row['xmi_itemvalue'])) {
                    $data[$this->id()] = array($row['xmi_itemkey'], $row['xmi_itemvalue']);
                }
                break;
        }
        return $data;
    }

    public function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        if (!$this->isValid()) {
            return;
        }
        $options['label'] = $this->alias()->tranKey();
        switch ($this->dataclass()) {
            case 'action':
                $options['choices']['--- Select One ---'] = null;
                $actors = $this->db->getActors();
                foreach ($actors as $actor) {
                    $options['choices']['act_cd.'.$actor['act_cd'].'.name'] = 'act_cd.'.$actor['act_cd'];
                }
                $formBuilder->add($this->id, Type\ChoiceType::class, $options);
                break;
            case 'attribute':
                //TODO Only add null if allowed null
                $options['choices']['--- Select One ---'] = null;
                foreach ($this->attributes as $val) {
                    $options['choices']['attribute.'.$this->classtype.'.'.$val.'.normal'] = $val;
                }
                $formBuilder->add($this->id, Type\ChoiceType::class, $options);
                break;
            case 'date':
                $options['date_widget'] = 'single_text';
                $formBuilder->add($this->id, Type\DateTimeType::class, $options);
                break;
            case 'file':
                $formBuilder->add($this->id, Type\FileType::class, $options);
                break;
            case 'itemkey':
                $formBuilder->add($this->id, Type\TextType::class, $options);
                break;
            case 'modtype':
                foreach ($this->attributes as $val) {
                    $options['choices'][$val] = $val;
                }
                $formBuilder->add($this->id, Type\ChoiceType::class, $options);
                break;
            case 'number':
                $formBuilder->add($this->id, Type\NumberType::class, $options);
                break;
            case 'span':
                $option['entry_type'] = Type\TextType::class;
                $option['entry_options'] = array();
                $formBuilder->add($this->id, Type\CollectionType::class, $options);
                break;
            case 'txt':
                $formBuilder->add($this->id, Type\TextareaType::class, $options);
                break;
            case 'xmi':
                $option['entry_type'] = Type\TextType::class;
                $option['allow_add'] = true;
                $option['allow_delete'] = true;
                $option['entry_options'] = array();
                $formBuilder->add($this->id, Type\CollectionType::class, $options);
                break;
        }
        return;
    }

    public function schema()
    {
        $schema = array('title' => $this->title);
        return array($this->id => $schema);
    }

    public static function fetchDataClasss(Database $db, $element, $enabled = true)
    {
        $children = $db->getGroup($element, 'field', $enabled);
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
