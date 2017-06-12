<?php

/**
 * ARK Abstract Form Type
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
use ARK\Model\LocalText;
use ARK\Vocabulary\Term;
use RecursiveIteratorIterator;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractPropertyType extends AbstractType implements DataMapperInterface, DataTransformerInterface
{
    protected $value;

    private $options = [
        'data_class' => null,
        'empty_data' => null,
        'default_data' => null,
        'hidden' => false,
        'state' => null,
    ];

    protected function options()
    {
        return [];
    }

    // Configure the *build* options only, not passed to view!
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array_merge($this->options, $this->options()));
    }

    public function getBlockPrefix()
    {
        return 'property';
    }

    // Use to transform data from the model to this form element
    public function transform($value)
    {
        if ($value instanceof Property) {
            return $value->value();
        }
        if ($value instanceof Term) {
            return $value->name();
        }
        if ($value instanceof LocalText) {
            return $value->content();
        }
        return $value;
    }

    // Use to transform data from this form element to the model
    public function reverseTransform($value)
    {
        return $value;
    }

    // Returns the data value to poulate the form with
    protected function value(Property $property, RecursiveIteratorIterator $forms)
    {
        $forms->rewind();
        $propertyForm = $forms->current()->getParent();
        $value = $property->value();
        if ($value === null || $value == $property->attribute()->emptyValue()) {
            $value = $propertyForm->getConfig()->getOption('default_data');
        }
        return $value;
    }

    // Use to map parent model data to child form elements
    public function mapDataToForms($property, $forms)
    {
        if (!$property instanceof Property) {
            return;
        }
        $value = $this->value($property, $forms);
        $forms = iterator_to_array($forms);
        $forms[$property->attribute()->name()]->setData($value);
    }

    // Use to map child form elements to parent data model
    public function mapFormsToData($forms, &$property)
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $name = $property->attribute()->name();
        $value = $forms[$name]->getData();
        $property->setValue($value);
    }

    // Use to modify FormView to use during render
    public function buildView(FormView $view, FormInterface $form, array $viewOptions)
    {
    }

    // Use to modify child FormViews to use during render
    public function finishView(FormView $view, FormInterface $form, array $viewOptions)
    {
    }
}
