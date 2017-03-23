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

use ARK\Form\Type\AbstractFormType;
use DateTime;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventType extends AbstractFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('on', DateTimeType::class, $fieldOptions);
        $builder->add('by', TextType::class, $fieldOptions);
        $builder->setDataMapper($this);
    }

    protected function options()
    {
        return [
            'compound' => true,
            'empty_data' => ['on' => new DateTime, 'by' => ''],
        ];
    }

    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        $forms['on']->setData($data['on']);
        $forms['by']->setData($data['by']);
    }

    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data['on'] = $forms['on']->getData();
        $data['by'] = $forms['by']->getData();
    }
}
