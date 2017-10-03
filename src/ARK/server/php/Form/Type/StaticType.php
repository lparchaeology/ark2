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

namespace ARK\Form\Type;

use ARK\Model\LocalText;
use ARK\Service;
use ARK\Vocabulary\Term;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaticType extends AbstractType implements DataTransformerInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder->addModelTransformer($this);
    }

    public function configureOptions(OptionsResolver $resolver) : void
    {
        $resolver->setDefaults([
            'widget' => null,
            'html5' => null,
            'choices' => null,
            'choice_value' => 'name',
            'choice_name' => 'name',
            'choice_label' => 'keyword',
            'state' => null,
            'placeholder' => 'core.placeholder',
            'expanded' => false,
            'multiple' => false,
            'display' => null,
        ]);
    }

    public function transform($value)
    {
        if (is_array($value)) {
            $transformed = [];
            foreach ($value as $val) {
                $transformed[] = $this->transformValue($val);
            }
            return $transformed;
        }
        return $this->transformValue($value);
    }

    public function reverseTransform($value)
    {
        return $value;
    }

    private function transformValue($value)
    {
        // TODO Convert these properly!
        if ($value instanceof DateTime) {
            return $value->format('Y-m-d');
        }
        if ($value instanceof Term) {
            return $value->keyword();
        }
        if ($value instanceof LocalText) {
            return $value->content();
        }
        if ($value) {
            return $value;
        }
        return Service::translate('core.placeholder');
    }
}
