<?php

/**
 * ARK Abstract Form Type
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

use ARK\Model\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractFormType extends AbstractType implements DataMapperInterface, DataTransformerInterface
{
    private const OPTIONS = [
        'data_class' => Property::class,
        'empty_data' => null,
        'field' => null,
    ];

    protected function options()
    {
        return [];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array_merge(self::OPTIONS, $this->options()));
    }

    public function transform($value)
    {
        if ($value instanceof Property) {
            $name = $value->attribute()->name();
            $value = $value->value();
        }
        return $value;
    }

    public function reverseTransform($value)
    {
        return $value;
    }

    public function mapDataToForms($property, $forms)
    {
        $forms = iterator_to_array($forms);
        if ($property instanceof Property) {
            $name = $property->attribute()->name();
            $value = $property->value();
            $forms[$name]->setData($value);
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        $name = $property->attribute()->name();
        $value = $forms[$$name]->getData();
        $property->setValue($value);
    }
}
