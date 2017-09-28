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

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use Symfony\Component\Form\FormBuilderInterface;

class Form extends Group
{
    protected $method = '';
    protected $action = '';
    protected $formType = '';

    public function formMethod() : string
    {
        return $this->method;
    }

    public function formAction() : string
    {
        return $this->action;
    }

    public function formType() : string
    {
        return $this->formType;
    }

    public function buildForms($data, iterable $state, iterable $options) : iterable
    {
        //dump('BUILD FORMS : '.$this->id().' '.$this->name());
        //dump($data);
        //dump($state);
        //dump($options);
        $state = $this->buildState($data, $state);
        $builderData = $this->buildData($data, $state);
        //dump($builderData);
        $builderOptions = $this->buildOptions($builderData, $state, $options);
        $builderOptions['attr']['id'] = $this->name();
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
        //dump('GROUP : FORM BUILDER '.$this->name());
        //dump($builder);
        $form = $builder->getForm();
        return [$this->name() => $form];
    }

    public function buildForm(FormBuilderInterface $builder, $data, iterable $state, iterable $options = []) : void
    {
        //dump('BUILD FORM : '.$this->id());
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
        foreach ($this->cells() as $cell) {
            $cell->buildForm($builder, $data, $state, $options);
        }
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_form');
        $builder->setReadOnly();

        // Fields
        $builder->addStringField('name', 30);
        $builder->addStringField('mode', 10);
        $builder->addStringField('method', 10);
        $builder->addStringField('action', 30);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addStringField('template', 100);
        $builder->addStringField('formType', 100, 'form_type');

        // Associations
        $builder->addOneToMany('cells', Cell::class, 'group');
    }
}
