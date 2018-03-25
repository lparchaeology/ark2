<?php

/**
 * ARK View Widget.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\View;

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Symfony\Component\Form\ButtonTypeInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\SubmitButtonTypeInterface;

class Widget extends Element
{
    protected $formOptions = '';
    protected $formOptionsArray;

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_widget');

        // Fields
        $builder->addStringField('name', 30);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addStringField('template', 100);
        $builder->addMappedStringField('form_type', 'formType', 100);
        $builder->addMappedStringField('form_options', 'formOptions', 4000);
    }

    protected function buildState($data, iterable $state) : iterable
    {
        $state = parent::buildState($data, $state);
        $state['widget'] = $this;

        if (!isset($state['keyword'])) {
            if ($this->keyword()) {
                $state['keyword'] = $this->keyword();
            } elseif (isset($state['vocabulary'])) {
                $state['keyword'] = $state['vocabulary']->keyword();
            } else {
                $state['keyword'] = null;
            }
        }

        $state['mode'] = $this->displayMode($state['mode']);
        if ($state['mode'] === 'view' && $state['value']['modus'] !== 'active') {
            $state['mode'] = 'deny';
        }

        return $state;
    }

    protected function buildData($data, iterable $state)
    {
        if ($this->isButton($state['form']['type']) || $state['sanitise'] === 'redact') {
            return null;
        }
        $name = $state['name'];
        if (is_iterable($data)) {
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

    protected function buildOptions($data, iterable $state, iterable $options = []) : iterable
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
                $options['placeholder'] = ($state['required'] ? null : 'core.placeholder');
            }
        }

        if ($state['choices'] && $state['value']['modus'] === 'active') {
            $select = $state['select'][$state['name']] ?? [];
            $options['choices'] = $select['choices'] ?? $data;
            $options['choice_value'] = $select['choice_value'] ?? 'name';
            $options['choice_name'] = $select['choice_name'] ?? 'name';
            $options['choice_label'] = $select['choice_label'] ?? 'keyword';
            $options['placeholder'] = $select['placeholder'] ?? $state['placeholder'] ?? 'core.placeholder';
            if (isset($select['multiple'])) {
                $options['multiple'] = $select['multiple'];
            }
            $options['required'] = $select['required'] ?? $options['required'];
            if (isset($select['modus']) && $select['modus'] === 'readonly') {
                $options['attr']['class'] = $this->concatAttr($options, 'class', 'readonly-select');
                if ($options['required']) {
                    $options['attr']['class'] = $this->concatAttr($options, 'class', 'readonly-required');
                }
            }
        }

        unset($options['state']);
        if ($this->isButton($state['form']['type'])) {
            unset($options['required'], $options['mapped']);
        }
        return $options;
    }

    protected function buildContext(iterable $view, iterable $forms = [], FormView $form = null) : iterable
    {
        $view = parent::buildContext($view, $forms, $form);
        $view['widget'] = $this;
        if (!$view['form']) {
            $builder = $this->formBuilder($view['state']['name'], $view['state']['form']['type'], $view['data'], $view['options']);
            $view['form'] = $builder->getForm()->createView();
        }
        return $view;
    }

    private function isButton(string $formType)
    {
        return is_subclass_of($formType, SubmitButtonTypeInterface::class) ||
            is_subclass_of($formType, ButtonTypeInterface::class);
    }
}
