<?php

/**
 * ARK View Widget.
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

namespace ARK\View;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Symfony\Component\Form\ButtonTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\SubmitButtonTypeInterface;

abstract class AbstractWidget extends Element
{
    protected $choices;
    protected $formOptions = '';
    protected $formOptionsArray;

    public function buildState($data, iterable $state) : iterable
    {
        if (!isset($state['label'])) {
            $state['label'] = $this->showLabel();
        }
        if (!isset($state['name'])) {
            $state['name'] = $this->formName();
        }
        if (!isset($state['keyword'])) {
            $state['keyword'] = $this->keyword();
        }
        $state['mode'] = $this->displayMode($state['mode']);
        if ($state['mode'] === 'view' || $this->mode === 'view') {
            $state['mode'] = 'deny';
        }
        $state['template'] = $this->template();
        $state['widget'] = $this;
        return $state;
    }

    public function buildData($data, iterable $state)
    {
        if ($this->isButton()) {
            return null;
        }
        $name = $state['name'];
        if (is_array($data)) {
            $data = $data[$name] ?? $data[$this->name] ?? $data[$this->id()] ?? null;
        }
        if ($data === null && $state['vocabulary']) {
            $data = $state['required'] ? $state['vocabulary']->defaultTerm() : null;
        }
        if ($state['sanitise'] === 'static') {
            $data = $state['keyword'];
        }
        return $data;
    }

    public function buildOptions($data, iterable $state, iterable $options = []) : iterable
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = ($this->formOptions ? json_decode($this->formOptions, true) : []);
        }
        $options = array_replace_recursive($this->defaultOptions(), $this->formOptionsArray, $options);

        if ($state['label']) {
            $options['label'] = $state['keyword'] ?? $this->keyword();
        } else {
            $options['label'] = false;
        }

        if ($state['mode'] === 'view') {
            $options['required'] = false;
        } else {
            $options['required'] = $state['required'];
        }

        if ($state['vocabulary']) {
            $options = $this->vocabularyOptions($state['vocabulary'], $options);
            if (!$state['placeholder']) {
                $options['placeholder'] = ($state['required'] ? null : ' - ');
            }
        }

        if ($state['choices'] && $state['value']['modus'] === 'active') {
            $name = $state['name'];
            $options['choices'] = $state['options'][$name]['choices'] ?? $data;
            $options['placeholder'] = $state['options'][$name]['placeholder'] ?? $state['placeholder'] ?? '-';
            if (isset($state['options'][$name]['multiple'])) {
                $options['multiple'] = $state['options'][$name]['multiple'];
            }
            $options['required'] = $state['options'][$name]['required'] ?? $options['required'];
        }

        unset($options['state']);
        if ($this->isButton()) {
            unset($options['required'], $options['mapped']);
        }
        return $options;
    }

    public function buildContext($data, iterable $state, FormView $form = null) : iterable
    {
        $context = parent::buildContext($data, $state, $form);
        $context['widget'] = $this;
        return $context;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_widget');
    }

    public static function widgetMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_widget');

        // Fields
        $builder->addStringField('name', 30);
        $builder->addStringField('choices', 30);
        $builder->addStringField('template', 100);
        $builder->addStringField('formTypeClass', 100, 'form_type_class');
        $builder->addStringField('formOptions', 4000, 'form_options');
    }

    private function isButton()
    {
        return is_subclass_of($this->formTypeClass(), SubmitButtonTypeInterface::class) ||
            is_subclass_of($this->formTypeClass(), ButtonTypeInterface::class);
    }
}
