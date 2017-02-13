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
use ARK\Model\Fragment\TextFragment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

// TODO Port to PropertyType and using the object!
class LocalTextType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $textType = isset($options['text_type']) ? $options['text_type']: TextType::class;
        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('previous', HiddenType::class, $fieldOptions);
        $builder->add('language', HiddenType::class, $fieldOptions);
        // TODO Generate from Format default types?
        $builder->add('content', $textType, $fieldOptions);
        $builder->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'field' => null,
            'data_class' => Property::class,
            'empty_data' => null,
        ]);
    }

    public function mapDataToForms($property, $forms)
    {
        $forms = iterator_to_array($forms);
        $language = Service::locale();
        $values = $property->value();
        $text = [];
        foreach ($values as $value) {
            $text[$value['language']] = $value['content'];
        }
        $content = '';
        if (isset($text[$language])) {
            $content = $text[$language];
        } else {
            foreach (Service::localeFallbacks() as $fallback) {
                if (isset($text[$fallback])) {
                    $content = $text[$fallback];
                    continue;
                }
            }
        }
        // Shouldn't need this once using Property object instead
        $forms['previous']->setData(serialize($text));
        $forms['language']->setData($language);
        $forms['content']->setData($content);
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        $text = unserialize($forms['previous']->getData());
        $language = $forms['language']->getData();
        $content = $forms['content']->getData();
        if (isset($text[$language]) && $text[$language] == $content) {
            return;
        }
        if (!isset($text[$language]) && !$content) {
            return;
        }
        $text[$language] = $content;
        $values = [];
        foreach ($text as $lang => $cont) {
            $values[] = ['language' => $lang, 'content' => $cont];
        }
        $property->setValue($values);
    }

    public function getBlockPrefix()
    {
        return 'localtext';
    }
}
