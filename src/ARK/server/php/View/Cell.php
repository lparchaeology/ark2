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
    protected $disabled = null;
    protected $hidden = null;
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

    public function isDisabled()
    {
        return $this->disabled;
    }

    public function isHidden()
    {
        return $this->hidden;
    }

    public function showParameter()
    {
        return $this->parameter;
    }

    public function showFormat()
    {
        return $this->format;
    }

    public function formOptions($data)
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = json_decode($this->formOptions, true);
            if (!is_array($this->formOptionsArray)) {
                $this->formOptionsArray = [];
            }
            if ($this->label !== null) {
                $this->formOptionsArray['label'] = $this->label;
            }
            if ($this->disabled !== null) {
                $this->formOptionsArray['disabled'] = !$this->disabled;
            }
            if ($this->hidden !== null) {
                $this->formOptionsArray['hidden'] = !$this->hidden;
            }
            if ($this->parameter !== null) {
                $this->formOptionsArray['field_options']['parameter'] = !$this->parameter;
            }
            if ($this->format !== null) {
                $this->formOptionsArray['field_options']['format'] = !$this->format;
            }
        }
        return $this->formOptionsArray;
    }

    public function buildForms($data)
    {
        return $this->element->buildForms($data);
    }

    public function buildForm(FormBuilderInterface $builder, $data, $options = [])
    {
        unset($options['label']);
        $options = array_merge($options, $this->formOptions($data));
        $this->element->buildForm($builder, $data, $options);
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
        $builder->addStringField('formOptions', 4000, 'form_options');
        $builder->addField('label', 'boolean');
        $builder->addField('disabled', 'boolean');
        $builder->addField('hidden', 'boolean');
        $builder->addField('parameter', 'boolean');
        $builder->addField('format', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);

        // Relationships
        $builder->addManyToOneField('element', 'ARK\View\Element', 'cell', 'element', false);
        $builder->addManyToOneField('map', 'ARK\Map\Map');
    }
}
