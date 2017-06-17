<?php

/**
 * ARK View Element
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

use ARK\Model\EnabledTrait;
use ARK\Model\KeywordTrait;
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Type;
use ARK\View\Cell;
use ARK\Vocabulary\Vocabulary;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class Element
{
    use EnabledTrait;
    use KeywordTrait;

    protected $element = null;
    protected $name = null;
    protected $type = null;
    protected $formTypeClass = null;
    protected $template = null;
    protected $mode = null;

    public function __construct($element, $type, $class = null, $template = null)
    {
        $this->element = $element;
        $this->type = (is_string($type) ? ORM::find(Type::class, $type) : $type);
        $this->class = $class;
        $this->template = $template;
    }

    public function id()
    {
        return $this->element;
    }

    public function formName($cellName = null)
    {
        if ($cellName) {
            return $cellName;
        }
        if ($this->name) {
            return $this->name;
        }
        return $this->element;
    }

    public function type()
    {
        return $this->type;
    }

    public function template()
    {
        if ($this->template) {
            return $this->template;
        }
        return $this->type->template();
    }

    public function defaultMode()
    {
        return $this->mode;
    }

    public function displayMode($parentMode)
    {
        if ($this->defaultMode() !== null && $parentMode == 'edit') {
            return $this->defaultMode();
        }
        return $parentMode;
    }

    public function formData($data, $state)
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
        $name = $this->formName($name);
        return (is_array($data) && array_key_exists($name, $data) ? $data[$name] : $data);
    }

    public function formTypeClass()
    {
        if ($this->formTypeClass) {
            return $this->formTypeClass;
        }
        return $this->type->formTypeClass();
    }

    public function defaultState($route = null)
    {
        $state['actor'] = null;
        $state['page'] = null;
        $state['layout'] = null;
        $state['field'] = null;
        $state['widget'] = null;
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

    protected function buildState($state)
    {
        $options = array_replace_recursive($this->defaultState(), $options);
    }

    public function defaultOptions($route = null)
    {
        return [];
    }

    public function buildOptions($data, array $state, array $options = [])
    {
        $options = array_replace_recursive($this->defaultOptions(), $options);
        if ($state['label']) {
            $options['label'] = ($state['keyword'] ? $state['keyword'] : $this->keyword());
        } else {
            $options['label'] = $state['label'];
        }
        $options['required'] = ($state['mode'] == 'view' ? false : $state['required']);
        return $options;
    }

    protected function vocabularyOptions(Vocabulary $vocabulary, array $options = [])
    {
        $options['choices'] = $vocabulary->terms();
        $options['choice_value'] = 'name';
        $options['choice_name'] = 'name';
        $options['choice_label'] = 'keyword';
        $options['placeholder'] = $vocabulary->keyword();
        return $options;
    }

    public function defaultContext($route = null)
    {
        $context['data'] = null;
        $context['forms'] = null;
        $context['form'] = null;
        return $context;
    }

    public function viewContext($data, $context = [], $state = [])
    {
        $context = array_replace_recursive($this->defaultContext(), $context, ['state' => $state]);
        $context['data'] = $data;
        return $context;
    }

    public function buildForms($data, $options)
    {
        return [];
    }

    public function buildForm(FormBuilderInterface $builder, $data, array $state, array $options = [])
    {
        //dump('BUILD FORM : '.$this->formName());
        //dump($this);
        //dump($data);
        //dump($state);
        //dump($options);
        $state = $this->buildState($state);
        if ($state['mode'] == 'withhold') {
            return;
        }
        $data = $this->formData($data, $state);
        //dump($data);
        $options = $this->buildOptions($data, $options);
        //dump($options);
        $elementBuilder = $this->formBuilder($data, $state, $options);
        //dump($fieldBuilder);
        $builder->add($elementBuilder);
    }

    protected function formBuilder($data, $state, $options = [])
    {
        $options['state'] = $state;
        return Service::forms()->createNamedBuilder(
            $state['name'],
            $this->formTypeClass(),
            $data,
            $options
        );
    }

    public function renderView($data, array $state, $form = null)
    {
        $state = $this->buildState($state);
        if ($state['mode'] == 'withhold') {
            return;
        }
        if ($form) {
            $context = $this->viewContext($state, $data, $form);
            return Service::view()->renderView($this->template(), $context);
        }
        return $this->defaultView($data, $state);
    }

    public function defaultView($data, array $state)
    {
        return null;
    }

    public static function loadMetadata(ClassMetadata $metadata)
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
}
