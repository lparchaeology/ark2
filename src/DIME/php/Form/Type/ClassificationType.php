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
 use ARK\Model\Property;
 use Symfony\Component\Form\Extension\Core\Type\CollectionType;
 use Symfony\Component\Form\FormBuilderInterface;

 class ClassificationType extends AbstractFormType
 {
     public function buildForm(FormBuilderInterface $builder, array $options)
     {
         $fieldOptions['label'] = false;
         $fieldOptions['mapped'] = false;
         $builder->add('classifications', CollectionType::class, $fieldOptions);
         $builder->setDataMapper($this);
     }

     protected function options()
     {
         return [
             'compound' => true,
             'multiple' => true,
         ];
     }

     public function mapDataToForms($property, $forms)
     {
         if (!$property) {
             return;
         }
         $forms = iterator_to_array($forms);
         $name = $property->attribute()->name();
         $value = $property->value();
         $forms['classifications']->setData($value);
     }

     public function mapFormsToData($forms, &$property)
     {
     }
 }