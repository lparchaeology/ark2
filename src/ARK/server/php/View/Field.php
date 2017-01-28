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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\View;

use ARK\ORM\ORM;
use ARK\Model\Item;
use ARK\ORM\ClassMetadata;
use ARK\Service;
use ARK\Vocabulary\Vocabulary;
use Symfony\Component\Form\FormBuilderInterface;

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
        if ($this->attribute) {
            return $this->attribute()->keyword();
        }
        return '';
    }

    public function formOptions()
    {
        if ($this->name() == 'dime_find_filter_kommune') {
            $options['vocabulary'] = ORM::find(Vocabulary::class, 'dime.denmark.kommune');
            $options['required'] = false;
        }
        if ($this->name() == 'dime_find_filter_type') {
            $options['vocabulary'] = ORM::find(Vocabulary::class, 'dime.find.type');
            $options['required'] = false;
        }
        if ($this->name() == 'dime_find_filter_material') {
            $options['vocabulary'] = ORM::find(Vocabulary::class, 'dime.material');
            $options['required'] = false;
        }
        if ($this->name() == 'dime_find_filter_period') {
            $options['vocabulary'] = ORM::find(Vocabulary::class, 'dime.period');
            $options['required'] = false;
        }
        $options['label'] = ($this->keyword() ? $this->keyword() : false);
        if ($this->attribute) {
            $name = $this->attribute->name();
            $options['field'] = $this;
            $options['mapped'] = false;
            //$options['property_path'] = "propertyArray[$name].value";
        }
        return $options;
    }

    public function formData($data)
    {
        if ($data instanceof Item && $this->attribute) {
            return $data->property($this->attribute->name());
        }
        if (is_array($data) && isset($data[$this->name()])) {
            return $data[$this->name()];
        }
        return null;
    }

    public function buildForm($data, FormBuilderInterface $builder)
    {
        $fieldBuilder = $this->formBuilder($data);
        $builder->add($fieldBuilder);
    }

    public function renderView($data, $forms = null, $form = null, Cell $cell = null, array $options = [])
    {
        if ($forms && $form && $this->template()) {
            $options['field'] = $this;
            $options['data'] = $this->formData($data);
            $options['forms'] = $forms;
            $options['form'] = $form;
            $options['formLabel'] = $cell->formLabel();
            return Service::renderView($this->template(), $options);
        }
        // FIXME Should probably have some way to use FormTypes here to render 'flat' compond values
        $value = null;
        if ($data instanceof Item and $this->attribute) {
            $value = 'FIXME: '.$this->element;
            if ($this->attribute->isAtomic()) {
                $value = $data->property($this->attribute->name())->value();
            } elseif ($this->attribute->format()->isAtomic()) {
                $value = $data->property($this->attribute->name())->value()[0];
            } elseif ($this->attribute->format()->type()->isAtomic()) {
                if ($this->attribute->format()->name() == 'shortlocaltext') {
                    $language = Service::locale();
                    $values = $data->property($this->attribute->name())->value();
                    foreach ($values as $trans) {
                        if ($trans['language'] == $language) {
                            return $trans['content'];
                        }
                    }
                    return $values[0]['content'];
                } elseif ($this->attribute->format()->serializeAsObject()) {
                    //
                } else {
                    foreach ($this->attribute->format()->attributes() as $attribute) {
                        if ($attribute->isRoot()) {
                            $value = $data->property($this->attribute->name())->value()[$attribute->name()];
                        }
                    }
                }
            }
            if ($value instanceof \DateTime) {
                return $value->format('Y-m-d H:i:s');
            }
        }
        return $value;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
    }
}
