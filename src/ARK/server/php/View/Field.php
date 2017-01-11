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
    public function attribute()
    {
        return $this->attribute;
    }

    public function keyword()
    {
        if ($this->keyword) {
            return $this->keyword;
        }
        return $this->attribute()->keyword();
    }

    public function formData($resource, $form = '')
    {
        $value = $resource->property($this->attribute()->name());
        if (empty($value)) {
            return [];
        }
        // TODO Fixme to work with new FormatAttribute
        if (is_array($value)) {
            if ($this->attribute()->format()->type()->name() == 'text') {
                $value = $value[1];
            } else {
                $value = $value[0];
            }
        }
        if ($this->attribute()->format()->type()->name() == 'date') {
            $value = new \DateTime($value);
        }
        return [$this->element => $value];
    }

    public function buildForm(FormBuilder $formBuilder, array $options = array())
    {
        //HACK Do properly!
        if ($this->element == 'submodules') {
            $options['label'] = false;
            $options['entry_type'] = Type\TextType::class;
            $options['entry_options'] = array('label' => false, 'attr' => array('readonly' => true));
            $formBuilder->add($this->element, Type\CollectionType::class, $options);
            return;
        }
        if (!$this->attribute()) {
            return;
        }
        $options['label'] = $this->keyword() ? $this->keyword() : false;
        switch ($this->attribute()->format()->type()->name()) {
            case 'action':
                $options['choices']['--- Select One ---'] = null;
                $actors = $this->db->getActors();
                foreach ($actors as $actor) {
                    $options['choices']['actors.'.$actor['item'].'.name'] = 'act.'.$actor['item'];
                }
                $formBuilder->add($this->element, Type\ChoiceType::class, $options);
                break;
            case 'string':
                //TODO Only add null if allowed null
                if ($this->attribute()->vocabulary()) {
                    $options['choices']['--- Select One ---'] = null;
                    foreach ($this->attribute()->vocabulary()->terms() as $term) {
                        $options['choices'][$term->keyword()] = $term->name();
                    }
                    $formBuilder->add($this->element, Type\ChoiceType::class, $options);
                } else {
                    $formBuilder->add($this->element, Type\TextType::class, $options);
                }
                break;
            case 'date':
                //$options['date_widget'] = 'single_text';
                $formBuilder->add($this->element, Type\DateType::class, $options);
                break;
            case 'time':
                //$options['date_widget'] = 'single_text';
                $formBuilder->add($this->element, Type\TimeType::class, $options);
                break;
            case 'datetime':
                //$options['date_widget'] = 'single_text';
                $formBuilder->add($this->element, Type\DateTimeType::class, $options);
                break;
            case 'file':
                $formBuilder->add($this->element, Type\FileType::class, $options);
                break;
            case 'number':
                $formBuilder->add($this->element, Type\NumberType::class, $options);
                break;
            case 'span':
                $options['entry_type'] = Type\TextType::class;
                $options['entry_options'] = array();
                $formBuilder->add($this->element, Type\CollectionType::class, $options);
                break;
            case 'text':
                if ($this->attribute()->format()->input() == 'textarea') {
                    $formBuilder->add($this->element, Type\TextareaType::class, $options);
                } else {
                    $formBuilder->add($this->element, Type\TextType::class, $options);
                }
                break;
            case 'xmi':
                $options['entry_type'] = Type\TextType::class;
                $options['allow_add'] = true;
                $options['allow_delete'] = true;
                $options['entry_options'] = array();
                $formBuilder->add($this->element, Type\CollectionType::class, $options);
                break;
        }
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
    }
}
