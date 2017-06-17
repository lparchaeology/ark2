<?php

/**
 * ARK View Group
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

use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ClassMetadata;
use ARK\View\Element;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

class Group extends Element
{
    protected $required = null;
    protected $form = null;
    protected $method = null;
    protected $action = null;
    protected $cells = null;
    protected $parentCells = null;

    public function __construct()
    {
        $this->cells = new ArrayCollection();
    }

    public function isRequired()
    {
        return $this->required;
    }

    public function isForm()
    {
        return $this->form;
    }

    public function formMethod()
    {
        return $this->method;
    }

    public function formAction()
    {
        return $this->action;
    }

    public function cells()
    {
        return $this->cells;
    }

    protected function buildState($state)
    {
        $options['state']['mode'] = $this->displayMode($options['state']['mode']);
        $options['state']['layout'] = $this;
        if ($this->label !== null) {
            $options['state']['label'] = $this->label;
        }
        if ($this->required === false) {
            $options['state']['required'] = $this->required;
        }
    }

    public function buildForms($data, $options)
    {
        //dump('Group FORMS : '.$this->formName());
        //dump($data);
        //dump($options);
        $options['state']['layout'] = $this;
        if ($this->label !== null) {
            $options['state']['label'] = $this->label;
        }
        if ($this->required === false) {
            $options['state']['required'] = $this->required;
        }
        if ($this->form) {
            //dump('Group : BUILD FORMS');
            //dump($options);
            $builderData = $this->formData($data, $options['state']);
            $builderOptions = $this->buildOptions($builderData, $options);
            //dump($builderOptions);
            $builder = $this->formBuilder($builderData, $builderOptions, ($this->name ? null : false));
            if ($this->method) {
                $builder->setMethod($this->method);
            }
            if ($this->action) {
                $builder->setAction(Service::path($this->action));
            }
            $this->buildForm($builder, $data, null, $options);
            //dump('Group : FORM BUILDER');
            //dump($builder);
            $form = $builder->getForm();
            return [$this->formName() => $form];
        }
        $forms = [];
        foreach ($this->cells() as $cell) {
            $forms = array_merge($forms, $cell->buildForms($data, $options));
        }
        return $forms;
    }

    public function buildForm(FormBuilderInterface $builder, $data, array $state, array $options = [])
    {
        //dump('BUILD GROUP : '.$this->formName());
        //dump($data);
        //dump($state);
        //dump($options);
        $state = $this->buildState($state);
        if ($state['mode'] == 'withhold') {
            return;
        }
        $data = $this->formData($data, $state);
        //dump($data);
        $options = $this->buildOptions($data, $options);
        //dump($options);
        if (!$this->form && $this->name) {
            $layoutBuilder = $this->formBuilder([$this->name => $data], $state, $options);
            //dump('GROUP : CELL BUILDER');
            //dump($layoutBuilder);
            $builder->add($layoutBuilder);
            foreach ($this->cells() as $cell) {
                $cell->buildForm($layoutBuilder, $data, $dataKey, $options);
            }
        } else {
            foreach ($this->cells() as $cell) {
                $cell->buildForm($builder, $data, $state, $options);
            }
        }
    }

    public function renderView($data, array $state, $forms = null, $form = null)
    {
        //dump('RENDER GROUP : '.$this->formName());
        //dump($data);
        //dump($state);
        //dump($forms);
        //dump($form);
        if ($this->template()) {
            $context = $this->defaultContext();
            $context['state'] = array_replace_recursive($context['state'], $state);
            $state['mode'] = $this->displayMode($state['mode']);
            $data = $this->formData($data, $state);
            $context = $this->viewContext($data, $context, $state);
            $context['layout'] = $this;
            if ($forms && $form === null && isset($forms[$this->formName($state['name'])])) {
                $form = $forms[$this->formName($state['name'])];
            }
            $form = (isset($form[$this->formName($state['name'])]) ? $form[$this->formName($state['name'])] : $form);
            //dump($form);
            $context['forms'] = $forms;
            $context['form'] = $form;
            if (isset($state['label']) && $state['label'] === true) {
                $context['label'] = $this->keyword();
            } else {
                $context['label'] = false;
            }
            //dump($context);
            //dump($this->template());
            return Service::view()->renderView($this->template(), $context);
        }
        return '';
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_group');

        // Fields
        $builder->addField('form', 'boolean');
        $builder->addStringField('name', 30);
        $builder->addStringField('method', 10);
        $builder->addStringField('action', 30);
        $builder->addStringField('mode', 10);
        $builder->addStringField('template', 100);

        // Associations
        $builder->addOneToMany('cells', 'ARK\View\Cell', 'group');
    }
}
