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
use Symfony\Component\Form\FormBuilderInterface;

abstract class Layout extends Element
{
    protected $schma = null;
    protected $formRoot = false;
    protected $cells = null;
    protected $grid = null;
    protected $elements = null;
    protected $parentCells = null;

    protected function init()
    {
        if ($this->grid !== null) {
            return;
        }
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

    public function formRoot()
    {
        return $this->formRoot;
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

    public function formDefaults($data)
    {
        $options['label'] = false;
        $options['mapped'] = false;
        return $options;
    }

    public function buildForms($data)
    {
        if ($this->formRoot) {
            $builder = $this->formBuilder($data, $this->formOptions($data));
            $this->buildForm($builder, $data[$this->element], $this->formOptions($data));
            return [$this->element => $builder->getForm()];
        }
        $forms = [];
        foreach ($this->cells() as $cell) {
            $forms = array_merge($forms, $cell->buildForms($data));
        }
        return $forms;
    }

    public function buildForm(FormBuilderInterface $builder, $data, $options = [])
    {
        foreach ($this->cells() as $cell) {
            $cell->buildForm($builder, $data, $options);
        }
    }

    public function renderView($data, $forms = null, $form = null, array $options = [])
    {
        if ($this->template()) {
            $options['layout'] = $this;
            $options['data'] = $data;
            $options['forms'] = $forms;
            $options['form'] = $form;
            return Service::renderView($this->template(), $options);
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
        $builder->addField('formRoot', 'boolean', [], 'form_root');

        // Associations
        $builder->addManyToOneField('schma', 'ARK\Model\Schema');
        $builder->addOneToMany('cells', 'ARK\View\Cell', 'layout');
    }
}
