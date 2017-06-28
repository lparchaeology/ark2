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
 * @php        >=7.0
 */

namespace ARK\Form\Type;

use ARK\Actor\Actor;
use ARK\Form\Type\AbstractPropertyType;
use ARK\Model\Item;
use ARK\Model\LocalText;
use ARK\Model\Property;
use ARK\Vocabulary\Term;
use ARK\ORM\ORM;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ItemChoicePropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('item', $options['state']['value']['type'], $options['state']['value']['options']);
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($property, $forms)
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $item = $property->value();
        if ($item instanceof Item) {
            $options = $forms['item']->getParent()->getConfig()->getOptions();
            if ($options['state']['value']['modus'] == 'active') {
                $forms['item']->setData($item);
            } else {
                if (isset($options['state']['value']['display'])) {
                    $value = $item->property($options['state']['value']['display'])->value();
                    if ($value instanceof Term) {
                        $name = $value->keyword();
                    } elseif ($value instanceof LocalText) {
                        $name = $value->content();
                    } elseif ($value instanceof Actor) {
                        $name = $value->fullname();
                    } else {
                        $name = $value;
                    }
                } else {
                    $name = $item->property('id')->value();
                }
                $forms['item']->setData($name);
            }
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $value = $forms['item']->getData();
        if (is_string($value)) {
            $class = $property->attribute()->format()->entity();
            dump($class);
            $value = ORM::find($class, $value);
        }
        $property->setValue($value);
    }
}
