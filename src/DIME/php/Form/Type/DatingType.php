<?php

/**
 * DIME Form Type
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
namespace DIME\Form\Type;

use ARK\Form\Type\TermChoiceType;
use ARK\Form\Type\AbstractFormType;
use ARK\Model\Property;
use ARK\ORM\ORM;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class DatingType extends AbstractFormType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $valueOptions = $options['field']['value']['options'];
        // Not multi-vocality for now
        unset($valueOptions['multiple']);
        $field = $options['field']['object'];
        $format = $field->attribute()->format();

        $builder->add('year', IntegerType::class, $valueOptions);
        $builder->add('year_span', IntegerType::class, $valueOptions);

        $valueOptions['choices'] = $format->attribute('period')
            ->vocabulary()
            ->terms();
        $valueOptions['placeholder'] = ' - ';
        $valueOptions['required'] = false;
        $builder->add('period', TermChoiceType::class, $valueOptions);
        $builder->add('period_span', TermChoiceType::class, $valueOptions);

        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('event', HiddenType::class, $fieldOptions);
        $builder->add('entered', HiddenType::class, $fieldOptions);

        $builder->setDataMapper($this);
    }

    protected function options()
    {
        return [
            'compound' => true
        ];
    }

    public function mapDataToForms($property, $forms)
    {
        $forms = iterator_to_array($forms);
        if ($property instanceof Property) {
            $value = $property->serialize();
            if ($value) {
                $value = $value[0];
                $forms['event']->setData($value['event']['item']);
                $forms['entered']->setData($value['entered']);
                $forms['year']->setData($value['year'][0]);
                $forms['year_span']->setData($value['year'][1]);
                $vocabulary = $property->attribute()
                    ->format()
                    ->attribute('period')
                    ->vocabulary();
                $forms['period']->setData($vocabulary->term($value['period'][0]));
                $forms['period_span']->setData($vocabulary->term($value['period'][1]));
            }
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        if ($property instanceof Property) {
            $value['event']['module'] = 'event';
            $value['event']['item'] = $forms['event']->getData();
            $value['entered'] = $forms['entered']->getData();
            $value['year'][0] = $forms['year']->getData();
            $value['year'][1] = $forms['year_span']->getData();
            $value['period'][0] = $forms['period']->getData();
            $value['period'][1] = $forms['period_span']->getData();
            $property->setValue([
                $value
            ]);
        }
    }
}
