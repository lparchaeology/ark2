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

use ARK\Model\EnabledTrait;
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
    use EnabledTrait;
    use KeywordTrait;

    protected $element = '';
    protected $name = '';
    protected $type;
    protected $formTypeClass = '';
    protected $template = '';
    protected $mode = '';

    public function __construct(string $element, $type, string $formTypeClass = null, string $template = null)
    {
        $this->element = $element;
        $this->type = (is_string($type) ? ORM::find(Type::class, $type) : $type);
        $this->formTypeClass = $formTypeClass;
        $this->template = $template;
    }

    public function id() : string
    {
        return $this->element;
    }

    public function formName() : ?string
    {
        return $this->name;
        if ($this->name) {
            return $this->name;
        }
        return $this->element;
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
        $name = (isset($state['name'])) ? $state['name'] : null;
        if ($name && is_array($data) && array_key_exists($name, $data)) {
            return $data[$name];
        }
        if ($this->name) {
            if (is_array($data) && array_key_exists($this->name, $data)) {
                return $data[$this->name];
            }
            return null;
        }
        $name = $this->formName();
        return is_array($data) && array_key_exists($name, $data) ? $data[$name] : $data;
    }

    public function formTypeClass() : string
    {
        if ($this->formTypeClass) {
            return $this->formTypeClass;
        }
        return $this->type->formTypeClass();
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
        $state['keyword'] = null;
        $state['required'] = true;
        $state['value']['modus'] = null;
        $state['parameter']['modus'] = null;
        $state['format']['modus'] = null;
        return $state;
    }

    public function buildState($data, iterable $state) : iterable
    {
        $state['name'] = $this->formName();
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
            $options['label'] = ($state['keyword'] ? $state['keyword'] : $this->keyword());
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
            $context['label'] = ($state['keyword'] ? $state['keyword'] : $this->keyword());
        } else {
            $context['label'] = null;
        }
        if ($state['modus'] === 'active') {
            if ($state['keyword']) {
                $context['help'] = $state['keyword'];
            } elseif ($this->keyword()) {
                $context['help'] = $this->keyword();
            }
        }
        return $context;
    }

    public function buildForm(FormBuilderInterface $builder, $data, iterable $state, iterable $options = []) : void
    {
        //dump('BUILD FORM : '.get_class($this).' '.$this->id().' '.$this->keyword());
        //dump($this);
        //dump($data);
        //dump($state);
        //dump($options);
        $state = $this->buildState($data, $state);
        //dump($state);
        if ($state['mode'] === 'deny') {
            return;
        }
        $data = $this->buildData($data, $state);
        $options = $this->buildOptions($data, $state, $options);
        //dump($data);
        //dump($state);
        //dump($options);
        $elementBuilder = $this->formBuilder($data, $state, $options);
        //dump($elementBuilder);
        $builder->add($elementBuilder);
    }

    public function renderForm($data, iterable $state, FormView $form = null) : string
    {
        //dump('RENDER FORM : '.get_class($this).' '.$this->id().' '.$this->keyword());
        //dump($state);
        //dump($form);
        $context = $this->buildContext($data, $state, $form);
        //dump($context);
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

        // Fields
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToOneField('type', Type::class, 'type', 'type', false);
    }

    protected function vocabularyOptions(Vocabulary $vocabulary, iterable $options = []) : iterable
    {
        $options['choices'] = $vocabulary->terms();
        $options['choice_value'] = 'name';
        $options['choice_name'] = 'name';
        $options['choice_label'] = 'keyword';
        $options['placeholder'] = $vocabulary->keyword();
        return $options;
    }

    protected function formBuilder($data, $state, $options = []) : FormBuilderInterface
    {
        return Service::forms()->createNamedBuilder(
            $state['name'],
            $this->formTypeClass(),
            $data,
            $options
        );
    }
}
