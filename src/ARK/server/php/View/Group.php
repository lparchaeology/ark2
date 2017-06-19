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
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

abstract class Group extends Element
{
    protected $form = null;
    protected $method = null;
    protected $action = null;
    protected $cells = null;
    protected $parentCells = null;

    public function __construct()
    {
        $this->cells = new ArrayCollection();
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

    public function buildState(array $state)
    {
        $state = parent::buildState($state);
        $state['layout'] = $this;
        return $state;
    }

    public function buildForms($data, array $state, array $options)
    {
        //dump('GROUP FORMS : '.$this->formName());
        //dump($this);
        //dump($data);
        //dump($state);
        //dump($options);
        $state = $this->buildState($state);
        if ($this->form) {
            //dump('GROUP : BUILD FORMS');
            $builderData = $this->buildData($data, $state);
            $builderOptions = $this->buildOptions($builderData, $state, $options);
            //dump($builderOptions);
            $builder = $this->formBuilder($builderData, $state, $builderOptions);
            if ($this->method) {
                $builder->setMethod($this->method);
            }
            if ($this->action) {
                $builder->setAction(Service::path($this->action));
            }
            $this->buildForm($builder, $data, $state, $options);
            //dump('Group : FORM BUILDER');
            //dump($builder);
            $form = $builder->getForm();
            return [$this->formName() => $form];
        }
        $forms = [];
        foreach ($this->cells() as $cell) {
            $forms = array_merge($forms, $cell->buildForms($data, $state, $options));
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
        $data = $this->buildData($data, $state);
        //dump($data);
        $options = $this->buildOptions($data, $state, $options);
        //dump($options);
        if (!$this->form && $this->name) {
            $layoutBuilder = $this->formBuilder([$this->name => $data], $state, $options);
            //dump('GROUP : CELL BUILDER');
            //dump($layoutBuilder);
            $builder->add($layoutBuilder);
            foreach ($this->cells() as $cell) {
                $cell->buildForm($layoutBuilder, $data, $state, $options);
            }
        } else {
            foreach ($this->cells() as $cell) {
                $cell->buildForm($builder, $data, $state, $options);
            }
        }
    }

    public function buildContext($data, array $state, FormView $form = null)
    {
        $context = parent::buildContext($data, $state, $form);
        $context['layout'] = $this;
        return $context;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_group');
    }

    public static function groupMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_group');
        $builder->setReadOnly();

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
