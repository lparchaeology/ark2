<?php

/**
 * ARK View Cell
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

namespace ARK\View;

use ARK\Model\EnabledTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use Symfony\Component\Form\FormBuilderInterface;

class Cell
{
    use EnabledTrait;

    protected $layout = null;
    protected $row = 0;
    protected $col = 0;
    protected $seq = 0;
    protected $itemType = null;
    protected $label = null;
    protected $required = null;
    protected $value = null;
    protected $parameter = null;
    protected $format = null;
    protected $element = null;
    protected $map = null;
    protected $formOptions = '';
    protected $formOptionsArray = null;

    public function layout()
    {
        return $this->layout;
    }

    public function row()
    {
        return $this->row;
    }

    public function col()
    {
        return $this->col;
    }

    public function seq()
    {
        return $this->seq;
    }

    public function itemType()
    {
        return $this->itemType;
    }

    public function element()
    {
        return $this->element;
    }

    public function map()
    {
        return $this->map;
    }

    public function showLabel()
    {
        return $this->label;
    }

    public function isRequired()
    {
        return $this->required;
    }

    public function valueMode()
    {
        if (!Service::isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return 'static';
        }
        return $this->value;
    }

    public function parameterMode()
    {
        return $this->parameter;
    }

    public function formatMode()
    {
        return $this->format;
    }

    public function formOptions($data, $options = [])
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = json_decode($this->formOptions, true);
            if (!is_array($this->formOptionsArray)) {
                $this->formOptionsArray = [];
            }
            $this->formOptionsArray['label'] = $this->showLabel();
            $this->formOptionsArray['required'] = $this->isRequired();
            $this->formOptionsArray['cell']['value']['mode'] = $this->valueMode();
            $this->formOptionsArray['cell']['parameter']['mode'] = $this->parameterMode();
            $this->formOptionsArray['cell']['format']['mode'] = $this->formatMode();
        }
        $options = array_merge($options, $this->formOptionsArray);
        return $options;
    }

    public function buildForms($data, $options)
    {
        return $this->element->buildForms($data, $options);
    }

    public function buildForm(FormBuilderInterface $builder, $data, $options = [])
    {
        $this->element->buildForm($builder, $data, $this->formOptions($data, $options));
    }

    public function renderView($data, $forms = null, $form = null, array $options = [])
    {
        $options['map'] = $this->map;
        return $this->element->renderView($data, $forms, $form, $options);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_grid');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('layout', 'ARK\View\Element', 'layout', 'element');
        $builder->addKey('row', 'integer');
        $builder->addKey('col', 'integer');
        $builder->addKey('seq', 'integer');
        $builder->addStringKey('itemType', 30, 'item_type');

        // Fields
        $builder->addField('label', 'boolean');
        $builder->addStringField('value', 10);
        $builder->addStringField('parameter', 10);
        $builder->addStringField('format', 10);
        $builder->addStringField('formOptions', 4000, 'form_options');
        $builder->addField('required', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);

        // Relationships
        $builder->addManyToOneField('element', 'ARK\View\Element', 'element', 'element', false);
        $builder->addManyToOneField('map', 'ARK\Map\Map');
    }
}
