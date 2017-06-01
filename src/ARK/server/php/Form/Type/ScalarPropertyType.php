<?php

/**
 * ARK Item Form Type
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

use ARK\Form\Type\AbstractPropertyType;
use ARK\Model\Property;
use ARK\Vocabulary\Term;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScalarPropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $field = $options['field']['object'];
        $format = $field->attribute()->format();
        $builder->add($format->valueName(), $options['field']['value']['type'], $options['field']['value']['options']);
        if ($options['field']['parameter'] !== null) {
            $builder->add($format->parameterName(), $options['field']['parameter']['type'], $options['field']['parameter']['options']);
        }
        if ($options['field']['format'] !== null) {
            $builder->add($format->formatName(), $options['field']['format']['type'], $options['field']['format']['options']);
        }
        $builder->setDataMapper($this);
    }

    protected function options()
    {
        return [
            'compound' => true,
        ];
    }

    public function mapDataToForms($property, $forms)
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms->rewind();
        $propertyForm = $forms->current()->getParent();
        $forms = iterator_to_array($forms);
        $attribute = $property->attribute();
        $format = $attribute->format();
        $valueName = $format->valueName();
        $formatName = $format->valueName();
        $parameterName = $format->valueName();

        $value = $property->value();
        if ($value === null || $value == $attribute->emptyValue()) {
            $value = $propertyForm->getConfig()->getOption('default_data');
        }

        if ($format->isAtomic()) {
            $forms[$valueName]->setData($value);
            return;
        }

        $forms[$valueName]->setData($value[$valueName]);
        if ($formatName) {
            $forms[$formatName]->setData($value[$formatName]);
        }
        if ($parameterName) {
            $forms[$parameterName]->setData($value[$parameterName]);
        }
    }

    public function mapFormsToData($forms, &$value)
    {
        $forms = iterator_to_array($forms);
        if ($value instanceof Property) {
            $format = $value->attribute()->format();
            $val = null;
            if ($format->isAtomic()) {
                $val = $forms[$format->valueName()]->getData();
            } else {
                foreach ($forms as $key => $form) {
                    $val[$key] = $forms[$key]->getData();
                }
            }
        }
        $value->setValue($val);
    }
}
