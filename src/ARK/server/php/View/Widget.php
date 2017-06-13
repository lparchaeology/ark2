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

class Widget extends Element
{
    protected $label = true;
    protected $vocabulary = null;
    protected $formTypeClass = '';
    protected $formOptions = '';
    protected $formOptionsArray = null;

    public function showLabel()
    {
        return $this->label;
    }

    public function vocabulary()
    {
        return $this->vocabulary;
    }

    public function formTypeClass()
    {
        if ($this->formTypeClass) {
            return $this->formTypeClass;
        }
        return parent::formTypeClass();
    }

    private function isButton()
    {
        return is_subclass_of($this->formTypeClass(), SubmitButtonTypeInterface::class) ||
            is_subclass_of($this->formTypeClass(), ButtonTypeInterface::class);
    }

    public function buildOptions($data, $options = [])
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = ($this->formOptions ? json_decode($this->formOptions, true) : []);
        }
        $options = array_replace_recursive($this->defaultOptions(), $this->formOptionsArray, $options);
        $state = $options['state'];

        if ($state['label'] === null) {
            $options['label'] = $this->showLabel();
        } else {
            $options['label'] = $state['label'];
        }
        if ($options['label']) {
            if ($state['keyword']) {
                $options['label'] = $state['keyword'];
            } elseif ($this->keyword()) {
                $options['label'] = $this->keyword();
            }
        }

        if ($state['mode'] == 'view') {
            $options['required'] = false;
        } else {
            $options['required'] = $state['required'];
        }

        if ($this->vocabulary) {
            $options = $this->vocabularyOptions($this->vocabulary, $options);
        }

        unset($options['state']);
        unset($options['data']);
        unset($options['forms']);
        unset($options['form']);
        if ($this->isButton()) {
            unset($options['required']);
            unset($options['mapped']);
        }

        return $options;
    }

    public function formData($data, $state)
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
        //dump($data);
        return $data;
    }

    protected function buildState($state)
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
        $state['widget'] = $this;
        return $state;
    }

    public function buildForm(FormBuilderInterface $builder, $data, $dataKey, $options = [])
    {
        //dump('BUILD WIDGET : '.$this->formName());
        //dump($this);
        //dump($data);
        //dump($dataKey);
        //dump($options);
        $options['state'] = $this->buildState($options['state']);
        //dump($options);
        if ($options['state']['mode'] == 'view' || $this->mode == 'view') {
            return;
        }
        $name = $options['state']['name'];
        $mode = $options['state']['mode'];
        $data = $this->formData($data, $options['state']);
        //dump($data);
        $options = $this->buildOptions($data, $options);
        //dump($options);
        // TODO check workflow instead!
        $widgetBuilder =  $this->formBuilder($data, $options, $name);
        //dump($widgetBuilder);
        $builder->add($widgetBuilder);
    }

    public function renderView($data, array $state, $forms = null, $form = null)
    {
        //dump('RENDER WIDGET : '.$this->formName());
        //dump($form);
        //dump($state);
        $state = $this->buildState($state);
        if ($state['mode'] == 'view' || $this->mode == 'view') {
            return;
        }
        if ($form) {
            $context = $this->defaultContext();
            $context['state'] = array_replace_recursive($context['state'], $state);
            $context['data'] = $this->formData($data, $state);
            $context['forms'] = $forms;
            $context['form'] = $form[$context['state']['name']];
            //dump($context['form']);
            //dump($this->template());
            return Service::view()->renderView($this->template(), $context);
        }
        return null;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_widget');

        // Fields
        $builder->addField('label', 'boolean');
        $builder->addStringField('mode', 10);
        $builder->addStringField('name', 30);
        $builder->addStringField('template', 100);
        $builder->addStringField('formTypeClass', 100, 'form_type_class');
        $builder->addStringField('formOptions', 4000, 'form_options');

        // Associations
        $builder->addManyToOneField('vocabulary', Vocabulary::class, 'vocabulary', 'concept');
    }
}
