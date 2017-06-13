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

use ARK\File\File;
use ARK\Form\Type\AbstractPropertyType;
use ARK\Model\Item;
use ARK\Model\Property;
use ARK\ORM\ORM;
use ARK\Service;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilePropertyType extends AbstractPropertyType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $field = $options['state']['field'];
        $format = $field->attribute()->format();
        $builder->add('file', FileType::class, []);
        $builder->add('filename', HiddenType::class, []);
        $builder->add('item', HiddenType::class, []);
        $builder->add('module', HiddenType::class, []);
        $builder->setDataMapper($this);
    }

    protected function options()
    {
        return [
            'compound' => true,
            'display' => null,
        ];
    }

    public function mapDataToForms($property, $forms)
    {
        if (!$property instanceof Property) {
            return;
        }
        $file = $this->value($property, $forms);
        $forms = iterator_to_array($forms);
        if ($file instanceof Item) {
            $forms['filename']->setData($file->name());
            $forms['item']->setData($file->id());
            $forms['module']->setData($file->schema()->module()->name());
        } elseif (isset($file['item'])) {
            $forms['item']->setData($file['item']);
            $forms['module']->setData($file['module']);
        } else {
            $forms['module']->setData('file');
        }
    }

    public function mapFormsToData($forms, &$property)
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $upload = $forms['file']->getData();
        $file = File::createFromUploadedFile($upload);
        // FIXME handle multiples properly!
        if ($property->attribute()->hasMultipleOccurrences()) {
            $file = [$file];
        }
        $property->setValue($file);
    }
}
