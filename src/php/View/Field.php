<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/View/Field.php
*
* ARK View Field
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
* @see        http://ark.lparchaeology.com/code/src/php/View/Field.php
* @since      2.0
*
*/

namespace ARK\View;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type;
use ARK\Database\Database;
use ARK\Model\Property;

class Field extends Element
{
    private $property = '';
    private $editable = false;
    private $hidden = false;
    private $rules = array();

    protected function __construct(Database $db, string $field)
    {
        parent::__construct($db, $field);
    }

    protected function init(array $config)
    {
        parent::init($config);
        $this->property = $config['property'];
        $this->dataclass = $config['dataclass'];
        $this->editable = $config['editable'];
        $this->hidden = $config['hidden'];
        $this->rules = Rule::fetchAllValidationRoles($db, $this-id());
        $this->valid = true;
    }

    public function keyword()
    {
        if ($this->keyword) {
            return $this->keyword;
        }
        return $this->alias->keyword();
    }

    public function property()
    {
        return $this->property;
    }

    public function dataclass()
    {
        return $this->dataclass;
    }

    public function editable()
    {
        return $this->editable;
    }

    public function hidden()
    {
        return $this->hidden;
    }

    public function tooltip()
    {
        return $this->optionValue('tooltip', '');
    }

    public function widget()
    {
        return $this->optionValue('widget', '');
    }

    public function align()
    {
        return $this->optionValue('align', '');
    }

    public function rowSpan()
    {
        return $this->optionValue('rowSpan', 1);
    }

    public function colSpan()
    {
        return $this->optionValue('colSpan', 1);
    }

    public function sortable()
    {
        return $this->optionValue('sortable', true);
    }

    public function sortOrder()
    {
        return $this->optionValue('sortOrder', 'asc');
    }

    public function searchable()
    {
        return $this->optionValue('searchable', true);
    }

    public function validationRules(string $vldRole)
    {
        if (array_key_exists($vldRole, $this->rules)) {
            return $this->rules[$vldRole];
        }
        return array();
    }

    public function formData(Item $item, bool $trans = false)
    {
        if (!$this->isValid()) {
            return array();
        }
        $data = array();
        switch ($this->dataclass()) {
            case 'itemkey':
                if ($trans) {
                    $data[$this->id()] = '<a href="sites/'.$item->parent().'/'.$item->module()->id().'/'.$item->id().'">'.$item->id().'</a>';
                } else {
                    $data[$this->id()] = $item->id();
                }
                break;
            case 'modtype':
                if ($trans) {
                    $data[$this->id()] = $item->module()->id().'.'.$item->modtype().'.default';
                } else {
                    $data[$this->id()] = $item->modtype();
                }
                break;
            case 'text':
                $row = $this->db->getText($item->module()->id(), $item->id(), $this->property());
                if (isset($row['value'])) {
                    $data[$this->id()] = $row['value'];
                }
                break;
            case 'number':
                $row = $this->db->getNumber($item->module()->id(), $item->id(), $this->property());
                if (isset($row['value'])) {
                    $data[$this->id()] = $row['value'];
                }
                break;
            case 'date':
                $row = $this->db->getDate($item->module()->id(), $item->id(), $this->property());
                if (isset($row['value'])) {
                    $data[$this->id()] = new \DateTime($row['value']);
                }
                break;
            case 'span':
                $row = $this->db->getSpan($item->module()->id(), $item->id(), $this->property());
                if (isset($row['value'])) {
                    $data[$this->id()] = new \DateTime($row['value']);
                }
                break;
            case 'string':
                $row = $this->db->getString($item->module()->id(), $item->id(), $this->property());
                if (isset($row['attribute'])) {
                    if ($trans) {
                        $data[$this->id()] = 'property.'.$row['attributetype'].'.'.$row['attribute'].'.default';
                    } else {
                        $data[$this->id()] = $row['attribute'];
                    }
                }
                break;
            case 'file':
                $row = $this->db->getFile($item->module()->id(), $item->id(), $this->property());
                if (isset($row['filename'])) {
                    $data[$this->id()] = new File($row['filename'], false);
                }
                break;
            case 'action':
                $action = $this->db->getAction($item->module()->id(), $item->id(), $this->property());
                if (isset($action['actor_module']) and isset($action['actor_item'])) {
                    if ($trans) {
                        $data[$this->id()] = $action['actor_module'].'.'.$action['actor_item'].'.name';
                    } else {
                        $data[$this->id()] = $action['actor_module'].'.'.$action['actor_item'];
                    }
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
        $options['label'] = $this->alias()->keyword();
        switch ($this->dataclass()) {
            case 'action':
                $options['choices']['--- Select One ---'] = null;
                $actors = $this->db->getActors();
                foreach ($actors as $actor) {
                    $options['choices']['actors.'.$actor['item'].'.name'] = 'act.'.$actor['item'];
                }
                $formBuilder->add($this->id, Type\ChoiceType::class, $options);
                break;
            case 'attribute':
                //TODO Only add null if allowed null
                $options['choices']['--- Select One ---'] = null;
                foreach ($this->property->allowedValues() as $val) {
                    $options['choices']['property.'.$this->property().'.'.$val.'.default'] = $val;
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
                foreach ($this->property->allowedValues() as $val) {
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

    public static function fetchFields(Database $db, string $element, bool $enabled = true)
    {
        $children = $db->getGroup($element, 'field', $enabled);
        $fields = array();
        foreach ($children as $child) {
            $field = new Field($db, $child['child']);
            if ($field->isValid()) {
                $fields[] = $field;
            }
        }
        return $fields;
    }
}
