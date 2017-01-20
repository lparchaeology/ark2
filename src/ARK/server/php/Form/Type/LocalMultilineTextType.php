<?php

/**
 * ARK Form Type
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
use ARK\Form\Type\LocalTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class LocalMultilineTextType extends LocalTextType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attribute = $options['field']->attribute()->name();
        $fieldOptions['label'] = false;
        $fieldOptions['property_path'] = "keyValue[$attribute][language]";
        $builder->add('language', LanguageType::class, $fieldOptions);
        $fieldOptions['property_path'] = "keyValue[$attribute][content]";
        $builder->add('content', TextareaType::class, $fieldOptions);
    }

    public function getBlockPrefix()
    {
        return 'localmultilinetext';
    }

    public function getParent()
    {
        return LocalTextType::class;
    }
}
