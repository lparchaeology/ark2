<?php

/**
 * ARK View Group.
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
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;

abstract class Group extends Element
{
    protected $form = false;
    protected $method = '';
    protected $action = '';
    protected $cells;
    protected $parentCells;

    public function __construct()
    {
        $this->cells = new ArrayCollection();
    }

    public function isForm() : bool
    {
        return $this->form;
    }

    public function formMethod() : string
    {
        return $this->method;
    }

    public function formAction() : string
    {
        return $this->action;
    }

    public function cells() : iterable
    {
        return $this->cells;
    }

    public function buildState($data, iterable $state) : iterable
    {
        $state = parent::buildState($data, $state);
        $state['layout'] = $this;
        return $state;
    }

    public function buildForms($data, iterable $state, iterable $options) : iterable
    {
        //dump('GROUP FORMS : '.$this->id());
        //dump($this);
        //dump($data);
        //dump($state);
        //dump($options);
        $state = $this->buildState($data, $state);
        if ($this->form) {
            //dump('GROUP : BUILD FORMS '.$this->formName());
            $builderData = $this->buildData($data, $state);
            //dump($builderData);
            $builderOptions = $this->buildOptions($builderData, $state, $options);
            $builderOptions['attr']['id'] = $this->formName();
            //dump($builderOptions);
            //dump($state);
            $builder = $this->formBuilder($builderData, $state, $builderOptions);
            if ($this->method) {
                $builder->setMethod($this->method);
            }
            if ($this->action) {
                $builder->setAction(Service::path($this->action));
            }
            $this->buildForm($builder, $data, $state, $options);
            //dump('GROUP : FORM BUILDER '.$this->formName());
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

    public function buildForm(FormBuilderInterface $builder, $data, iterable $state, iterable $options = []) : void
    {
        //dump('BUILD GROUP : '.$this->id());
        //dump($data);
        //dump($state);
        //dump($options);
        $state = $this->buildState($data, $state);
        //dump($state);
        if ($state['mode'] === 'deny') {
            return;
        }
        $data = $this->buildData($data, $state);
        //dump($state);
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

    public function buildContext($data, iterable $state, FormView $form = null) : iterable
    {
        $context = parent::buildContext($data, $state, $form);
        $context['layout'] = $this;
        return $context;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_group');
    }

    public static function groupMetadata(ClassMetadata $metadata) : void
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
        $builder->addStringField('formType', 100, 'form_type');

        // Associations
        $builder->addOneToMany('cells', Cell::class, 'group');
    }
}
