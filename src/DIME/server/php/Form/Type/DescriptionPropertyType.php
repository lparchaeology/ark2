<?php

/**
 * DIME Form Type.
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

use ARK\Form\Type\AbstractPropertyType;
use ARK\Model\LocalText;
use ARK\Model\Property;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Entity\Event;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

class DescriptionPropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        if (isset($options['state']['display'])) {
            $builder->add($options['state']['display']['name'], $options['state']['display']['type'], $options['state']['display']['options']);
        }
        $builder->add('content', $options['state']['value']['type'], $options['state']['value']['options']);
        $fieldOptions['label'] = false;
        $fieldOptions['mapped'] = false;
        $builder->add('event', HiddenType::class, $fieldOptions);
        $builder->add('previous', HiddenType::class, $fieldOptions);
        $builder->add('mediatype', HiddenType::class, $fieldOptions);
        $builder->add('language', HiddenType::class, $fieldOptions);
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($property, $forms) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $options = $this->propertyOptions($forms);
        $forms = iterator_to_array($forms);
        $value = $property->value();
        if ($value) {
            // No multi-vocality for now
            $event = $value['event'];
            $text = $value['text'];
            $language = Service::locale();
            if ($event instanceof Event) {
                $forms['event']->setData($event->id());
            }
            if ($text) {
                if (isset($options['state']['display'])) {
                    $forms[$options['state']['display']['name']]->setData($text->content($language));
                }
                $forms['content']->setData($text->content($language));
                $forms['previous']->setData(serialize($text->contents()));
                $forms['mediatype']->setData($text->mediaType());
            }
            $forms['language']->setData($language);
        }
    }

    public function mapFormsToData($forms, &$property) : void
    {
        $forms = iterator_to_array($forms);
        if ($property instanceof Property) {
            $text = new LocalText();
            if ($previous = unserialize($forms['previous']->getData())) {
                $text->setContents($previous);
            }
            if ($mediatype = $forms['mediatype']->getData()) {
                $text->setMediaType($mediatype);
            }
            $text->setContent($forms['content']->getData(), $forms['language']->getData());
            $event = $forms['event']->getData();
            if ($event) {
                $event = ORM::find(Event::class, $event);
            }
            $data['event'] = $event;
            $data['text'] = $text;
            $property->setValue($data);
        }
    }

    protected function options()
    {
        return [
            'compound' => true,
         ];
    }
}
