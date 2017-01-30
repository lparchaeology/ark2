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

use ARK\ORM\ORM;
use ARK\Service;
use ARK\Model\Item;
use ARK\Model\Property;
use ARK\Entity\Actor;
use ARK\Form\Type\HiddenChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarouselType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $field = $options['field'];
        $attribute = $field->attribute()->name();
        $fieldOptions = $field->optionsArray();
        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('images', ChoiceType::class, $fieldOptions);
        $builder->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'field' => null,
            'data_class' => Property::class,
            'empty_data' => null,
        ]);
    }

    public function mapDataToForms($property, $forms)
    {
        $forms = iterator_to_array($forms);
        $attribute = $property->attribute();
        $value = $property->value();
        $forms['images']->setData($value);
    }

    public function mapFormsToData($forms, &$property)
    {
    }

    public function getBlockPrefix()
    {
        return 'carousel';
    }
}