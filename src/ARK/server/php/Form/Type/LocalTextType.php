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

use ARK\Form\Type\ScalarFormType;
use ARK\Model\Property;
use ARK\Model\LocalText;
use ARK\Service;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalTextType extends ScalarFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('previous', HiddenType::class, $fieldOptions);
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($property, $forms)
    {
        if (!$property) {
            return;
        }
        $forms = iterator_to_array($forms);
        if ($property instanceof Property) {
            dump($property->attribute()->name());
            $value = $property->value();
            $language = Service::locale();
            // Shouldn't need this once using Property object instead
            dump($value);
            if (is_array($value)) {
                $value = $value[0];
                dump($value);
            }
            dump($value->languages());
            dump($value->content());
            dump($value->mediaType());
            dump($language);
            dump($value->content($language));
            $forms['previous']->setData(serialize($value->contents()));
            $forms['mediatype']->setData($value->mediaType());
            $forms['language']->setData($language);
            $forms['content']->setData($value->content($language));
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        $data = new LocalText();
        $data->setContents(unserialize($forms['previous']->getData()));
        $data->setMediaType($forms['mediatype']->getData());
        $data->setContent($forms['content']->getData(), $forms['language']->getData());
        $property->setValue($data);
    }

    public function getParent()
    {
        return ScalarFormType::class;
    }
}
