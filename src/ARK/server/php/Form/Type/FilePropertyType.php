<?php

/**
 * ARK Event Form Type.
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

use ARK\File\File;
use ARK\Model\Property;
use ARK\ORM\ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilePropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, iterable $options) : void
    {
        $fileOptions = [];
        if ($options['state']['multiple']) {
            $fileOptions['multiple'] = true;
        }
        $builder->add('file', FileType::class, $fileOptions);
        $hiddenOptions['label'] = false;
        $hiddenOptions['mapped'] = false;
        $hiddenOptions['entry_type'] = HiddenType::class;
        $builder->add('previous', CollectionType::class, $hiddenOptions);
        $builder->add('existing', CollectionType::class, $hiddenOptions);
        $builder->setDataMapper($this);
    }

    public function mapDataToForms($property, $forms) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $value = $property->value();
        $previous = [];
        if (is_array($value)) {
            foreach ($value as $val) {
                if ($val instanceof File) {
                    $previous[] = $val->id();
                }
            }
        } elseif ($value instanceof File) {
            $previous[] = $value->id();
        }
        $forms['previous']->setData($previous);

        $i = 0;

        $maximumOccurrences = $property->attribute()->maximumOccurrences();

        while ($i < $maximumOccurrences) {
            if (is_array($value)) {
                if (array_key_exists($i, $value)) {
                    if ($value[$i] instanceof File) {
                        $existing[] = $value[$i]->id();
                    } else {
                        $existing[] = 'null';
                    }
                } else {
                    $existing[] = 'null';
                }
            } elseif ($value instanceof File && $i === 0) {
                $existing[] = $value->id();
            }
            ++$i;
        }
        $forms['existing']->setData($existing);
    }

    public function mapFormsToData($forms, &$property) : void
    {
        if (!$property instanceof Property) {
            return;
        }
        $options = $this->propertyOptions($forms);
        $forms = iterator_to_array($forms);

        $upload = $forms['file']->getData();

        $previous = array_values(array_filter($forms['previous']->getData(), 'strlen'));
        sort($previous);
        $existing = array_values(array_filter($forms['existing']->getData(), 'strlen'));
        sort($existing);
        $removed = array_diff($previous, $existing);
        $additions = array_diff($existing, $previous);

        if (!$removed && !$upload && !$additions) {
            return;
        }

        if ($options['state']['multiple']) {
            $files = new ArrayCollection();
            foreach ($existing as $fileId) {
                $file = ORM::find(File::class, $fileId);
                if ($file) {
                    $files[] = $file;
                }
            }

            foreach ($upload as $up) {
                if ($file = File::createFromUploadedFile($up)) {
                    $files->add($file);
                }
            }

            $property->setValue($files);
        } else {
            $file = null;
            if ($upload instanceof UploadedFile) {
                $file = File::createFromUploadedFile($upload);
            }
            $property->setValue($file);
        }
        // TODO What about the deleted Files???
    }

    protected function options() : iterable
    {
        return [
                'compound' => true,
                'display' => null,
        ];
    }
}
