<?php

/**
 * ARK Event Form Type
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

namespace ARK\Form;

use ARK\Service;
use ARK\Model\Item;
use ARK\Model\Property;
use ARK\Model\Attribute;
use ARK\Model\TextFragment;
use ARK\Vocabulary\Term;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyMapper implements DataMapperInterface
{
    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        if ($data instanceof Property) {
            $this->mapPropertyToForms($data, $forms);
        }
        if ($data instanceof Item) {
            $this->mapPropertyToForms($data->property('HOW???'), $forms);
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        if ($data instanceof Property) {
            $this->mapFormsToProperty($forms, $data);
        }
        if ($data instanceof Item) {
            $this->mapFormsToProperty($forms, $data->property('HOW???'));
        }
    }

    public function mapPropertyToForms(Property $property, array $forms)
    {
        $attribute = $property->attribute();
        $value = $property->value();
        if ($attribute->format()->hasAttributes()) {
            foreach ($attribute->format()->attributes() as $sub) {
                $key = $sub->name();
                $forms[$key]->setData($value[$key]);
            }
        } else {
            $forms[$attribute->name()]->setData($value);
        }
    }

    public function mapFormsToProperty(array $forms, Property &$property)
    {
        $attribute = $property->attribute();
        if ($attribute->format()->hasAttributes()) {
            $value = [];
            foreach ($forms as $key => $form) {
                $value[$key] = $forms[$key]->getData();
            }
        } else {
            $value = $forms[$attribute->name()]->getData();
        }
        $property->setValue($value);
    }
}
