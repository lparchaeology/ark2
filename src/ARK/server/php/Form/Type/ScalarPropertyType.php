<?php

/**
 * ARK Item Form Type.
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

use ARK\Model\Property;
use Symfony\Component\Form\FormBuilderInterface;

class ScalarPropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, iterable $options) : void
    {
        $field = $options['state']['field'];
        $dataclass = $field->attribute()->dataclass();
        $builder->add($dataclass->valueName(), $options['state']['value']['type'], $options['state']['value']['options']);
        if ($options['state']['parameter'] !== null) {
            $builder->add($dataclass->parameterName(), $options['state']['parameter']['type'], $options['state']['parameter']['options']);
        }
        if ($options['state']['format'] !== null) {
            $builder->add($dataclass->formatName(), $options['state']['format']['type'], $options['state']['format']['options']);
        }
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($property, $forms) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms->rewind();
        $propertyForm = $forms->current()->getParent();
        $forms = iterator_to_array($forms);
        $attribute = $property->attribute();
        $dataclass = $attribute->dataclass();
        $valueName = $dataclass->valueName();
        $formatName = $dataclass->formatName();
        $parameterName = $dataclass->parameterName();

        $value = $property->value();
        if ($value === null || $value === $attribute->emptyValue()) {
            $value = $propertyForm->getConfig()->getOption('default_data');
        }

        if ($dataclass->isAtomic()) {
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

    public function mapFormsToData($forms, &$property) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $dataclass = $property->attribute()->dataclass();
        $value = null;
        if ($dataclass->isAtomic()) {
            $value = $forms[$dataclass->valueName()]->getData();
        } else {
            foreach ($forms as $key => $form) {
                $value[$key] = $forms[$key]->getData();
            }
        }
        $property->setValue($value);
    }

    protected function options() : iterable
    {
        return [
            'compound' => true,
        ];
    }
}
