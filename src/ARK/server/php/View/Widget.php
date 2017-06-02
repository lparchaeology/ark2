<?php

/**
 * ARK View Widget
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

use ARK\Actor\Actor;
use ARK\Form\Type\PropertyType;
use ARK\Form\Type\ActionChoiceType;
use ARK\Form\Type\VocabularyChoiceType;
use ARK\Model\Item;
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ORM;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use ARK\Vocabulary\Vocabulary;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\SubmitButtonTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;

class Widget extends Element
{
    protected $forceName = false;
    protected $label = true;
    protected $vocabulary = null;
    protected $formTypeClass = '';
    protected $formOptions = '';
    protected $formOptionsArray = null;

    public function forceName()
    {
        return $this->forceName;
    }

    public function showLabel()
    {
        return $this->label;
    }

    public function vocabulary()
    {
        return $this->vocabulary;
    }

    public function formTypeClass()
    {
        if ($this->formTypeClass) {
            return $this->formTypeClass;
        }
        return parent::formTypeClass();
    }

    public function formOptions($mode, $data, $options)
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = ($this->formOptions ? json_decode($this->formOptions, true) : []);
        }
        $cellOptions = $options['cell'];
        unset($options['page']);
        unset($options['data']);
        unset($options['cell']);
        unset($options['forms']);
        unset($options['form']);
        if (is_subclass_of($this->formTypeClass(), SubmitButtonTypeInterface::class)) {
            unset($options['required']);
        }
        unset($options['sanitise']);
        $options = array_merge_recursive($this->formOptionsArray, $options);
        if ($options['label'] === null) {
            $options['label'] = $this->showLabel();
        }
        if ($options['label']) {
            if ($cellOptions['keyword']) {
                $options['label'] = $cellOptions['keyword'];
            } elseif ($this->keyword()) {
                $options['label'] = $this->keyword();
            }
        }
        // FIXME HACK Need to find a better way to build custom fields!
        if ($this->name() == 'dime_find_actions') {
            // TODO Current Actor
            $actor = Service::workflow()->actor();
            if ($actor) {
                $options['choices'] = Service::workflow()->actions($actor, $data);
            }
            $options['choice_value'] = 'name';
            $options['choice_name'] = 'name';
            $options['choice_label'] = 'keyword';
            $options['placeholder'] = null;
        }
        if ($this->vocabulary) {
            $options = $this->vocabularyOptions($this->vocabulary, $options);
        }
        return $options;
    }

    public function formData($data, $formId = null)
    {
        return null;
    }

    public function buildForm(FormBuilderInterface $builder, $mode, $data, $dataKey, $options = [])
    {
        if (is_array($data) && isset($data[$dataKey])) {
            $data = $data[$dataKey];
        }
        if ($data === null && $this->vocabulary && $options['required']) {
            $data = $this->vocabulary->defautlTerm();
        }
        $options = $this->formOptions($mode, $data, $options);
        // TODO check workflow instead!
        if ($this->mode == 'view' || $mode == 'edit') {
            $fieldBuilder = $this->formBuilder($data, $options);
            $builder->add($fieldBuilder);
        }
    }

    public function renderView($mode, $data, array $context = [], $forms = null, $form = null)
    {
        if (isset($form[$this->formName()])) {
            $context['widget'] = $this;
            $context['mode'] = $mode;
            $context['data'] = (isset($data[$form->vars['id']]) ? $this->formData($data[$form->vars['id']]) : null);
            $context['forms'] = $forms;
            $context['form'] = $form[$this->formName()];
            return Service::view()->renderView($this->template(), $context);
        }
        return '';
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_widget');

        // Fields
        $builder->addField('forceName', 'boolean', [], 'force_name');
        $builder->addField('label', 'boolean');
        $builder->addStringField('mode', 10);
        $builder->addStringField('template', 100);
        $builder->addStringField('formTypeClass', 100, 'form_type_class');
        $builder->addStringField('formOptions', 4000, 'form_options');

        // Associations
        $builder->addManyToOneField('vocabulary', Vocabulary::class, 'vocabulary', 'concept');
    }
}
