<?php

/**
 * DIME Form Type
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

use ARK\Form\Type\TermChoiceType;
use ARK\Form\Type\AbstractFormType;
use ARK\Model\LocalText;
use ARK\Model\Property;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Workflow\Event;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class DescriptionType extends AbstractFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $valueOptions = $options['field']['value']['options'];
        // No multi-vocality for now
        unset($valueOptions['multiple']);
        $field = $options['field']['object'];
        $format = $field->attribute()->format();

        $builder->add('content', $options['field']['value']['type'], $valueOptions);

        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('event', HiddenType::class, $fieldOptions);
        $builder->add('previous', HiddenType::class, $fieldOptions);
        $builder->add('mediatype', HiddenType::class, $fieldOptions);
        $builder->add('language', HiddenType::class, $fieldOptions);

        $builder->setDataMapper($this);
    }

    protected function options()
    {
        return [
            'compound' => true,
         ];
    }

    public function mapDataToForms($property, $forms)
    {
        $forms = iterator_to_array($forms);
        if ($property instanceof Property) {
            $value = $property->value();
            if ($value && $value[0]) {
                // No multi-vocality for now
                $event = $value[0]['event'];
                $text = $value[0]['text'];
                $language = Service::locale();
                $forms['event']->setData($event['item']);
                $forms['content']->setData($text->content($language));
                $forms['previous']->setData(serialize($text->contents()));
                $forms['mediatype']->setData($text->mediaType());
                $forms['language']->setData($language);
            }
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        $forms = iterator_to_array($forms);
        if ($property instanceof Property) {
            $text = new LocalText();
            $previous = unserialize($forms['previous']->getData());
            if ($previous) {
                $text->setContents($previous);
            }
            $mediatype = $forms['mediatype']->getData();
            if ($mediatype) {
                $text->setMediaType($mediatype);
            }
            $text->setContent($forms['content']->getData(), $forms['language']->getData());
            $event = $forms['event']->getData();
            if ($event) {
                $event = ORM::find(Event::class, $event);
            }
            $data['event'] = $event;
            $data['text'] = $text;
            $property->setValue([$data]);
        }
    }
}
