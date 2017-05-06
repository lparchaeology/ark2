<?php

/**
 * ARK Carousel Form Type
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

 namespace DIME\Form\Type;

use ARK\Form\Type\AbstractFormType;
use ARK\Form\Type\LocalTextType;
use ARK\Model\Property;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class DescriptionType extends AbstractFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $fieldOptions['entry_type'] = LocalTextType::class;
        $entryOptions['field'] = $options['field'];
        unset($entryOptions['field']['value']['options']['multiple']);
        $entryOptions['label'] = false;
        $entryOptions['mapped'] = false;
        $fieldOptions['entry_options'] = $entryOptions;
        dump($options);
        dump($fieldOptions);
        $builder->add('descriptions', CollectionType::class, $fieldOptions);
        //$builder->setDataMapper($this);
    }

    protected function options()
    {
        return [
             'compound' => true,
             'multiple' => true,
             'entry_type' => LocalTextType::class,
         ];
    }

    public function mapDataToForms($property, $forms)
    {
        if (!$property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $name = $property->attribute()->name();
        $value = $property->serialize();
        $data = [];
        foreach ($value as $text) {
            $data[] = $text['text'];
        }
        dump($property);
        dump($data);
        $forms['descriptions']->setData($data);
    }

    public function mapFormsToData($forms, &$property)
    {
    }
}
