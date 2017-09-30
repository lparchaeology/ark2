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
    protected $cells;

    public function __construct(string $element, $type, string $formType = null, string $template = null)
    {
        $this->element = $element;
        $this->type = (is_string($type) ? ORM::find(Type::class, $type) : $type);
        $this->formType = $formType;
        $this->template = $template;
        $this->cells = new ArrayCollection();
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

    public function mode() : string
    {
        return $this->mode;
    }

    public function template() : string
    {
        if ($this->template) {
            return $this->template;
        }
        return $this->type->template();
    }

    public function formType() : string
    {
        if ($this->formType) {
            return $this->formType;
        }
        return $this->type->formType();
    }

    public function cells() : iterable
    {
        return $this->cells;
    }

    public function buildView(iterable $parent = []) : iterable
    {
        //dump('BUILD VIEW : '.get_class($this).' '.$this->id().' '.$this->name().' '.$this->keyword());
        //dump($parent);
        $view['state'] = $this->buildState($parent['data'], $parent['state']);
        $view['data'] = $this->buildData($parent['data'], $view['state']);
        $view['options'] = $this->buildOptions($view['data'], $view['state'], $view['options']);
        $children = [];
        foreach ($this->cells() as $cell) {
            $children[] = $cell->buildView($view);
        }
        $view['children'] = $children;
        //dump($view);
        return $view;
    }

    public function buildForm(iterable $view, FormBuilderInterface $builder) : void
    {
        //dump('BUILD FORM : '.get_class($this).' '.$this->id().' '.$this->name().' '.$this->keyword());
        //dump($view);
        if ($view['state']['mode'] === 'deny') {
            return;
        }
        $elementBuilder = $this->formBuilder($view['state']['name'], $view['data'], $view['options']);
        $builder->add($elementBuilder);
    }

    public function renderView(iterable $view, FormView $form = null) : string
    {
        dump('RENDER VIEW : '.get_class($this).' '.$this->id().' '.$this->keyword());
        //dump($view);
        //dump($form);
        if ($view['state']['mode'] === 'deny') {
            return '';
        }
        $context = $this->buildContext($view, $form);
        //dump($context);
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

    protected function displayMode(?string $parentMode) : ?string
    {
        if ($this->mode && $parentMode === 'edit') {
            return $this->mode;
        }
        return $parentMode;
    }

    protected function buildData($data, iterable $state)
    {
        $name = $state['name'] ?? $this->name ?? null;
        if ($name && is_array($data) && array_key_exists($name, $data)) {
            return $data[$name];
        }
        return $data;
    }

    protected function defaultState($route = null) : iterable
    {
        $state['actor'] = null;
        $state['page'] = null;
        $state['element'] = null;
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

    protected function buildState($data, iterable $state) : iterable
    {
        $state['name'] = $this->name();
        $state['mode'] = $this->displayMode($state['mode']);
        $state['template'] = $this->template();
        return $state;
    }

    protected function defaultOptions($route = null) : iterable
    {
        return [];
    }

    protected function buildOptions($data, iterable $state, iterable $options = []) : iterable
    {
        $options = array_replace_recursive($this->defaultOptions(), $options);
        if ($state['label']) {
            $options['label'] = $state['keyword'] ?? $this->keyword();
        }
        $options['required'] = ($state['mode'] === 'view' ? false : $state['required']);
        return $options;
    }

    protected function vocabularyOptions(Vocabulary $vocabulary, iterable $options = []) : iterable
    {
        $options['choices'] = $vocabulary->terms();
        $options['choice_value'] = 'name';
        $options['choice_name'] = 'name';
        $options['choice_label'] = 'keyword';
        return $options;
    }

    protected function buildContext(iterable $view, FormView $form = null) : iterable
    {
        $state = $view['state'];
        $name = $state['name'];
        $context['state'] = $state;
        $context['data'] = $view['data'];
        if ($form === null) {
            $context['form'] = ($state['forms'][$name] ?? null);
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
        $context['element'] = $this;
        return $context;
    }

    protected function formBuilder(string $name, $data, $options = []) : FormBuilderInterface
    {
        return Service::forms()->createNamedBuilder(
            $name,
            $this->formType(),
            $data,
            $options
        );
    }
}
