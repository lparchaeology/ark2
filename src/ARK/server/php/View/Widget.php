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
use Symfony\Component\Form\FormBuilderInterface;

class Widget extends Element
{
    protected $label = true;
    protected $vocabulary = null;
    protected $formTypeClass = '';
    protected $formOptions = '';
    protected $formOptionsArray = null;

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

    public function formOptions($data, $options)
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = ($this->formOptions ? json_decode($this->formOptions, true) : []);
        }
        $cellOptions = $options['cell'];
        unset($options['cell']);
        unset($options['required']);
        unset($options['mode']);
        $options = array_merge_recursive($this->formOptionsArray, $options);
        if ($options['label'] === null) {
            $options['label'] = ($this->showLabel() ? $this->keyword() : false);
        }
        // FIXME HACK Need to find a better way to build custom fields!
        if ($this->name() == 'dime_find_actions') {
            // TODO Current Actor
            $actor = ORM::find(Actor::class, 'ahavfrue');
            $options['choices'] = Service::workflow()->actions($actor, $data);
            $options['choice_value'] = 'name';
            $options['choice_name'] = 'name';
            $options['choice_label'] = 'keyword';
            $options['placeholder'] = null;
        }
        if ($this->vocabulary) {
            $options = $this->vocabularyOptions($vocabulary, $options);
        }
        return $options;
    }

    public function formData($data)
    {
        return null;
    }

    public function buildForm(FormBuilderInterface $builder, $data, $options = [])
    {
        if ($options['mode'] == 'edit' && Service::isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $options = $this->formOptions($data, $options);
            $fieldBuilder = $this->formBuilder($data, $options);
            $builder->add($fieldBuilder);
        }
    }

    public function renderView($data, $forms = null, $form = null, array $options = [])
    {
        if (isset($form[$this->formName()])) {
            $options['data'] = $this->formData($data[$form->vars['id']]);
            $options['forms'] = $forms;
            $options['form'] = $form[$this->formName()];
            return Service::renderView($this->template(), $options);
        }
        return '';
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_widget');

        // Fields
        $builder->addField('label', 'boolean');
        $builder->addStringField('formTypeClass', 100, 'form_type_class');
        $builder->addStringField('formOptions', 4000, 'form_options');

        // Associations
        $builder->addManyToOneField('vocabulary', Vocabulary::class, 'vocabulary', 'concept');
    }
}
