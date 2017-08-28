<?php

/**
 * ARK Form Type.
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

namespace DIME\Form\Type;

use ARK\Form\Type\AbstractPropertyType;
use ARK\Model\Property;
use ARK\Vocabulary\Term;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

class UserTermsPropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $field = $options['state']['field'];
        $dataclass = $field->attribute()->dataclass();
        $builder->add('agree', CheckboxType::class, ['label' => 'core.user.terms.agree', 'required' => true]);
        $builder->add($dataclass->valueName(), HiddenType::class, []);
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($property, $forms) : void
    {
        if (!$property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $dataclass = $property->attribute()->dataclass();
        $value = $property->value();
        if ($value instanceof Term) {
            $forms[$dataclass->valueName()]->setData($value->name());
            $forms['agree']->setData(true);
        } else {
            $term = $property->attribute()->vocabulary()->defaultTerm();
            $forms[$dataclass->valueName()]->setData($term->name());
            $forms['agree']->setData(false);
        }
    }

    public function mapFormsToData($forms, &$property) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        if (!$forms['agree']->getData()) {
            return;
        }
        $dataclass = $property->attribute()->dataclass();
        $value = $forms[$dataclass->valueName()]->getData();
        $property->setValue($value);
    }

    protected function options()
    {
        return [
            'compound' => true,
        ];
    }
}
