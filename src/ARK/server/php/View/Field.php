<?php

/**
 * ARK View Field
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
use ARK\Form\Type\StaticType;
use ARK\Model\Item;
use ARK\Model\Property;
use ARK\Model\Schema\SchemaAttribute;
use ARK\Model\LocalText;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use ARK\Workflow\Event;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

class Field extends Element
{
    protected $formTypeClass = '';
    protected $formOptions = '';
    protected $formOptionsArray = null;
    protected $label = true;
    protected $display = null;
    protected $value = 'excluded';
    protected $parameter = null;
    protected $format = null;
    protected $attribute = null;

    public function attribute()
    {
        return $this->attribute;
    }

    public function showLabel()
    {
        return $this->label;
    }

    public function valueModus()
    {
        return $this->value;
    }

    public function parameterModus()
    {
        if (!$this->attribute()->format()->parameterName()) {
            return null;
        }
        return ($this->parameter ?: 'hidden');
    }

    public function formatModus()
    {
        if (! $this->attribute()->format()->formatName()) {
            return null;
        }
        return ($this->format ?: 'hidden');
    }

    public function formName($name = null)
    {
        return $this->attribute->name();
    }

    public function formTypeClass()
    {
        if ($this->formTypeClass) {
            return $this->formTypeClass;
        }
        if ($this->attribute()->format()->formTypeClass()) {
            return $this->attribute()->format()->formTypeClass();
        }
        return parent::formTypeClass();
    }

    private function modeToModus($mode, $modus, $sanitise = null)
    {
        if ($modus == 'hidden') {
            return 'hidden';
        }
        if ($mode == 'view' || $modus == 'static') {
            return 'static';
        }
        if ($mode == 'edit') {
            if ($modus == 'readonly') {
                return 'readonly';
            }
            if (Service::workflow()->hasPermission($this->attribute->updatePermission()) || $sanitise == 'redact') {
                return 'active';
            }
            if ($modus == 'disabled') {
                return 'disabled';
            }
            return 'readonly';
        }
        return 'static';
    }

    private function modusToFormType($modus, $default, $static = StaticType::class)
    {
        switch ($modus) {
            case 'hidden':
                return HiddenType::class;
            case 'static':
                return $static;
        }
        return $default;
    }

    public function valueFormType()
    {
        return $this->attribute()->format()->valueFormType();
    }

    public function staticFormType()
    {
        return $this->attribute()->format()->staticFormType();
    }

    public function parameterFormType()
    {
        return $this->attribute()->format()->parameterFormType();
    }

    public function formatFormType()
    {
        return $this->attribute()->format()->formatFormType();
    }

    public function keyword()
    {
        return ($this->keyword ?: $this->attribute->keyword());
    }

    public function buildOptions($property, $options = [])
    {
        $state = $options['state'];
        unset($options['page']);
        unset($options['forms']);

        if ($this->display) {
            $options['display'] = $this->display;
        }

        if ($state['label'] === null) {
            $options['label'] = $this->showLabel();
        } else {
            $options['label'] = $state['label'];
        }
        if ($options['label']) {
            if ($state['keyword']) {
                $options['label'] = $state['keyword'];
            } elseif ($this->keyword()) {
                $options['label'] = $this->keyword();
            }
        }

        $options['state']['value']['modus'] =
            $this->modeToModus($state['mode'], $options['state']['value']['modus'], $state['sanitise']);
        $options['state']['value']['type'] =
            $this->modusToFormType($options['state']['value']['modus'], $this->valueFormType(), $this->staticFormType());
        $options['state']['value']['options'] = $this->valueOptions($state);

        if (isset($state['parameter']['modus'])) {
            $options['state']['parameter']['modus'] =
                $this->modeToModus($state['mode'], $options['state']['parameter']['modus']);
            $options['state']['parameter']['type'] =
                $this->modusToFormType($options['state']['parameter']['modus'], $this->parameterFormType());
            $options['state']['parameter']['options'] = $this->baseOptions($options['state']['parameter']);
        } else {
            $options['state']['parameter'] = null;
        }

        if (isset($state['format']['modus'])) {
            $options['state']['format']['modus'] =
                $this->modeToModus($state['mode'], $options['state']['parameter']['modus']);
            $options['state']['format']['type'] =
                $this->modusToFormType($options['state']['parameter']['modus'], $this->formatFormType());
            $options['state']['format']['options'] = $this->baseOptions($options['state']['format']);
        } else {
            $options['state']['format'] = null;
        }

        if ($state['required']) {
            $options['default_data'] = $this->attribute->defaultValue();
        }
        if ($state['mode'] == 'view' || $options['state']['value']['modus'] != 'active') {
            $options['required'] = false;
        } else {
            $options['required'] = $state['required'];
        }

        return $options;
    }

    protected function valueOptions($state)
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = ($this->formOptions ? json_decode($this->formOptions, true) : []);
        }
        $options = $this->formOptionsArray;
        // TODO Nicer way to set js date pickers?
        if (isset($options['widget']) && $options['widget'] == 'picker') {
            $options['widget'] = 'single_text';
            $options['html5'] = false;
            $picker = $this->attribute()->format()->datatype()->id().'picker';
            if (isset($options['attr']['class'])) {
                $options['attr']['class'] = $options['attr']['class'].' '.$picker;
            } else {
                $options['attr']['class'] = $picker;
            }
        }
        if ($this->attribute()->hasVocabulary()) {
            $options = $this->vocabularyOptions($this->attribute()->vocabulary(), $options);
        }
        if ($this->attribute()->hasMultipleOccurrences()) {
            $options['multiple'] = true;
        }
        return $this->baseOptions($state, $options);
    }

    protected function baseOptions($state, $options = [])
    {
        $options['mapped'] = false;
        $options['label'] = false;
        if ($state['modus'] == 'disabled') {
            $options['disabled'] = true;
        }
        if ($state['modus'] == 'readonly') {
            if ($this->attribute()->hasVocabulary()) {
                $options['attr']['class'] = $this->concatOption($options, 'attr', 'class', 'readonly-select');
            } else {
                $options['attr']['readonly'] = true;
            }
        }
        return $options;
    }

    protected function concatOption($options, $option, $attr, $value)
    {
        if (isset($options[$option][$attr])) {
            return $options[$option][$attr] . ' ' . $value;
        }
        return $value;
    }

    protected function vocabularyOptions(Vocabulary $vocabulary, $options = [])
    {
        $options = parent::vocabularyOptions($vocabulary, $options);
        if ($this->attribute()->isRequired()) {
            $options['placeholder'] = null;
        }
        return $options;
    }

    public function formData($data, $state)
    {
        $name = $state['name'];
        if (is_array($data)) {
            if (array_key_exists($name, $data)) {
                $data = $data[$name];
            } elseif (array_key_exists($this->name, $data)) {
                $data = $data[$this->name];
            } elseif (array_key_exists($this->id(), $data)) {
                $data = $data[$this->id()];
            }
        }
        if ($data instanceof Property) {
            return $data;
        }
        if ($data instanceof Item) {
            return $data->property($this->attribute->name());
        }
        return null;
    }

    protected function sanitise($state)
    {
        // TODO Service::workflow()->hasVisibility($actor, $this->attribute())???
        if (!Service::workflow()->hasPermission($this->attribute->readPermission())) {
            if ($state['sanitise'] == 'redact') {
                return 'redact';
            }
            return 'withhold';
        }
        return null;
    }

    protected function buildState($state)
    {
        if (!isset($state['label'])) {
            $state['label'] = $this->showLabel();
        }
        if (!isset($state['required'])) {
            $state['required'] = $this->attribute()->isRequired();
        }
        if (!isset($state['name'])) {
            $state['name'] = $this->formName();
        }
        if (!isset($state['keyword'])) {
            $state['keyword'] = $this->keyword();
        }
        if (!isset($state['value']['modus'])) {
            $state['value']['modus'] = $this->valueModus();
        }
        if (!isset($state['parameter']['modus'])) {
            $state['parameter']['modus'] = $this->parameterModus();
        }
        if (!isset($state['format']['modus'])) {
            $state['format']['modus'] = $this->formatModus();
        }
        $state['sanitise'] = $this->sanitise($state);
        $state['mode'] = $this->displayMode($state['mode']);
        $state['modus'] = $this->modeToModus($state['mode'], ($state['modus'] ?: $this->valueModus()), $state['sanitise']);
        $state['field'] = $this;
        return $state;
    }

    public function buildForm(FormBuilderInterface $builder, $data, $dataKey, $options = [])
    {
        dump('BUILD FIELD : '.$this->formName());
        //dump($data);
        //dump($dataKey);
        //dump($this);
        dump($options);
        $options['state'] = $this->buildState($options['state']);
        if ($options['state']['sanitise'] == 'withhold') {
            return;
        }
        $name = $options['state']['name'];
        $data = $this->formData($data, $options['state']);
        //dump($data);
        $options = $this->buildOptions($data, $options);
        dump($options);
        $fieldBuilder = $this->formBuilder($data, $options, $name);
        $builder->add($fieldBuilder);
    }

    public function renderView($data, array $state, $forms = null, $form = null)
    {
        //dump('RENDER FIELD : '.$this->formName());
        //dump($data);
        //dump($state);
        //dump($form);
        $state['sanitise'] = $this->sanitise($state);
        if ($state['sanitise'] == 'withhold') {
            return;
        }
        $state['mode'] = $this->displayMode($state['mode']);
        $state['modus'] = $this->modeToModus($state['mode'], ($state['modus'] ?: $this->valueModus()), $state['sanitise']);
        $state['field'] = $this;
        $data = $this->formData($data, $state);
        if ($form && $this->template()) {
            $context = $this->defaultContext();
            $context['state'] = array_replace_recursive($context['state'], $state);
            $context['data'] = $data;
            $context['forms'] = $forms;
            $context['form'] = $form[$this->formName()];
            //dump($context);
            //dump($this->template());
            return Service::view()->renderView($this->template(), $context);
        }

        // FIXME Should probably have some way to use FormTypes here to render 'flat' compond values
        $value = null;
        if ($data instanceof Item) {
            $data = $data->property($this->attribute()->name());
        }
        if ($data instanceof Property) {
            $value = $data->value();
            if ($value === null) {
                return null;
            }
            if (is_array($value)) {
                $value = $value[$this->attribute()->format()->valueName()];
            }
            if ($value instanceof Actor) {
                return $value->property('fullname')->value()->content();
            }
            if ($value instanceof Event) {
                $type = $value->property('type')->value();
                if ($type instanceof Term) {
                    return Service::translate($type->keyword());
                }
                return $type;
            }
            if ($value instanceof Item) {
                if (isset($context['options']['display_property'])) {
                    return $value->property($context['options']['display_property'])
                        ->value()
                        ->content();
                }
                return $value->property('id')->serialize();
            }
            if ($value instanceof LocalText) {
                return $value->content();
            }
            if ($value instanceof Term) {
                return Service::translate($value->keyword());
            }
            if ($value instanceof \DateTime) {
                return $value->format('Y-m-d H:i:s');
            }
            if ($this->attribute()->hasVocabulary()) {
                return Service::translate($value);
            }
        }
        return $value;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_field');

        // Fields
        $builder->addStringField('formTypeClass', 100, 'form_type_class');
        $builder->addStringField('formOptions', 4000, 'form_options');
        $builder->addField('label', 'boolean');
        $builder->addStringField('display', 30);
        $builder->addStringField('value', 10);
        $builder->addStringField('parameter', 10);
        $builder->addStringField('format', 10);
        $builder->addStringField('template', 100);

        // Associations
        $builder->addCompositeManyToOneField('attribute', 'ARK\Model\Schema\SchemaAttribute', [
            [
                'column' => 'schma',
                'nullable' => true
            ],
            [
                'column' => 'item_type',
                'reference' => 'type',
                'nullable' => true
            ],
            [
                'column' => 'attribute',
                'nullable' => true
            ]
        ]);
    }
}
