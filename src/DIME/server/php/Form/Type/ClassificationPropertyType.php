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
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

class ClassificationPropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $valueOptions = $options['state']['value']['options'];
        $field = $options['state']['field'];
        $dataclass = $field->attribute()->dataclass();
        if (isset($options['state']['display'])) {
            $builder->add($options['state']['display']['name'], $options['state']['display']['type'], $options['state']['display']['options']);
        } else {
            $valueOptions['choices'] = $dataclass->attribute('subtype')->vocabulary()->terms();
            $valueOptions['choice_value'] = 'name';
            $valueOptions['choice_name'] = 'name';
            $valueOptions['choice_label'] = 'keyword';
            $valueOptions['placeholder'] = 'core.placeholder';
        }

        $builder->add('subtype', $options['state']['value']['type'], $valueOptions);

        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('event', HiddenType::class, $fieldOptions);
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
        if ($value && is_array($value)) {
            $event = $value['event'];
            if ($event) {
                $forms['event']->setData($event->id());
            }
            $subtype = $value['subtype'];
            if ($subtype) {
                if (isset($options['state']['display'])) {
                    $forms[$options['state']['display']['name']]->setData($subtype->keyword());
                } else {
                    $forms['subtype']->setData($subtype);
                }
            }
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
            $value['subtype'] = $forms['subtype']->getData();
            $property->setValue($value);
        }
    }

    protected function options()
    {
        return [
            'compound' => true,
        ];
    }
}
