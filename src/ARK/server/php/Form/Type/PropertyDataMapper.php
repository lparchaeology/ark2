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

use ARK\Model\Property;
use Symfony\Component\Form\DataMapperInterface;

class PropertyDataMapper implements DataMapperInterface
{
    public function mapDataToForms($property, $forms)
    {
        $forms = iterator_to_array($forms);
        if (!$property instanceof Property) {
            return;
        }
        $attribute = $property->attribute();
        $value = $property->value();
        if (is_array($value) && $value) {
            $parameter = $attribute->format()->parameterName();
            if (isset($value[$parameter])) {
                $forms[$parameter]->setData($value[$parameter]);
            }
            $format = $attribute->format()->formatName();
            if (isset($value[$format])) {
                $forms[$format]->setData($value[$format]);
            }
            $name = $attribute->format()->valueName();
            $forms[$name]->setData($value[$name]);
        } else {
            $forms[$attribute->name()]->setData($value);
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        $attribute = $property->attribute();
        if ($attribute->format()->hasAttributes()) {
            $value = [];
            foreach ($forms as $key => $form) {
                $value[$key] = $forms[$key]->getData();
            }
        } else {
            $value = $forms[$attribute->name()]->getData();
        }
        $property->setValue($value);
    }
}