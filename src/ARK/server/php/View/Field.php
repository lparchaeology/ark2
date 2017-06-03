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

    public function formName()
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

    private function modeToModus($mode, $modus)
    {
        if ($modus == 'hidden') {
            return $modus;
        }
        if ($mode == 'view') {
            return 'static';
        }
        return $modus;
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

    public function formOptions($mode, $property, $options)
    {
        $cellOptions = $options['cell'];
        unset($options['page']);
        unset($options['cell']);
        unset($options['forms']);
        //unset($options['form']);
        $options['mode'] = $mode;

        if ($this->display) {
            $options['display'] = $this->display;
        }

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
        $options['field']['object'] = $this;
        $options['field']['value'] = $this->valueOptions($mode, $cellOptions['value']);
        $options['field']['parameter'] = $this->baseOptions(
            $mode,
            $cellOptions['parameter'],
            [],
            $this->parameterModus(),
            $this->parameterFormType()
        );
        $options['field']['format'] = $this->baseOptions(
            $mode,
            $cellOptions['format'],
            [],
            $this->formatModus(),
            $this->formatFormType()
        );
        if ($options['required'] || $this->attribute()->isRequired()) {
            $options['default_data'] = $this->attribute->defaultValue();
        }
        if ($mode == 'view' || $options['field']['value']['modus'] != 'active') {
            $options['required'] = false;
        } elseif ($options['required'] === null) {
            $options['required'] = $this->attribute()->isRequired();
        }
        return $options;
    }

    protected function valueOptions($mode, $cellOptions)
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
            $options = $this->vocabularyOptions($this->attribute()
                ->vocabulary(), $options);
        }
        if ($this->attribute()->hasMultipleOccurrences()) {
            $options['multiple'] = true;
        }
        // TODO Use visibility instead
        //if (!Service::security()->isLoggedIn() && $this->attribute()->hasVocabulary()) {
        //    $options['disabled'] = true;
        //}
        return $this->baseOptions(
            $mode,
            $cellOptions,
            $options,
            $this->valueModus(),
            $this->valueFormType(),
            $this->staticFormType()
        );
    }

    protected function baseOptions($mode, $cellOptions, $subOptions, $modus, $formType, $staticType = StaticType::class)
    {
        if (! $modus) {
            return null;
        }
        $base['modus'] = $this->modeToModus($mode, ($cellOptions['modus'] ?: $modus));
        $base['type'] = $this->modusToFormType($base['modus'], $formType, $staticType);
        $base['options'] = $subOptions;
        $base['options']['mapped'] = false;
        $base['options']['label'] = false;
        if ($base['modus'] == 'disabled') {
            $base['options']['disabled'] = true;
        }
        if ($base['modus'] == 'readonly') {
            if ($this->attribute()->hasVocabulary()) {
                $base['options']['attr']['class'] = $this->concatOption($base, 'attr', 'class', 'readonly-select');
            } else {
                $base['options']['attr']['readonly'] = true;
            }
        }
        return $base;
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

    public function formData($data, $dataKey = null)
    {
        if (is_array($data)) {
            if (isset($data[$dataKey])) {
                $data = $data[$dataKey];
            } elseif (isset($data[$this->name()])) {
                $data = $data[$this->name()];
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

    protected function fieldBuilder($mode, $data, $dataKey, $options = [])
    {
        $options = $this->formOptions($this->displayMode($mode), $data, $options);
        return $this->formBuilder($data, $options);
    }

    protected function sanitise($options)
    {
        // TODO Service::workflow()->hasVisibility($actor, $this->attribute())???
        if (!Service::workflow()->hasPermission($this->attribute->readPermission())) {
            if (isset($options['sanitise']) && $options['sanitise'] == 'redact') {
                return 'redact';
            }
            return 'withhold';
        }
        return null;
    }

    public function buildForm(FormBuilderInterface $builder, $mode, $data, $dataKey, $options = [])
    {
        //dump('BUILD FIELD : '.$this->element.' '.$this->attribute()->name());
        //dump($mode);
        //dump($this->displayMode($mode));
        //dump($data);
        //dump($dataKey);
        //dump($this);
        //dump($options);
        if ($this->sanitise($options) == 'withhold') {
            return;
        }
        unset($options['sanitise']);
        $data = $this->formData($data, $dataKey);
        $fieldBuilder = $this->fieldBuilder($mode, $data, $dataKey, $options);
        $builder->add($fieldBuilder);
    }

    public function renderView($mode, $data, array $context = [], $forms = null, $form = null)
    {
        //dump('RENDER FIELD : '.$this->element);
        //dump($mode);
        //dump($this->displayMode($mode));
        //dump($data);
        //dump($form);
        $sanitise = $this->sanitise($context);
        if ($sanitise == 'withhold') {
            return;
        } elseif ($form && isset($form->vars['id'])) {
            $data = $this->formData($data, $form->vars['id']);
        } else {
            $data = $this->formData($data);
        }
        if ($form && $this->template()) {
            $context['field'] = $this;
            $context['mode'] = $this->displayMode($mode);
            $context['modus'] = $this->modeToModus($context['mode'], ($context['modus'] ?: $this->valueModus()));
            $context['data'] = $data;
            $context['forms'] = $forms;
            $context['form'] = $form;
            //dump($context);
            //dump($data);
            return Service::view()->renderView($this->template(), $context);
        }

        // FIXME Should probably have some way to use FormTypes here to render 'flat' compond values
        $value = null;
        $item = null;
        $options = $this->valueOptions('view', ['mode' => 'view', 'modus' => 'static']);
        // TODO Now what? Render out just the Value child?
        //$fieldBuilder = $this->fieldBuilder('view', $data, $this->name(), $options);
        //dump($fieldBuilder);

        if ($data instanceof Item) {
            $item = $data;
        } elseif (is_array($data) && isset($data['data'])) {
            $item = $data['data'];
        }

        if ($item instanceof Item) {
            $value = 'FIXME: ' . $this->element;
            $value = $item->property($this->attribute()
                ->name())
                ->value();
            if ($value === null) {
                return null;
            }
            if ($value instanceof Actor) {
                return $value->property('fullname')
                    ->value()
                    ->content();
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
            if ($value instanceof Term) {
                return Service::translate($value->keyword());
            }
            if ($this->attribute()
                ->format()
                ->datatype()
                ->id() == 'text') {
                return $item->property($this->attribute->name())
                    ->value()
                    ->content();
            }
            if (is_array($value)) {
                $value = $value[$this->attribute()
                    ->format()
                    ->valueName()];
            }
            if ($this->attribute()->hasVocabulary()) {
                return Service::translate($value->keyword());
            }
            if ($value instanceof \DateTime) {
                return $value->format('Y-m-d H:i:s');
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
