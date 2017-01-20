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
use ARK\Model\TextFragment;
use ARK\Vocabulary\Term;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $field = $options['field'];
        $this->buildAttribute($builder, $field->attribute(), $field->optionsArray(), 'keyValue');
    }

    protected function buildAttribute(FormBuilderInterface $builder, $attribute, $options, $path)
    {
        $name = $attribute->name();
        $path = $path."[$name]";
        if ($attribute->format()->hasAttributes()) {
            foreach ($attribute->format()->attributes() as $child) {
                $this->buildAttribute($builder, $child, $options, $path);
            }
            return;
        }
        if ($attribute->vocabulary()) {
            $class = ChoiceType::class;
            foreach ($attribute->vocabulary()->terms() as $term) {
                $options['choices'][$term->keyword()] = $term->name();
            }
            if (!$attribute->isRequired()) {
                $options['placeholder'] = 'form.select.option';
            }
            $options['multiple'] = $attribute->hasMultipleOccurrences();
        } else {
            $class = $attribute->format()->type()->formClass();
        }
        $options['property_path'] = $path;
        $options['label'] = false;
        //$options['required'] = $attribute->isRequired();
        $builder->add($name, $class, $options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'field' => null,
            'data_class' => Property::class,
            'empty_data' => null,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'property';
    }
}
