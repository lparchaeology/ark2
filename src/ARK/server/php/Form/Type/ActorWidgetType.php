<?php

/**
 * ARK Hidden Choice Form Type.
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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActorWidgetType extends AbstractType implements DataMapperInterface, DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder->setDataMapper($this);
        $builder->addModelTransformer($this);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'choice_value' => 'id',
            'choice_name' => 'id',
            'choice_label' => 'fullname',
            'state' => null,
            'placeholder' => 'core.placeholder',
            'required' => false,
            'attr' => [
                'style' => 'width: 100%',
            ],
        ]);
    }

    public function mapDataToForms($property, $forms) : void
    {
    }

    public function mapFormsToData($forms, &$property) : void
    {
    }

    public function transform($value) : void
    {
    }

    public function reverseTransform($value) : void
    {
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
