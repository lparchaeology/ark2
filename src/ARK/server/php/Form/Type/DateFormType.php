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

use ARK\Form\Type\AbstractFormType;
use ARK\Model\Property;
use DateTime;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DateFormType extends AbstractFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setDataMapper($this);
        $builder->addModelTransformer($this);
    }

    protected function options()
    {
        return [
            'data_class' => null,
            'widget' => 'single_text',
            'html5' => false,
            'attr' => ['class' => 'datepicker'],
        ];
    }

    public function transform($property)
    {
        if (!$property) {
            return new DateTime;
        }
        return ($property->value() ?: new DateTime);
    }

    public function reverseTransform($value)
    {
        return $value;
    }

    public function mapDataToForms($property, $forms)
    {
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        $name = $property->attribute()->name();
        $value = $forms[$$name]->getData();
        $property->setValue($value);
    }

    public function getParent()
    {
        return DateType::class;
    }
}
