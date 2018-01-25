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
use ARK\Vocabulary\Concept;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;

abstract class Element implements ElementInterface
{
    use KeywordTrait;

    protected $element = '';
    protected $type;
    protected $name;
    protected $mode = '';
    protected $template;
    protected $formType;
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

    public function template() : ?string
    {
        return $this->template ?? $this->type->template();
    }

    public function formType() : ?string
    {
        return $this->formType ?? $this->type->formType();
    }

    public function cells() : iterable
    {
        return $this->cells ?? [];
    }

    public function defaultState($route = null) : iterable
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

    public function buildView(iterable $parent = []) : iterable
    {
        //dump('BUILD VIEW : '.get_class($this).' '.$this->id().' '.$this->name().' '.$this->keyword());
        //dump($parent);
        $view['element'] = $this;

        $view['state'] = $this->buildState($parent['data'], $parent['state']);
        $view['data'] = $this->buildData($parent['data'], $view['state']);
        $view['options'] = $this->buildOptions($view['data'], $view['state'], $parent['options']);
        $view['children'] = $this->buildChildren($view);
        if ($view['state']['label']) {
            $view['label'] = $view['state']['keyword'] ?? $this->keyword();
        } else {
            $view['label'] = $view['state']['label'];
        }
        if ($view['state']['help'] && $view['state']['modus'] === 'active') {
            $view['help'] = $view['state']['keyword'] ?? $this->keyword();
        } else {
            $view['help'] = null;
        }
        //dump($view);
        return $view;
    }

    public function buildForms(iterable $view) : iterable
    {
        return [];
    }

    public function buildForm(iterable $view, FormBuilderInterface $builder) : void
    {
        //dump('BUILD FORM : '.get_class($this).' '.$this->id().' '.$this->name().' '.$this->keyword());
        //dump($view);
        $state = $view['state'];
        if ($state['mode'] === 'deny') {
            return;
        }
        $elementBuilder = $this->formBuilder($state['name'], $state['form']['type'], $view['data'], $view['options']);
        $builder->add($elementBuilder);
    }

    public function renderView(iterable $view, iterable $forms = [], FormView $form = null) : string
    {
        //dump('RENDER VIEW : '.get_class($this).' '.$this->id().' '.$this->keyword());
        //dump($view);
        //dump($form);
        if ($view['state']['mode'] === 'deny') {
            return '';
        }
        $view = $this->buildContext($view, $forms, $form);
        //dump($view);
        return Service::view()->renderView($view['state']['template'], $view);
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
        if ($name) {
            if (is_array($data) && array_key_exists($name, $data)) {
                return $data[$name];
            }
            return null;
        }
        return $data;
    }

    protected function buildState($data, iterable $state) : iterable
    {
        $this->inheritValue($state, 'name', $this->name());
        $this->inheritValue($state, 'template', $this->template());
        $this->inheritGroupValue($state, 'form', 'type', $this->formType());
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

    protected function vocabularyOptions(Concept $vocabulary, iterable $options = []) : iterable
    {
        $options['choices'] = $vocabulary->terms();
        $options['choice_value'] = 'name';
        $options['choice_name'] = 'name';
        $options['choice_label'] = 'keyword';
        return $options;
    }

    protected function buildChildren(iterable $view) : iterable
    {
        return [];
    }

    protected function buildContext(iterable $view, iterable $forms = [], FormView $form = null) : iterable
    {
        $view['forms'] = $forms;
        $name = $view['state']['name'] ?? '';
        if ($form === null) {
            $view['form'] = ($view['forms'][$name] ?? null);
        } else {
            $view['form'] = ($form[$name] ?? $form);
        }
        return $view;
    }

    protected function formBuilder(string $name, string $type, $data, iterable $options = []) : FormBuilderInterface
    {
        return Service::forms()->createNamedBuilder($name, $type, $data, $options);
    }

    protected function concat(iterable $options, string $option, string $value) : string
    {
        return isset($options[$attr]) ? $options[$attr].' '.$value : $value;
    }

    protected function concatAttr(iterable $options, string $attr, string $value) : string
    {
        return isset($options['attr'][$attr]) ? $options['attr'][$attr].' '.$value : $value;
    }

    protected function concatOption(iterable $options, string $option, string $attr, string $value) : string
    {
        return isset($options[$option][$attr]) ? $options[$option][$attr].' '.$value : $value;
    }

    protected function inheritValue(iterable &$array, $key, $value) : void
    {
        $array[$key] = $array[$key] ?? $value;
    }

    protected function inheritGroupValue(iterable &$array, $group, $key, $value) : void
    {
        $array[$group][$key] = $array[$group][$key] ?? $value;
    }

    protected function inheritOptionalValue(iterable &$array, $key, $value) : void
    {
        if ($value !== null) {
            $array[$key] = $array[$key] ?? $value;
        }
    }

    protected function inheritOptionalGroupValue(iterable &$array, $group, $key, $value) : void
    {
        if ($value !== null) {
            $array[$group][$key] = $array[$group][$key] ?? $value;
        }
    }

    protected function setValue(iterable &$array, $key, $value) : void
    {
        $array[$key] = $value;
    }

    protected function setGroupValue(iterable &$array, $group, $key, $value) : void
    {
        $array[$group][$key] = $value;
    }

    protected function setOptionalValue(iterable &$array, $key, $value) : void
    {
        if ($value !== null) {
            $array[$key] = $value;
        }
    }

    protected function setOptionalGroupValue(iterable &$array, $group, $key, $value) : void
    {
        if ($value !== null) {
            $array[$group][$key] = $value;
        }
    }
}
