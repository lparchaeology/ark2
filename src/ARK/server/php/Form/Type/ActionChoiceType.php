<?php

/**
 * ARK Action Choice Form Type
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
use ARK\Workflow\Action;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ActionChoiceType extends AbstractFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this);
    }

    protected function options()
    {
        return [
            'data_class' => null,
            'choice_value' => 'name',
            'choice_name' => 'name',
            'choice_label' => 'keyword',
            'placeholder' => 'core.action.choose',
            'placeholder_in_choices' => false,
        ];
    }

    public function transform($value)
    {
        if ($value instanceof Property) {
            return $value->value();
        }
        return $value;
    }

    public function reverseTransform($value)
    {
        return $value;
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
