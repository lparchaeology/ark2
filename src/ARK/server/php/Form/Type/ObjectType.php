<?php

/**
 * ARK Event Form Type.
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
 */

namespace ARK\Form\Type;

use ARK\Model\Attribute;
use ARK\Model\Property;
use ARK\Translation\Translation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjectType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, iterable $options) : void
    {
        $field = $options['state']['field'];
        $fieldOptions = [];
        if ($field->attribute()->vocabulary() && isset($options['attr']['readonly'])) {
            $fieldOptions['disabled'] = true;
        }
        $builder->setDataMapper($this);
        $this->buildAttribute($builder, $field->attribute(), $fieldOptions);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'state' => null,
            'expanded' => null,
            'multiple' => null,
            'data_class' => Property::class,
            'empty_data' => null,
            'default_data' => null,
        ]);
    }

    public function mapDataToForms($property, $forms) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $attribute = $property->attribute();
        $value = $property->value();
        if ($attribute->dataclass()->datatype()->isObject()) {
            foreach ($attribute->dataclass()->attributes() as $sub) {
                $key = $sub->name();
                if ($key && isset($value[$key])) {
                    $forms[$key]->setData($value[$key]);
                } elseif ($sub->hasVocabulary() && $default = $sub->vocabulary()->defaultTerm()) {
                    $forms[$sub->name()]->setData($default);
                }
            }
        } elseif (is_array($value) && $value) {
            $parameter = $attribute->dataclass()->parameterName();
            if (isset($value[$parameter])) {
                $forms[$parameter]->setData($value[$parameter]);
            }
            $dataclass = $attribute->dataclass()->formatName();
            if (isset($value[$dataclass])) {
                $forms[$dataclass]->setData($value[$dataclass]);
            }
            $name = $attribute->dataclass()->valueName();
            $forms[$name]->setData($value[$name]);
        } elseif (!$value && $attribute->hasVocabulary() && $default = $attribute->vocabulary()->defaultTerm()) {
            $forms[$attribute->name()]->setData($default);
        } else {
            $forms[$attribute->name()]->setData($value);
        }
    }

    public function mapFormsToData($forms, &$property) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $value = [];
        foreach ($forms as $id => $form) {
            $value[$id] = $form->getData();
        }
        $property->setValue($value);
    }

    protected function buildAttribute(FormBuilderInterface $builder, Attribute $attribute, array $options) : void
    {
        $name = $attribute->name();
        if ($attribute->dataclass()->datatype()->isObject()) {
            foreach ($attribute->dataclass()->attributes() as $child) {
                $this->buildAttribute($builder, $child, $options);
            }
            return;
        }
        if ($attribute->hasVocabulary()) {
            $class = ChoiceType::class;
            $options['choices'] = $attribute->vocabulary()->terms();
            $options['multiple'] = $attribute->hasMultipleOccurrences();
            $options['choice_value'] = 'name';
            $options['choice_name'] = 'name';
            $options['choice_label'] = 'keyword';
            $options['placeholder'] = Translation::translate('core.placeholder');
        } else {
            $class = $attribute->dataclass()->datatype()->activeFormType();
        }
        if ($attribute->dataclass()->datatype()->id() === 'datetime') {
            $options['widget'] = 'single_text';
            $options['html5'] = false;
            $options['attr']['class'] = 'datetimepicker';
        }
        if ($attribute->dataclass()->datatype()->id() === 'date') {
            $options['widget'] = 'single_text';
            $options['html5'] = false;
            $options['attr']['class'] = 'datepicker';
        }
        if ($attribute->dataclass()->datatype()->id() === 'time') {
            $options['widget'] = 'single_text';
            $options['html5'] = false;
            $options['attr']['class'] = 'timepicker';
        }
        $options['mapped'] = false;
        $options['label'] = false;
        $options['required'] = $attribute->isRequired();
        // HACK
        if ($name === 'museum') {
            $options['attr']['readonly'] = true;
        }
        $builder->add($name, $class, $options);
    }
}
