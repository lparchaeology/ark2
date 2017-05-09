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
use Symfony\Component\Form\FormBuilderInterface;

class ClassificationType extends AbstractFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $valueOptions = $options['field']['value']['options'];
        // Not multi-vocality for now
        unset($valueOptions['multiple']);
        $field = $options['field']['object'];
        $format = $field->attribute()->format();

        $valueOptions['choices'] = $format->attribute('class')
            ->vocabulary()
            ->terms();
        $valueOptions['placeholder'] = ' - ';
        $valueOptions['required'] = true;
        $builder->add('class', $options['field']['value']['type'], $valueOptions);

        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('event', HiddenType::class, $fieldOptions);

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
            $value = $property->value();
            if ($value && $value[0]) {
                $event = $value[0]['event'];
                if ($event) {
                    $forms['event']->setData($event->id());
                }
                $class = $value[0]['class'];
                if ($class) {
                    $forms['class']->setData($class);
                }
            }
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        if ($property instanceof Property) {
            $event = $forms['event']->getData();
            if ($event) {
                $event = ORM::find(Event::class, $event);
            }
            $value['event'] = $event;
            $value['class'] = $forms['class']->getData();
            $property->setValue([$value]);
        }
    }
}
