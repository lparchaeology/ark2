<?php

/**
 * ARK Event Form Type.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Form\Type;

use ARK\Model\LocalText;
use ARK\Model\Property;
use ARK\Service;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

class LocalTextPropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('previous', HiddenType::class, $fieldOptions);
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($property, $forms) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $options = $this->propertyOptions($forms);
        $text = $this->value($property, $forms);
        $forms = iterator_to_array($forms);
        $language = Service::locale();
        $forms['language']->setData($language);
        $forms['mediatype']->setData('text/plain');
        if ($text instanceof LocalText) {
            $forms['previous']->setData(json_encode($text->contents()));
            $forms['mediatype']->setData($text->mediaType());
            $forms['content']->setData($text->content($language));
            if (isset($options['state']['display'])) {
                $displayName = $options['state']['display']['name'];
                if ($displayName && isset($forms[$displayName])) {
                    $forms[$displayName]->setData($text->content($language));
                }
                if (isset($options['state']['static'])) {
                    $staticName = $options['state']['static']['name'];
                    $forms[$staticName]->setData($text->content($language));
                }
            }
        }
    }

    public function mapFormsToData($forms, &$property) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $text = new LocalText();
        $previous = json_decode($forms['previous']->getData());
        if (is_array($previous)) {
            $text->setContents($previous);
        }
        $text->setMediaType($forms['mediatype']->getData() ?? $property->attribute()->dataclass()->mediatype());
        $text->setContent($forms['content']->getData(), $forms['language']->getData());
        $property->setValue($text);
    }

    public function getBlockPrefix() : string
    {
        return 'local_text_property';
    }

    public function getParent() : string
    {
        return ScalarPropertyType::class;
    }
}
