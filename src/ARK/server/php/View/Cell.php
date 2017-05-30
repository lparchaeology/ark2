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
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use Symfony\Component\Form\FormBuilderInterface;

class Cell
{
    use EnabledTrait;
    use KeywordTrait;

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
    protected $dataKey = null;
    protected $element = null;
    protected $map = null;
    protected $mode = 'view';
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

    public function defaultMode()
    {
        return $this->mode;
    }

    public function displayMode($parentMode)
    {
        if ($this->defaultMode() !== null && $parentMode == 'edit') {
            return $this->defaultMode();
        }
        return $parentMode;
    }

    public function valueModus()
    {
        return $this->value;
    }

    public function parameterModus()
    {
        return $this->parameter;
    }

    public function formatModus()
    {
        return $this->format;
    }

    public function formOptions($mode, $data, $options = [])
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = json_decode($this->formOptions, true);
            if (!is_array($this->formOptionsArray)) {
                $this->formOptionsArray = [];
            }
            if ($this->showLabel() && $this->keyword()) {
                $this->formOptionsArray['label'] = $this->keyword();
            } else {
                $this->formOptionsArray['label'] = $this->showLabel();
            }
            $this->formOptionsArray['required'] = $this->isRequired();
            $this->formOptionsArray['cell']['value']['modus'] = $this->valueModus();
            $this->formOptionsArray['cell']['parameter']['modus'] = $this->parameterModus();
            $this->formOptionsArray['cell']['format']['modus'] = $this->formatModus();
        }
        $options = array_merge($options, $this->formOptionsArray);
        return $options;
    }

    public function buildForms($mode, $data, $options)
    {
        return $this->element->buildForms($this->displayMode($mode), $data, $options);
    }

    public function buildForm(FormBuilderInterface $builder, $mode, $data, $dataKey, $options = [])
    {
        //dump('BUILD CELL : '.$this->element->name());
        //dump('Mode = '.$mode);
        //dump('Display Mode = '.$this->displayMode($mode));
        //dump($data);
        $mode = $this->displayMode($mode);
        if ($this->dataKey) {
            $dataKey = $this->dataKey;
        }
        $this->element->buildForm($builder, $mode, $data, $dataKey, $this->formOptions($mode, $data, $options));
    }

    public function renderView($mode, $data, array $context = [], $forms = null, $form = null)
    {
        //dump('RENDER CELL : ');
        //dump($mode);
        //dump($this->displayMode($mode));
        //dump($data);
        $context['map'] = $this->map;
        $context['modus'] = $this->valueModus();
        if ($this->showLabel() && $this->keyword()) {
            $context['label'] = $this->keyword();
        } else {
            $context['label'] = $this->showLabel();
        }
        if ($this->dataKey && is_array($data) && isset($data[$this->dataKey])) {
            $data = $data[$this->dataKey];
        }
        return $this->element->renderView($this->displayMode($mode), $data, $context, $forms, $form);
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
        $builder->addStringField('mode', 10);
        $builder->addStringField('value', 10);
        $builder->addStringField('parameter', 10);
        $builder->addStringField('format', 10);
        $builder->addStringField('dataKey', 4000, 'data');
        $builder->addStringField('formOptions', 4000, 'form_options');
        $builder->addField('required', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToOneField('element', 'ARK\View\Element', 'element', 'element', false);
        $builder->addManyToOneField('map', 'ARK\Map\Map');
    }
}
