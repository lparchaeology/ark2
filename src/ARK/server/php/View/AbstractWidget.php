<?php

/**
 * ARK View Widget
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

use ARK\Actor\Actor;
use ARK\Form\Type\PropertyType;
use ARK\Form\Type\ActionChoiceType;
use ARK\Form\Type\VocabularyChoiceType;
use ARK\Model\Item;
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ORM;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use ARK\Vocabulary\Vocabulary;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\ButtonTypeInterface;
use Symfony\Component\Form\SubmitButtonTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;

abstract class AbstractWidget extends Element
{
    protected $vocabulary = null;
    protected $choices = null;
    protected $formOptions = '';
    protected $formOptionsArray = null;

    public function vocabulary()
    {
        return $this->vocabulary;
    }

    private function isButton()
    {
        return is_subclass_of($this->formTypeClass(), SubmitButtonTypeInterface::class) ||
            is_subclass_of($this->formTypeClass(), ButtonTypeInterface::class);
    }

    public function buildState(array $state)
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
        if ($state['mode'] == 'view' || $this->mode == 'view') {
            $state['mode'] = 'withhold';
        }
        $state['template'] = $this->template();
        $state['widget'] = $this;
        return $state;
    }

    public function buildData($data, array $state)
    {
        if ($this->isButton()) {
            return null;
        }
        $name = $state['name'];
        if (is_array($data)) {
            if (array_key_exists($name, $data)) {
                $data = $data[$name];
            } elseif (array_key_exists($this->name, $data)) {
                $data = $data[$this->name];
            } elseif (array_key_exists($this->id(), $data)) {
                $data = $data[$this->id()];
            } else {
                $data = null;
            }
        }
        if ($data === null && $this->vocabulary && isset($state['required']) && $state['required']) {
            $data = $this->vocabulary->defaultTerm();
        }
        return $data;
    }

    public function buildOptions($data, array $state, array $options = [])
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = ($this->formOptions ? json_decode($this->formOptions, true) : []);
        }
        $options = array_replace_recursive($this->defaultOptions(), $this->formOptionsArray, $options);

        if ($state['label']) {
            $options['label'] = ($state['keyword'] ? $state['keyword'] : $this->keyword());
        }

        if ($state['mode'] == 'view') {
            $options['required'] = false;
        } else {
            $options['required'] = $state['required'];
        }

        if ($this->vocabulary) {
            $options = $this->vocabularyOptions($this->vocabulary, $options);
        }

        if ($this->choices) {
            $options['choices'] = $data;
        }

        unset($options['state']);
        if ($this->isButton()) {
            unset($options['required']);
            unset($options['mapped']);
        }
        return $options;
    }

    public function buildContext($data, array $state, FormView $form = null)
    {
        $context = parent::buildContext($data, $state, $form);
        $context['widget'] = $this;
        return $context;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_widget');
    }

    public static function widgetMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_widget');

        // Fields
        $builder->addStringField('name', 30);
        $builder->addStringField('choices', 30);
        $builder->addStringField('template', 100);
        $builder->addStringField('formTypeClass', 100, 'form_type_class');
        $builder->addStringField('formOptions', 4000, 'form_options');

        // Associations
        $builder->addManyToOneField('vocabulary', Vocabulary::class, 'vocabulary', 'concept');
    }
}
