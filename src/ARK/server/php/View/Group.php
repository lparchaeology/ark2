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

use ARK\Database\Database;
use ARK\Form\Type\PanelType;
use ARK\Model\Item\Item;
use ARK\ORM\ClassMetadata;
use ARK\Service;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormFactoryBuilder;
use Twig_Environment;

abstract class Group extends Element
{
    protected $grid = null;
    protected $elements = null;

    protected function init()
    {
        if ($this->grid !== null) {
            return;
        }
        foreach ($this->children as $child) {
            $this->grid[$child->row()][$child->col()][$child->seq()] = $child->element();
        }
        foreach ($this->grid as $rdx => $row) {
            foreach ($row as $cdx => $col) {
                foreach ($col as $cell) {
                    $this->elements[] = $cell;
                }
            }
        }
    }

    public function children()
    {
        return $this->children;
    }

    public function elements()
    {
        $this->init();
        return $this->elements;
    }

    public function renderView($resource, array $options = [], FormBuilderInterface $formBuilder = null)
    {
        if ($this->template()) {
            $options['layout'] = $this;
            $options['data'] = $resource;
            $formBuilder = Service::forms()->createNamedBuilder($this->element, $this->formType(), $resource);
            $this->buildForm($formBuilder);
            $options['forms'][$this->element] = $formBuilder->getForm()->createView();
            return Service::renderView($this->template(), $options);
        }
        return '';
    }

    public function buildForm(FormBuilderInterface $formBuilder, array $options = [])
    {
        foreach ($this->elements() as $element) {
            $element->buildForm($formBuilder);
        }
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
    }
}
