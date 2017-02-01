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
 * @php        >=5.6, >=7.0
 */

namespace ARK\Form\Type;

use ARK\Service;
use ARK\Model\Item;
use ARK\Model\Property;
use ARK\Model\Fragment\TextFragment;
use Brick\Geo\Point;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WktType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attribute = $options['field']->attribute()->name();
        $fieldOptions['mapped'] = false;
        $fieldOptions['label'] = 'lat';
        $builder->add('easting', TextType::class, $fieldOptions);
        $fieldOptions['label'] = 'lon';
        $builder->add('northing', TextType::class, $fieldOptions);
        $fieldOptions['label'] = false;
        $builder->add('srid', HiddenType::class, $fieldOptions);
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
        $value = $property->value();
        if ($value['coordinates']) {
            $point = Point::fromText($value['coordinates'], (int)$value['srid']);
            $forms['easting']->setData($point->x());
            $forms['northing']->setData($point->y());
            $forms['srid']->setData($point->SRID());
        } else {
            $forms['srid']->setData(4326);
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        $point = Point::xy($forms['easting']->getData(), $forms['northing']->getData(), $forms['srid']->getData());
        $value['coordinates'] = $point->asText();
        $value['srid'] = $point->SRID();
        $property->setValue($value);
    }

    public function getBlockPrefix()
    {
        return 'wkt';
    }
}
