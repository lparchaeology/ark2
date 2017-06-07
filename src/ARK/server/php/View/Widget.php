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

    public function buildOptions($mode, $data, $options)
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = ($this->formOptions ? json_decode($this->formOptions, true) : []);
        }
        $options = array_merge_recursive($this->defaultOptions(), $this->formOptionsArray, $options);
        $cellOptions = $options['cell'];
        unset($options['page']);
        unset($options['data']);
        unset($options['cell']);
        unset($options['forms']);
        unset($options['form']);
        if (is_subclass_of($this->formTypeClass(), SubmitButtonTypeInterface::class)) {
            unset($options['required']);
            unset($options['mapped']);
        }
        unset($options['sanitise']);
        if ($options['label'] === null) {
            $options['label'] = $this->showLabel();
        }
        if ($options['label']) {
            //dump($cellOptions);
            if ($cellOptions['keyword']) {
                $options['label'] = $cellOptions['keyword'];
            } elseif ($this->keyword()) {
                $options['label'] = $this->keyword();
            }
        }
        if ($this->vocabulary) {
            $options = $this->vocabularyOptions($this->vocabulary, $options);
        }
        return $options;
    }

    public function formData($mode, $data, $options)
    {
        if (is_subclass_of($this->formTypeClass(), SubmitButtonTypeInterface::class)) {
            return null;
        }
        $cellName = $options['cell']['name'];
        if (is_array($data)) {
            if (array_key_exists($cellName, $data)) {
                $data = $data[$cellName];
            } elseif (array_key_exists($this->name, $data)) {
                $data = $data[$this->name];
            } elseif (array_key_exists($this->id(), $data)) {
                $data = $data[$this->id()];
            } else {
                $data = null;
            }
        }
        if ($data === null && $this->vocabulary && isset($options['required']) && $options['required']) {
            $data = $this->vocabulary->defaultTerm();
        }
        //dump($data);
        return $data;
    }

    public function buildForm(FormBuilderInterface $builder, $mode, $data, $dataKey, $options = [])
    {
        //dump('BUILD WIDGET : '.$this->formName());
        //dump($mode);
        //dump($this->displayMode($mode));
        //dump($this);
        //ump($data);
        //dump($dataKey);
        //dump($this);
        //dump($options);
        $data = $this->formData($mode, $data, $options);
        //dump($data);
        $cellName = $options['cell']['name'];
        $options = $this->buildOptions($mode, $data, $options);
        // TODO check workflow instead!
        if ($this->mode == 'view' || $mode == 'edit') {
            $widgetBuilder =  $this->formBuilder($mode, $data, $options, $cellName);
            $builder->add($widgetBuilder);
        }
    }

    public function renderView($mode, $data, array $context = [], $forms = null, $form = null)
    {
        //dump('RENDER WIDGET : '.$this->formName());
        //dump($form);
        //dump($context);
        if ($form) {
            $context['widget'] = $this;
            $context['mode'] = $mode;
            if (isset($form->vars['id'])) {
                // TODO What is this? Why?
                $options['cell']['name'] = $form->vars['id'];
            } else {
                $options['cell']['name'] = null;
            }
            $data = $this->formData($mode, $data, $options);
            $context['data'] = $data;
            $context['forms'] = $forms;
            $context['form'] = $form;
            //dump($context);
            return Service::view()->renderView($this->template(), $context);
        }
        return '';
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
