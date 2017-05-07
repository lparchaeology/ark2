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
use ARK\Form\Type\AbstractFormType;
use ARK\Form\Type\StaticType;
use ARK\ORM\ORM;
use ARK\Model\Item;
use ARK\Model\LocalText;
use ARK\Vocabulary\Term;
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
        if ($options['field']['value']['mode'] == 'static') {
            $builder->add('content', StaticType::class, $fieldOptions);
        } else {
            $builder->add('content', TextType::class, $fieldOptions);
        }
        $builder->setDataMapper($this);
    }

    protected function options()
    {
        return [
            'compound' => true,
            'display_property' => 'id',
        ];
    }

    public function mapDataToForms($property, $forms)
    {
        if (!$property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $value = $property->value();
        if ($value instanceof Item) {
            $forms['module']->setData($value->schema()->module()->name());
            $forms['item']->setData($value->id());
            // TODO Make generic using module!
            $options = $forms['module']->getParent()->getConfig()->getOptions();
            if (isset($options['field']['value']['options']['display_property'])) {
                $display = $options['field']['value']['options']['display_property'];
                $val = $value->property($display)->value();
                if ($val instanceof Term) {
                    $name = $val->keyword();
                } elseif ($val instanceof LocalText) {
                    $name = $val->content();
                } else {
                    $name = $val;
                }
            } elseif (isset($options['display_property'])) {
                $display = $options['display_property'];
                $name = $value->property($display)->serialize();
            } else {
                $name = $value->property('id')->serialize();
            }
            $forms['content']->setData($name);
        } elseif (isset($value['item'])) {
            $forms['module']->setData($value['module']);
            $forms['item']->setData($value['item']);
            $forms['content']->setData('');
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
