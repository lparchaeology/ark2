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

use ARK\Form\Type\ScalarFormType;
use ARK\Model\Property;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class VocabularyFormType extends ScalarFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        if ($data instanceof Property) {
            $value = $data->value();
            $format = $data->attribute()->format();
            $forms[$format->valueName()]->setData($value);
            if ($format->parameterName() == 'concept') {
                $forms[$format->parameterName()]->setData($data->attribute()->vocabulary()->concept());
            }
        }
    }

    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        if ($data instanceof Property) {
            $format = $data->attribute()->format();
            $value = null;
            if ($format->isAtomic()) {
                $value = $forms[$format->valueName()]->getData();
            } else {
                foreach ($forms as $key => $form) {
                    $value[$key] = $forms[$key]->getData();
                }
            }
        }
        $data->setValue($value);
    }

    public function getParent()
    {
        return ScalarFormType::class;
    }
}
