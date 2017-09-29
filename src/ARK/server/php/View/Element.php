<?php

/**
 * ARK View Element.
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
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Vocabulary;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;

abstract class Element implements ElementInterface
{
    use KeywordTrait;

    protected $element = '';
    protected $type;
    protected $name = '';
    protected $mode = '';
    protected $template = '';
    protected $formType = '';

    public function __construct(string $element, $type, string $formType = null, string $template = null)
    {
        $this->element = $element;
        $this->type = (is_string($type) ? ORM::find(Type::class, $type) : $type);
        $this->formType = $formType;
        $this->template = $template;
    }

    public function id() : string
    {
        return $this->element;
    }

    public function name() : ?string
    {
        return $this->name;
    }

    public function type() : Type
    {
        return $this->type;
    }

    public function template() : string
    {
        if ($this->template) {
            return $this->template;
        }
        return $this->type->template();
    }

    public function mode() : string
    {
        return $this->mode;
    }

    public function displayMode(?string $parentMode) : ?string
    {
        if ($this->mode && $parentMode === 'edit') {
            return $this->mode;
        }
        return $parentMode;
    }

    public function buildData($data, iterable $state)
    {
        $name = $state['name'] ?? $this->name ?? null;
        if ($name && is_array($data) && array_key_exists($name, $data)) {
            return $data[$name];
        }
        return $data;
    }

    public function formType() : string
    {
        if ($this->formType) {
            return $this->formType;
        }
        return $this->type->formType();
    }

    public function defaultState($route = null) : iterable
    {
        $state['actor'] = null;
        $state['page'] = null;
        $state['layout'] = null;
        $state['field'] = null;
        $state['widget'] = null;
        $state['map'] = null;
        $state['vocabulary'] = null;
        $state['name'] = null;
        $state['mode'] = null;
        $state['modus'] = null;
        $state['sanitise'] = null;
        $state['label'] = null;
        $state['help'] = null;
        $state['keyword'] = null;
        $state['action'] = null;
        $state['required'] = true;
        $state['value']['modus'] = null;
        $state['parameter']['modus'] = null;
        $state['format']['modus'] = null;
        return $state;
    }

    public function buildState($data, iterable $state) : iterable
    {
        $state['name'] = $this->name();
        $state['mode'] = $this->displayMode($state['mode']);
        $state['template'] = $this->template();
        return $state;
    }

    public function defaultOptions($route = null) : iterable
    {
        return [];
    }

    public function buildOptions($data, iterable $state, iterable $options = []) : iterable
    {
        $options = array_replace_recursive($this->defaultOptions(), $options);
        if ($state['label']) {
            $options['label'] = $state['keyword'] ?? $this->keyword();
        }
        $options['required'] = ($state['mode'] === 'view' ? false : $state['required']);
        return $options;
    }

    public function defaultContext() : iterable
    {
        $context['state'] = null;
        $context['data'] = null;
        $context['form'] = null;
        $context['help'] = null;
        return $context;
    }

    public function buildContext($data, iterable $state, FormView $form = null) : iterable
    {
        $context = $this->defaultContext();
        $state = $this->buildState($data, $state);
        $context['state'] = $state;
        $context['data'] = $this->buildData($data, $state);
        $name = $state['name'];
        if ($form === null) {
            $context['form'] = ($state['forms'][$name] ?? $form);
        } else {
            $context['form'] = ($form[$name] ?? $form);
        }
        if ($state['label']) {
            $context['label'] = $state['keyword'] ?? $this->keyword();
        } else {
            $context['label'] = null;
        }
        if ($state['help'] && $state['modus'] === 'active') {
            $context['help'] = $state['keyword'] ?? $this->keyword();
        }
        return $context;
    }

    public function buildForm(FormBuilderInterface $builder, $data, iterable $state, iterable $options = []) : void
    {
        //dump('BUILD FORM : '.get_class($this).' '.$this->id().' '.$this->name().' '.$this->keyword());
        //dump($this);
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
        $elementBuilder = $this->formBuilder($data, $state, $options);
        $builder->add($elementBuilder);
    }

    public function renderView($data, iterable $state, FormView $form = null) : string
    {
        dump('RENDER FORM : '.get_class($this).' '.$this->id().' '.$this->keyword());
        $context = $this->buildContext($data, $state, $form);
        //dump($data);
        //dump($state);
        //dump($form);
        dump($context);
        if ($context['state']['mode'] === 'deny') {
            return '';
        }
        return Service::view()->renderView($context['state']['template'], $context);
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_element');
        $builder->setReadOnly();
        $builder->setJoinedTableInheritance()->setDiscriminatorColumn('type', 'string', 10);
        $viewTypes = Service::database()->getViewTypes();
        foreach ($viewTypes as $type) {
            $metadata->addDiscriminatorMapClass($type['type'], $type['class']);
        }

        // Key
        $builder->addStringKey('element', 30);

        // Relationships
        $builder->addManyToOneField('type', Type::class, 'type', 'type', false);
    }

    protected function vocabularyOptions(Vocabulary $vocabulary, iterable $options = []) : iterable
    {
        $options['choices'] = $vocabulary->terms();
        $options['choice_value'] = 'name';
        $options['choice_name'] = 'name';
        $options['choice_label'] = 'keyword';
        return $options;
    }

    protected function formBuilder($data, $state, $options = []) : FormBuilderInterface
    {
        return Service::forms()->createNamedBuilder(
            $state['name'],
            $this->formType(),
            $data,
            $options
        );
    }
}
