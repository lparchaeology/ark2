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

use ARK\Actor\Actor;
use ARK\Form\Type\AbstractPropertyType;
use ARK\Form\Type\StaticType;
use ARK\ORM\ORM;
use ARK\Model\Item;
use ARK\Model\Property;
use ARK\Model\LocalText;
use ARK\Vocabulary\Term;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ItemPropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $field = $options['state']['field'];
        $format = $field->attribute()->format();
        if (isset($options['display'])) {
            $builder->add('display', $options['state']['value']['type'], $options['state']['value']['options']);
            $builder->add($format->valueName(), HiddenType::class, $options['state']['value']['options']);
        } else {
            $builder->add($format->valueName(), $options['state']['value']['type'], $options['state']['value']['options']);
        }
        if ($options['state']['parameter'] !== null) {
            $builder->add($format->parameterName(), $options['state']['parameter']['type'], $options['state']['parameter']['options']);
        }
        if ($options['state']['format'] !== null) {
            $builder->add($format->formatName(), $options['state']['format']['type'], $options['state']['format']['options']);
        }
        $builder->setDataMapper($this);
    }

    protected function options()
    {
        return [
            'compound' => true,
            'display' => null,
        ];
    }

    public function mapDataToForms($property, $forms)
    {
        if (!$property instanceof Property) {
            return;
        }
        $item = $this->value($property, $forms);
        $forms = iterator_to_array($forms);
        if ($item instanceof Item) {
            $forms['module']->setData($item->schema()->module()->name());
            $forms['item']->setData($item->id());
            // TODO Make generic using module!
            $options = $forms['module']->getParent()->getConfig()->getOptions();
            if (isset($options['display'])) {
                $val = $item->property($options['display'])->value();
                if ($val instanceof Term) {
                    $name = $val->keyword();
                } elseif ($val instanceof LocalText) {
                    $name = $val->content();
                } else {
                    $name = $val;
                }
            } else {
                $name = $item->property('id')->serialize();
            }
            $forms['display']->setData($name);
        } elseif (isset($item['item'])) {
            $forms['module']->setData($item['module']);
            $forms['item']->setData($item['item']);
            $forms['display']->setData('');
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $module = $forms['module']->getData();
        $item = $forms['item']->getData();
        if ($item) {
            // TODO Generic test exists
            $values['module'] = $module;
            $values['item'] = $item;
            $property->setValue($values);
        }
    }
}
