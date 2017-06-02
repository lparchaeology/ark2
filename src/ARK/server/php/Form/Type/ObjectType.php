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

namespace ARK\Form\Type;

use ARK\Service;
use ARK\Model\Item;
use ARK\Model\Property;
use ARK\Model\Attribute;
use ARK\Model\TextFragment;
use ARK\Vocabulary\Term;
use ARK\Form\Type\TermChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjectType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $field = $options['field']['object'];
        $format = $field->attribute()->format();
        $fieldOptions = [];
        if ($field->attribute()->vocabulary() && isset($options['attr']['readonly'])) {
            $fieldOptions['disabled'] = true;
        }
        $builder->setDataMapper($this);
        $this->buildAttribute($builder, $field->attribute(), $fieldOptions, $field->attribute()->isRequired());
    }

    protected function buildAttribute(FormBuilderInterface $builder, Attribute $attribute, $options, $required)
    {
        $name = $attribute->name();
        if ($attribute->format()->datatype()->isObject()) {
            foreach ($attribute->format()->attributes() as $child) {
                $this->buildAttribute($builder, $child, $options, $required);
            }
            return;
        }
        if ($attribute->hasVocabulary()) {
            $class = TermChoiceType::class;
            $options['choices'] = $attribute->vocabulary()->terms();
            $options['multiple'] = $attribute->hasMultipleOccurrences();
        } else {
            $class = $attribute->format()->datatype()->valueFormType();
        }
        if ($attribute->format()->datatype()->id() == 'datetime') {
            $options['widget'] = 'single_text';
            $options['html5'] = false;
            $options['attr']['class'] = 'datetimepicker';
        }
        if ($attribute->format()->datatype()->id() == 'date') {
            $options['widget'] = 'single_text';
            $options['html5'] = false;
            $options['attr']['class'] = 'datepicker';
        }
        if ($attribute->format()->datatype()->id() == 'time') {
            $options['widget'] = 'single_text';
            $options['html5'] = false;
            $options['attr']['class'] = 'timepicker';
        }
        $options['mapped'] = false;
        $options['label'] = false;
        $options['required'] = $required;
        // HACK
        if ($name == 'museum') {
            $options['attr']['readonly'] = true;
        }
        $builder->add($name, $class, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'mode' => null,
            'field' => null,
            'expanded' => null,
            'multiple' => null,
            'data_class' => Property::class,
            'empty_data' => null,
            'default_data' => null,
        ]);
    }

    public function mapDataToForms($property, $forms)
    {
        $forms = iterator_to_array($forms);
        if (!$property) {
            return;
        }
        $attribute = $property->attribute();
        $value = $property->value();
        if ($attribute->format()->datatype()->isObject()) {
            foreach ($attribute->format()->attributes() as $sub) {
                $key = $sub->name();
                if ($key && isset($value[$key])) {
                    $forms[$key]->setData($value[$key]);
                }
            }
        } elseif (is_array($value) && $value) {
            $parameter = $attribute->format()->parameterName();
            if (isset($value[$parameter])) {
                $forms[$parameter]->setData($value[$parameter]);
            }
            $format = $attribute->format()->formatName();
            if (isset($value[$format])) {
                $forms[$format]->setData($value[$format]);
            }
            $name = $attribute->format()->valueName();
            $forms[$name]->setData($value[$name]);
        } else {
            $forms[$attribute->name()]->setData($value);
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        $value = [];
        foreach ($forms as $id => $form) {
            $value[$id] = $form->getData();
            dump($value[$id]);
        }
        dump($value);
        $property->setValue($value);
    }
}
