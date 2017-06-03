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

use ARK\Form\Type\ScalarPropertyType;
use ARK\Model\Property;
use ARK\Vocabulary\Term;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class VocabularyPropertyType extends ScalarPropertyType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($property, $forms)
    {
        if (!$property instanceof Property) {
            return;
        }
        $term = $this->value($property, $forms);
        $forms = iterator_to_array($forms);
        $attribute = $property->attribute();
        $termForm = $forms[$attribute->format()->valueName()];
        $vocabularyForm = $forms[$attribute->format()->parameterName()];
        $termForm->setData($term);
        $vocabularyForm->setData($attribute->vocabulary()->concept());
    }

    public function mapFormsToData($forms, &$property)
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $property->setValue($forms[$property->attribute()->format()->valueName()]->getData());
    }

    public function getParent()
    {
        return ScalarPropertyType::class;
    }
}
