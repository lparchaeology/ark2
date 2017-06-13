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

use ARK\File\Image;
use ARK\Form\Type\AbstractPropertyType;
use ARK\Model\Property;
use ARK\ORM\ORM;
use ARK\Service;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

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
        dump($property);
        $file = $this->value($property, $forms);
        dump($file);
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
        dump($forms);
        dump($property);
        $file = $forms['file']->getData();
        dump($file);
        if ($file->isValid()) {
            $item = new Image();
            ORM::persist($item);
            $item->setMediatype($file->getMimetype());
            $stream = fopen($file->getRealPath(), 'r+');
            dump($item);
            dump($item->filepath());
            Service::filesystem()->writeStream($item->filepath(), $stream);
            fclose($stream);
            $property->setValue($item);
            dump($item);
            dump($property);
        }
        return;
        //$file->move($dir, $someNewFilename);
        //$module = $forms['module']->getData();
        //$item = $forms['item']->getData();
        if ($module && $item) {
            // TODO Check file unchanged else delete old and insert new
            $values['module'] = $module;
            $values['item'] = $item;
            $property->setValue($values);
        } else {
            // new item!
        }
    }
}
