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

use ARK\Entity\Actor;
use ARK\Form\Type\AbstractFormType;
use ARK\ORM\ORM;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ItemType extends AbstractFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions['attr']['readonly'] = true;
        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('module', HiddenType::class, $fieldOptions);
        $builder->add('item', HiddenType::class, $fieldOptions);
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
        if (!$property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $name = $property->attribute()->name();
        $value = $property->value();
        if ($value['item']) {
            $forms['module']->setData($value['module']);
            $forms['item']->setData($value['item']);
            // TODO Make generic using module!
            if ($item = ORM::find(Actor::class, $value['item'])) {
                $fullname = $item->property('fullname');
                $value = $fullname->value()[0];
                //$forms[$name]->setData($value['content']);
            }
        }
    }

    public function mapFormsToData($forms, &$property)
    {
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

    public function getParent()
    {
        return TextType::class;
    }
}
