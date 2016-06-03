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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\View;

use ARK\Database\Database;
use ARK\Form\Type\PanelType;
use ARK\Model\Item\Item;
use Twig_Environment;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Type\FormType;

abstract class Group extends Element
{
    protected $grid = array();
    protected $elements = array();

    protected function init(array $config, Item $resource = null)
    {
        parent::init($config, $resource);
        $children = $this->db->getGroupForModule($this->id, $resource->module()->id(), $resource->modtype());
        foreach ($children as $child) {
            $element = Element::get($this->db, $child['child'], $resource);
            if ($element->isValid()) {
                $this->elements[] = $element;
                $this->grid[$child['row']][$child['col']][$child['seq']] = $element;
            }
        }
        $this->valid = true;
    }

    public function elements()
    {
        return $this->elements;
    }

    public function render(Twig_Environment $twig, array $options = [], FormFactoryInterface $factory = null)
    {
        if ($this->template) {
            $options['layout'] = $this;
            if ($factory && $this->resource) {
                $options['forms'] = $this->renderForms($factory);
            }
            return $twig->render($this->template, $options);
        }
        return '';
    }

    public function renderForms(FormFactoryInterface $factory)
    {
        $forms = [];
        foreach ($this->elements() as $element) {
            $forms[$element->id()] = $element->renderForms($factory);
        }
        return $forms;
    }

    public function formData()
    {
        $data = array();
        foreach ($this->elements as $element) {
            $data = array_merge($data, $element->formData());
        }
        return $data;
    }

    public function buildForm(FormBuilder &$formBuilder, array $options = array())
    {
        if (!$this->isValid()) {
            return;
        }
        foreach ($this->elements as $element) {
            $element->buildForm($formBuilder, $options);
        }
    }

    public function allFields()
    {
        $fields = array();
        foreach ($this->elements as $element) {
            if ($element->type() == 'field') {
                $fields[] = $element;
            } else {
                $fields = array_merge($fields, $element->allFields());
            }
        }
        return $fields;
    }
}
