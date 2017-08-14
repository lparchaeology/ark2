<?php

/**
 * ARK Event Form Type.
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
 */

namespace ARK\Form\Type;

use Brick\Geo\Point;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class WktPropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, iterable $options) : void
    {
        $fieldOptions['mapped'] = false;
        $fieldOptions['label'] = false;
        $fieldOptions['contraints'] = [];
        $builder->add('easting', TextType::class, $fieldOptions);
        $builder->add('northing', TextType::class, $fieldOptions);
        $builder->add('srid', HiddenType::class, $fieldOptions);
        $builder->add('format', HiddenType::class, $fieldOptions);
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($property, $forms) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $value = $this->value($property, $forms);
        $forms = iterator_to_array($forms);

        if ($value['geometry']) {
            $point = Point::fromText($value['geometry'], (int) $value['srid']);
            $forms['easting']->setData($point->x());
            $forms['northing']->setData($point->y());
            $forms['srid']->setData($point->SRID());
            $forms['format']->setData($value['format']);
        } else {
            $forms['srid']->setData(4326);
            $forms['format']->setData('wkt');
        }
    }

    public function mapFormsToData($forms, &$property) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $point = Point::xy($forms['easting']->getData(), $forms['northing']->getData(), $forms['srid']->getData());
        $value['geometry'] = $point->asText();
        $value['srid'] = $point->SRID();
        $value['format'] = $forms['format']->getData();
        $property->setValue($value);
    }

    protected function options() : iterable
    {
        return [
            'compound' => true,
        ];
    }
}
