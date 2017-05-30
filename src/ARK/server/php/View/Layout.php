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

abstract class Layout extends Element
{
    protected $schma = null;
    protected $form = false;
    protected $method = null;
    protected $action = null;
    protected $cells = null;
    protected $grid = null;
    protected $elements = null;
    protected $parentCells = null;

    public function __construct()
    {
        $this->cells = new ArrayCollection();
    }

    protected function init()
    {
        if ($this->grid !== null) {
            return;
        }
        $this->grid = [];
        foreach ($this->cells as $cell) {
            $this->grid[$cell->row()][$cell->col()][$cell->seq()] = $cell;
        }
        foreach ($this->grid as $rdx => $row) {
            foreach ($row as $cdx => $col) {
                foreach ($col as $cell) {
                    $this->elements[] = $cell->element();
                }
            }
        }
    }

    public function schema()
    {
        return $this->schma;
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

    public function formOptions($mode, $data, $options)
    {
        return $options;
    }

    public function cells()
    {
        $this->init();
        return $this->cells;
    }

    public function elements()
    {
        $this->init();
        return $this->elements;
    }

    public function buildForms($mode, $data, $options)
    {
        //dump('FORMS : '.$this->element);
        //dump($mode);
        //dump($this->displayMode($mode));
        //dump($data);
        //dump($options);
        $mode = $this->displayMode($mode);
        if ($this->form) {
            $builder = $this->formBuilder($data, $options);
            if ($this->method) {
                $builder->setMethod($this->method);
            }
            if ($this->action) {
                $builder->setAction(Service::path($this->action));
            }
            $this->buildForm($builder, $mode, $data, $this->element, $this->formOptions($mode, $data, $options));
            return [$this->element => $builder->getForm()];
        }
        $forms = [];
        foreach ($this->cells() as $cell) {
            $forms = array_merge($forms, $cell->buildForms($mode, $data, $options));
        }
        return $forms;
    }

    public function buildForm(FormBuilderInterface $builder, $mode, $data, $dataKey, $options = [])
    {
        //dump('BUILD : '.$this->element);
        //dump($mode);
        //dump($data);
        //dump($options);
        foreach ($this->cells() as $cell) {
            $cell->buildForm($builder, $mode, $data, $dataKey, $options);
        }
    }

    public function renderView($mode, $data, array $context = [], $forms = null, $form = null)
    {
        //dump('RENDER FORMS : '.$this->element);
        //dump($mode);
        //dump($this->displayMode($mode));
        //dump($data);
        //dump($context);
        if ($this->template()) {
            $context['layout'] = $this;
            $context['mode'] = $this->displayMode($mode);
            $context['data'] = $data;
            $context['forms'] = $forms;
            $context['form'] = $form;
            if (isset($context['label']) && $context['label'] === true) {
                $context['label'] = $this->keyword();
            } else {
                $context['label'] = false;
            }
            return Service::view()->renderView($this->template(), $context);
        }
        return '';
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_layout');
    }

    public static function layoutMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_layout');

        // Fields
        $builder->addField('form', 'boolean');
        $builder->addStringField('method', 10);
        $builder->addStringField('action', 30);
        $builder->addStringField('mode', 10);
        $builder->addStringField('template', 100);

        // Associations
        $builder->addManyToOneField('schma', 'ARK\Model\Schema');
        $builder->addOneToMany('cells', 'ARK\View\Cell', 'layout');
    }
}
