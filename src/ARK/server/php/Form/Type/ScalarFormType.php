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

use ARK\Form\Type\AbstractFormType;
use ARK\Model\Property;
use ARK\Vocabulary\Term;
use Symfony\Component\Form\FormBuilderInterface;

class ScalarFormType extends AbstractFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // TODO Get format/parm options properly
        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $field = $options['field'];
        $format = $field->attribute()->format();
        $builder->add($format->valueName(), $field->valueFormType(), $options['field_options']);
        if ($format->formatName()) {
            $builder->add($format->formatName(), $field->formatFormType(), $fieldOptions);
        }
        if ($format->parameterName()) {
            $builder->add($format->parameterName(), $field->parameterFormType(), $fieldOptions);
        }
        $builder->setDataMapper($this);
    }

    protected function options()
    {
        return [
            'compound' => true,
        ];
    }

    public function mapDataToForms($value, $forms)
    {
        $forms = iterator_to_array($forms);
        if ($value instanceof Property) {
            $val = $value->value();
            $format = $value->attribute()->format();
            if ($format->isAtomic()) {
                $forms[$format->valueName()]->setData($val);
                return;
            }
            $forms[$format->valueName()]->setData($val[$format->valueName()]);
            if ($format->formatName()) {
                $forms[$format->formatName()]->setData($val[$format->formatName()]);
            }
            if ($format->parameterName()) {
                $forms[$format->parameterName()]->setData($val[$format->parameterName()]);
            }
        }
    }

    public function mapFormsToData($forms, &$value)
    {
        $forms = iterator_to_array($forms);
        if ($value instanceof Property) {
            $format = $value->attribute()->format();
            $val = null;
            if ($format->isAtomic()) {
                $val = $forms[$format->valueName()]->getData();
            } else {
                foreach ($forms as $key => $form) {
                    $val[$key] = $forms[$key]->getData();
                }
            }
        }
        $value->setValue($val);
    }
}
