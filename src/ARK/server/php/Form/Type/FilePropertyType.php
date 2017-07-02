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
        $fileOptions = [];
        if ($options['state']['multiple']) {
            $fileOptions['multiple'] = true;
        }
        $builder->add('file', FileType::class, $fileOptions);
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
    }

    public function mapFormsToData($forms, &$property)
    {
        if (!$property instanceof Property) {
            return;
        }
        $forms = iterator_to_array($forms);
        $upload = $forms['file']->getData();
        if ($upload instanceof UploadedFile) {
            $file = File::createFromUploadedFile($upload);
            $property->setValue($file);
        } elseif (is_array($upload)) {
            $files = [];
            foreach ($upload as $up) {
                $files[] = File::createFromUploadedFile($up);
            }
            if ($files) {
                $property->setValue($files);
            }
        }
    }
}
