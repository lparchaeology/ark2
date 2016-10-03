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
use ARK\Model\AbstractResource;
use ARK\Model\Item;
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

    protected function init(array $config, AbstractResource $resource = null)
    {
        parent::init($config, $resource);
        $this->property = $config['property'];
        $this->editable = $config['editable'];
        $this->hidden = $config['hidden'];
        $this->rules = Rule::fetchAllValidationRoles($this->db, $this->id());
        $this->valid = true;
    }

    public function keyword()
    {
        if ($this->keyword) {
            return $this->keyword;
        }
        if ($this->property() && $this->property()->keyword()) {
            return $this->property()->keyword();
        }
        return $this->alias->keyword();
    }

    public function property()
    {
        return $this->resource->property($this->property);
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

    public function formData(bool $trans = false)
    {
        return $this->itemData($this->resource, $trans);
    }

    public function itemData(Item $item, bool $trans = false)
    {
        if (!$this->isValid()) {
            return array();
        }
        $data = array();
        //HACK Do properly!
        if ($this->id == 'submodules') {
            $subs = $item->submodules();
            foreach ($subs as $sub) {
                $data[$this->id()][] = '<a href="'.$sub->type().'">'.$sub->keyword().'</a>';
            }
            return $data;
        }
        $values = $item->attribute($this->property());
        if (is_array($values)) {
            $values = $values[0];
        }
        switch ($this->property()->dataclass()) {
            case 'blob':
            case 'boolean':
            case 'float':
            case 'integer':
            case 'span':
                if ($values) {
                    $data[$this->id()] = $values;
                }
                break;
            case 'date':
            case 'datetime':
            case 'time':
                if ($values) {
                    $data[$this->id()] = new \DateTime($values);
                }
                break;
            case 'text':
                if ($values) {
                    $data[$this->id()] = $values['en'];
                }
                break;
            case 'string':
                if ($values) {
                    if ($this->property()->id() == 'item') {
                        if ($trans) {
                            if ($item->parent()) {
                                $data[$this->id()] = '<a href="'.$item->module()->type().'/'.$item->index().'">'.$item->item().'</a>';
                            } else {
                                $data[$this->id()] = '<a href="'.$item->index().'">'.$item->item().'</a>';
                            }
                        } else {
                            $data[$this->id()] = $item->id();
                        }
                    } elseif ($this->property()->id() == 'modtype') {
                        if ($trans) {
                            $data[$this->id()] = 'module.'.$item->module()->id().'.modtype.'.$item->modtype();
                        } else {
                            $data[$this->id()] = $item->modtype();
                        }
                    } elseif ($trans && !$this->property()->literal()) {    
                        $data[$this->id()] = $this->property()->keyword().'.'.$values;
                    } else {
                        $data[$this->id()] = $values;
                    }
                }
                break;
            case 'file':
                if ($values) {
                    $data[$this->id()] = new File($values['filename'], false);
                }
                break;
            case 'action':
                if (isset($values[0]['actor_module']) and isset($values['actor_item'])) {
                    if ($trans) {
                        $data[$this->id()] = $values['actor_module'].'.'.$values['actor_item'].'.name';
                    } else {
                        $data[$this->id()] = $values['actor_module'].'.'.$values['actor_item'];
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
        //HACK Do properly!
        if ($this->id == 'submodules') {
            $options['label'] = false;
            $options['entry_type'] = Type\TextType::class;
            $options['entry_options'] = array('label' => false, 'attr' => array('readonly' => true));
            $formBuilder->add($this->id, Type\CollectionType::class, $options);
            return;
        }
        $options['label'] = $this->keyword() ? $this->keyword() : false;
        switch ($this->property()->dataclass()) {
            case 'action':
                $options['choices']['--- Select One ---'] = null;
                $actors = $this->db->getActors();
                foreach ($actors as $actor) {
                    $options['choices']['actors.'.$actor['item'].'.name'] = 'act.'.$actor['item'];
                }
                $formBuilder->add($this->id, Type\ChoiceType::class, $options);
                break;
            case 'string':
                //TODO Only add null if allowed null
                $options['choices']['--- Select One ---'] = null;
                foreach ($this->property()->allowedValues() as $val => $keyword) {
                    $options['choices'][$keyword] = $val;
                }
                $formBuilder->add($this->id, Type\ChoiceType::class, $options);
                break;
            case 'date':
                $options['date_widget'] = 'single_text';
                $formBuilder->add($this->id, Type\DateType::class, $options);
                break;
            case 'time':
                $options['date_widget'] = 'single_text';
                $formBuilder->add($this->id, Type\TimeType::class, $options);
                break;
            case 'datetime':
                $options['date_widget'] = 'single_text';
                $formBuilder->add($this->id, Type\DateTimeType::class, $options);
                break;
            case 'file':
                $formBuilder->add($this->id, Type\FileType::class, $options);
                break;
            case 'number':
                $formBuilder->add($this->id, Type\NumberType::class, $options);
                break;
            case 'span':
                $options['entry_type'] = Type\TextType::class;
                $options['entry_options'] = array();
                $formBuilder->add($this->id, Type\CollectionType::class, $options);
                break;
            case 'text':
                if ($this->property()->input() == 'textarea') {
                    $formBuilder->add($this->id, Type\TextareaType::class, $options);
                } else {
                    $formBuilder->add($this->id, Type\TextType::class, $options);
                }
                break;
            case 'xmi':
                $options['entry_type'] = Type\TextType::class;
                $options['allow_add'] = true;
                $options['allow_delete'] = true;
                $options['entry_options'] = array();
                $formBuilder->add($this->id, Type\CollectionType::class, $options);
                break;
        }
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
