<?php

/**
 * ARK View Field
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\View;

use ARK\Database\Database;
use ARK\Model\Item\Item;
use ARK\Model\Property\Property;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

class Field extends Element
{
    public function attribute()
    {
        return $this->attribute;
    }

    public function keyword()
    {
        if ($this->keyword) {
            return $this->keyword;
        }
        return $this->attribute()->keyword();
    }

    public function buildForm(FormBuilderInterface $formBuilder, array $options = [])
    {
        $options['attribute'] = $this->attribute;
        $options['mapped'] = false;
        $options['label'] = $this->keyword();
        $factory = $formBuilder->getFormFactory();
        $data = $formBuilder->getData()->property($this->attribute->name());
        $fieldBuilder = $factory->createNamedBuilder($this->element, $this->formType(), $data, $options);
        $formBuilder->add($fieldBuilder);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
    }
}
