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
use Symfony\Component\Form\FormView;

class Cell
{
    use EnabledTrait;
    use KeywordTrait;

    protected $group = null;
    protected $row = 0;
    protected $col = 0;
    protected $seq = 0;
    protected $itemType = null;
    protected $name = null;
    protected $width = null;
    protected $label = null;
    protected $required = null;
    protected $sanitise = null;
    protected $display = null;
    protected $value = null;
    protected $parameter = null;
    protected $format = null;
    protected $element = null;
    protected $map = null;
    protected $mode = 'view';
    protected $options = '';
    protected $optionsArray = null;

    public function group()
    {
        return $this->group;
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

    public function formName()
    {
        return $this->name;
    }

    public function width()
    {
        return $this->width;
    }

    public function showLabel()
    {
        return $this->label;
    }

    public function isRequired()
    {
        return $this->required;
    }

    public function mode()
    {
        return $this->mode;
    }

    public function sanitise()
    {
        return $this->sanitise;
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

    public function buildState($state)
    {
        $state['name'] = $this->name;
        $state['label'] = $this->label;
        $state['map'] = $this->map;
        if ($this->required === false) {
            $state['required'] = false;
        }
        if ($this->sanitise !== null) {
            $state['sanitise'] = $this->sanitise;
        }
        if ($this->width !== null) {
            $state['width'] = $this->width;
        }
        if ($this->keyword !== null) {
            $state['keyword'] = $this->keyword;
        }
        if ($this->valueModus() !== null) {
            $this->optionsArray['state']['value']['modus'] = $this->valueModus();
        }
        if ($this->valueModus() !== null) {
            $this->optionsArray['state']['parameter']['modus'] = $this->parameterModus();
        }
        if ($this->valueModus() !== null) {
            $this->optionsArray['state']['format']['modus'] = $this->formatModus();
        }
        return $state;
    }

    public function buildOptions($data, $options = [])
    {
        if ($this->optionsArray === null) {
            $this->optionsArray = json_decode($this->options, true);
            if (!is_array($this->optionsArray)) {
                $this->optionsArray = [];
            }
        }
        $options = array_replace_recursive($options, $this->optionsArray);
        return $options;
    }

    public function buildForms($data, $state, $options)
    {
        $state = $this->buildState($state);
        return $this->element->buildForms($data, $state, $options);
    }

    public function buildForm(FormBuilderInterface $builder, $data, array $state, array $options = [])
    {
        //dump('BUILD CELL : '.$this->element->formName());
        //dump($data);
        //dump($state);
        //dump($options);
        $state = $this->buildState($state);
        $options = $this->buildOptions($data, $options);
        //dump($options);
        $this->element->buildForm($builder, $data, $state, $options);
    }

    public function renderView($data, array $state, FormView $form = null)
    {
        //dump('RENDER CELL : '.$this->element->formName());
        //dump($state);
        //dump($data);
        $state['mode'] = $this->mode($state['mode']);
        if ($this->showLabel() && $this->keyword()) {
            $state['label'] = $this->keyword();
        } else {
            $state['label'] = $this->showLabel();
        }
        if ($this->isRequired() !== null) {
            $state['required'] = $this->isRequired();
        }
        $state['modus'] = $this->valueModus();
        if (!isset($state['sanitise']) || $this->sanitise()) {
            $state['sanitise'] = $this->sanitise();
        }
        $state['name'] = $this->formName();
        //dump($state);
        return $this->element->renderView($data, $state, $forms, $form);
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_grid');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('group', 'ARK\View\Element', 'grp', 'element');
        $builder->addKey('row', 'integer');
        $builder->addKey('col', 'integer');
        $builder->addKey('seq', 'integer');
        $builder->addStringKey('itemType', 30, 'item_type');

        // Fields
        $builder->addStringField('name', 30);
        $builder->addField('width', 'integer');
        $builder->addField('label', 'boolean');
        $builder->addStringField('mode', 10);
        $builder->addStringField('sanitise', 10);
        $builder->addStringField('value', 10);
        $builder->addStringField('parameter', 10);
        $builder->addStringField('format', 10);
        $builder->addStringField('display', 30);
        $builder->addStringField('options', 4000, 'options');
        $builder->addField('required', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToOneField('element', 'ARK\View\Element', 'element', 'element', false);
        $builder->addManyToOneField('map', 'ARK\Map\Map');
    }
}
