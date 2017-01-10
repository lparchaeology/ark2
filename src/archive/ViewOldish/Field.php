<?php

/**
 * ARK View Field
 *
 * Copyright (C) 2017  L - P : Heritage LLP.
 *
 * This file is part of ARK, the Archaeological Recording Kit.
 *
 * ARK is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ARK is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ARK.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     John Layt <j.layt@lparchaeology.com>
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\View;

use ARK\Database\Database;
use ARK\Model\Item\Item;
use ARK\Model\Property\Property;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type;

class Field extends Element
{
    public function formData(/*bool*/ $trans = false)
    {
        return $this->itemData($this->resource, $trans);
    }

    public function itemData(Item $item, /*bool*/ $trans = false)
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
        if (!$this->property()) {
            return array();
        }
        $values = $item->attribute($this->property());
        if (is_array($values) && isset($values[0])) {
            $values = $values[0];
        }
        switch ($this->property()->type()) {
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
                    $data[$this->id()] = $values[1];
                }
                break;
            case 'string':
                if ($values) {
                    if ($this->property()->id() == 'item') {
                        if ($trans) {
                            if ($item->parent()) {
                                $data[$this->id()] = '<a href="'.$item->module()->type().'/'.$item->index().'">'.$item->name().'</a>';
                            } else {
                                $data[$this->id()] = '<a href="'.$item->index().'">'.$item->name().'</a>';
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

    public function buildForm(FormBuilder $formBuilder, array $options = array())
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
        if (!$this->property()) {
            return;
        }
        $options['label'] = $this->keyword() ? $this->keyword() : false;
        switch ($this->property()->type()) {
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

    public static function loadMetadata(ClassMetadata $metadata)
    {
    }
}
