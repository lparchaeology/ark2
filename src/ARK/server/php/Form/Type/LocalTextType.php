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
use ARK\Service;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class LocalTextType extends ScalarFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        dump('build text');
        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('previous', HiddenType::class, $fieldOptions);
    }

    public function mapDataToForms($property, $forms)
    {
        if (!$property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $name = $property->attribute()->name();
        $language = Service::locale();
        $mimetype = 'text/plain';
        $values = $property->value();
        $text = [];
        foreach ($values as $value) {
            $text[$value['language']] = $value['content'];
            $mimetype = $value['mimetype'];
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
        $forms['mimetype']->setData($mimetype);
        $forms['language']->setData($language);
        $forms['content']->setData($content);
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        $name = $property->attribute()->name();
        $text = unserialize($forms['previous']->getData());
        $mimetype = $forms['mimetype']->getData();
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
            $values[] = ['mimetype' => $mimetype, 'language' => $lang, 'content' => $cont];
        }
        $property->setValue($values);
    }
    public function getParent()
    {
        return ScalarFormType::class;
    }
}
