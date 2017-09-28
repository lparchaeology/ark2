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
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;

abstract class Group extends Element
{
    protected $cells;

    public function __construct()
    {
        $this->cells = new ArrayCollection();
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
        //dump($data);
        //dump($state);
        //dump($options);
        $state = $this->buildState($data, $state);
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
        if ($state['mode'] === 'deny') {
            return;
        }
        $data = $this->buildData($data, $state);
        $options = $this->buildOptions($data, $state, $options);
        //dump($data);
        //dump($state);
        //dump($options);
        if ($this->name) {
            //dump('GROUP : CELL BUILDER '.$this->name);
            $layoutBuilder = $this->formBuilder([$this->name => $data], $state, $options);
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
        $metadata->setPrimaryTable(['name' => 'ark_view_group']);
        //$metadata->setInheritanceType(ClassMetadata::INHERITANCE_TYPE_NONE);
    }
}
