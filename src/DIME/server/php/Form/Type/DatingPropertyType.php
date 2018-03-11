<?php

/**
 * DIME Form Type.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace DIME\Form\Type;

use ARK\Entity\Event;
use ARK\Form\Type\AbstractPropertyType;
use ARK\Model\Property;
use ARK\ORM\ORM;
use ARK\Translation\Translation;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DatingPropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $valueOptions = $options['state']['value']['options'];
        $integerOptions = $valueOptions;
        $field = $options['state']['field'];
        $dataclass = $field->attribute()->dataclass();

        if (isset($options['state']['static'])) {
            $displayOptions = $options['state']['display']['options'];
            $displayOptions['label'] = 'dime.dating.period';
            $builder->add('display_period', $options['state']['display']['type'], $displayOptions);
            $displayOptions['label'] = 'dime.dating.year';
            $builder->add('display_year', $options['state']['display']['type'], $displayOptions);
            $integerType = HiddenType::class;
        } else {
            $valueOptions['choices'] = $dataclass->attribute('period')->vocabulary()->terms();
            $valueOptions['choice_value'] = 'name';
            $valueOptions['choice_name'] = 'name';
            $valueOptions['choice_label'] = 'keyword';
            $valueOptions['placeholder'] = 'core.placeholder';
            $options['state']['value']['type'] = ChoiceType::class;
            if (isset($valueOptions['attr']['readonly'])) {
                $valueOptions['attr']['class'] = 'readonly-select';
            }
            $integerType = TextType::class;
        }

        $builder->add('year', $integerType, $integerOptions);
        $builder->add('year_span', $integerType, $integerOptions);
        $valueOptions['label'] = 'dime.dating.from';
        $builder->add('period', $options['state']['value']['type'], $valueOptions);
        $valueOptions['label'] = 'dime.dating.to';
        $builder->add('period_span', $options['state']['value']['type'], $valueOptions);

        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('event', HiddenType::class, $fieldOptions);
        $builder->add('entered', HiddenType::class, $fieldOptions);

        $builder->setDataMapper($this);
    }

    public function mapDataToForms($property, $forms) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $options = $this->propertyOptions($forms);
        $forms = iterator_to_array($forms);
        $value = $property->value();
        if ($value) {
            if (isset($options['state']['static'])) {
                $forms['display_year']->setData($value['year'][0].' - '.$value['year'][1]);
                $p0 = ($value['period'][0] ? $value['period'][0]->keyword() : '');
                $p1 = ($value['period'][1] ? $value['period'][1]->keyword() : '');

                $p0 = Translation::translate($p0);
                $p1 = Translation::translate($p1);
                if ($p1 && $p1 !== $p0) {
                    $forms['display_period']->setData($p0.' - '.$p1);
                } else {
                    $forms['display_period']->setData($p0);
                }
                if ($p0) {
                    $forms['period']->setData($value['period'][0]->name());
                }
                if ($p1) {
                    $forms['period_span']->setData($value['period'][1]->name());
                }
            } else {
                if ($value['period'][0]) {
                    $forms['period']->setData($value['period'][0]);
                }
                if ($value['period'][1]) {
                    $forms['period_span']->setData($value['period'][1]);
                }
            }
            $forms['year']->setData($value['year'][0]);
            $forms['year_span']->setData($value['year'][1]);

            $forms['event']->setData($value['event']['id']);
            $forms['entered']->setData($value['entered']);
        }
    }

    public function mapFormsToData($forms, &$property) : void
    {
        $forms = iterator_to_array($forms);
        if ($property instanceof Property) {
            $event = $forms['event']->getData();
            if ($event) {
                $event = ORM::find(Event::class, $event);
            }
            $value['event'] = $event;
            $value['entered'] = $forms['entered']->getData();
            $value['year'][0] = $forms['year']->getData();
            $value['year'][1] = $forms['year_span']->getData();
            if ($value['year'][0] === null && $value['year'][1] === null) {
                unset($value['year']);
            }
            $value['period'][0] = $forms['period']->getData();
            $value['period'][1] = $forms['period_span']->getData();
            if ($value['period'][0] === null && $value['period'][1] === null) {
                unset($value['period']);
            }
            if (isset($value['year'][0]) || isset($value['period'][0])) {
                $property->setValue($value);
            } else {
                $property->setValue(null);
            }
        }
    }

    protected function options()
    {
        return [
                'compound' => true,
        ];
    }
}
