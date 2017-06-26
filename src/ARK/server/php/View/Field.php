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
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use ARK\Workflow\Event;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilderInterface;

class Field extends Element
{
    protected $formOptions = '';
    protected $formOptionsArray = null;
    protected $display = null;
    protected $value = 'excluded';
    protected $parameter = null;
    protected $format = null;
    protected $attribute = null;

    public function attribute()
    {
        return $this->attribute;
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

    private function modeToModus(array $state, $modus)
    {
        if ($modus == 'hidden') {
            return 'hidden';
        }
        $mode = $state['mode'];
        if ($mode == 'view' || $modus == 'static') {
            return 'static';
        }
        if ($mode == 'edit') {
            if ($modus == 'readonly') {
                return 'readonly';
            }
            if ($modus == 'active' || $state['sanitise'] == 'redact') {
                return 'active';
            }
            if ($modus == 'disabled') {
                return 'disabled';
            }
            return 'readonly';
        }
        return 'static';
    }

    private function modusToFormType($modus, $active, $readonly = null, $static = null)
    {
        switch ($modus) {
            case 'hidden':
                return HiddenType::class;
            case 'static':
                return $static ?: StaticType::class;
            case 'readonly':
                return $readonly ?: $active;
        }
        return $active;
    }

    public function activeFormType()
    {
        return $this->attribute()->format()->activeFormType();
    }

    public function readonlyFormType()
    {
        return $this->attribute()->format()->readonlyFormType();
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

    public function buildState($data, array $state)
    {
        $state['required'] = $this->attribute()->isRequired();
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
        if ($state['sanitise'] != 'redact' && $data instanceof Item) {
            if ($state['mode'] == 'edit' && Service::workflow()->can($state['actor'], 'edit', $data, $this->attribute())) {
                $state['mode'] = 'edit';
            } elseif (Service::workflow()->can($state['actor'], 'view', $data, $this->attribute())) {
                $state['mode'] = 'view';
            } else {
                $state['mode'] = 'deny';
            }
        }
        $state['mode'] = $this->displayMode($state['mode']);
        $state['modus'] = $this->modeToModus($state, ($state['modus'] ?: $this->valueModus()));
        $state['template'] = $this->template();
        $state['field'] = $this;
        return $state;
    }

    public function buildData($data, array $state)
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

    public function buildOptions($property, array $state, array $options = [])
    {
        $options['state'] = $state;

        if ($state['label']) {
            $options['label'] = ($state['keyword'] ? $state['keyword'] : $this->keyword());
        } else {
            $options['label'] = false;
        }

        $options['state']['value']['modus'] = $this->modeToModus($state, $state['value']['modus']);
        $options['state']['value']['type'] = $this->modusToFormType(
            $options['state']['value']['modus'],
            $this->activeFormType(),
            $this->readonlyFormType(),
            $this->staticFormType()
        );
        $options['state']['value']['options'] = $this->valueOptions($options['state']);
        if ($this->display) {
            $options['state']['value']['display'] = $this->display;
        }

        if (isset($state['parameter']['modus'])) {
            $options['state']['parameter']['modus'] =
                $this->modeToModus($state, $options['state']['parameter']['modus']);
            $options['state']['parameter']['type'] =
                $this->modusToFormType($options['state']['parameter']['modus'], $this->parameterFormType());
            $options['state']['parameter']['options'] = $this->baseOptions($options['state']['parameter']);
        } else {
            $options['state']['parameter'] = null;
        }

        if (isset($state['format']['modus'])) {
            $options['state']['format']['modus'] =
                $this->modeToModus($state, $options['state']['format']['modus']);
            $options['state']['format']['type'] =
                $this->modusToFormType($options['state']['format']['modus'], $this->formatFormType());
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

    protected function valueOptions(array $state)
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = ($this->formOptions ? json_decode($this->formOptions, true) : []);
        }
        $options = $this->baseOptions($state, $this->formOptionsArray);
        // TODO Nicer way to set js date pickers?
        if ($state['value']['modus'] == 'active' && isset($options['widget']) && $options['widget'] == 'picker') {
            $options['widget'] = 'single_text';
            $options['html5'] = false;
            $picker = $this->attribute()->format()->datatype()->id().'picker';
            if (isset($options['attr']['class'])) {
                $options['attr']['class'] = $options['attr']['class'].' '.$picker;
            } else {
                $options['attr']['class'] = $picker;
            }
        } else {
            unset($options['widget']);
        }
        if ($state['choices'] && $state['value']['modus'] == 'active' && $this->attribute()->isItem()) {
            if (isset($state['select']['choices'])) {
                $choices = $state['select']['choices'];
            } else {
                $choices = ORM::findAll($this->attribute()->entity());
            }
            if ($choices) {
                $options['choices'] = $choices;
                if ($state['placeholder']) {
                    if (isset($state['select']['placeholder'])) {
                        $options['placeholder'] = $state['select']['placeholder'];
                    } else {
                        $options['placeholder'] = '';
                    }
                }
            }
        }
        if ($this->attribute()->hasVocabulary()) {
            $options = $this->vocabularyOptions($this->attribute()->vocabulary(), $options);
            if ($this->attribute()->isRequired() || $state['placeholder'] === false) {
                $options['placeholder'] = null;
            }
        }
        if ($this->attribute()->hasMultipleOccurrences()) {
            // TODO DO we need multiple???
            //$options['multiple'] = true;
            $options['compound'] = true;
        }
        return $options;
    }

    protected function baseOptions(array $state, array $options = [])
    {
        $options['mapped'] = false;
        $options['label'] = false;
        $options['compound'] = false;
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

    protected function concatOption(array $options, $option, $attr, $value)
    {
        if (isset($options[$option][$attr])) {
            return $options[$option][$attr] . ' ' . $value;
        }
        return $value;
    }

    public function buildContext($data, array $state, FormView $form = null)
    {
        $context = parent::buildContext($data, $state, $form);
        $context['field'] = $this;
        return $context;
    }

    // FIXME Should probably have some way to use FormTypes here to render 'static' mode
    public function renderView($data, array $state)
    {
        $state = $this->buildState($data, $state);
        if ($state['mode'] == 'deny') {
            return null;
        }
        $data = $this->buildData($data, $state);
        $value = null;
        if ($data instanceof Item) {
            $data = $data->property($this->attribute()->name());
        }
        if ($data instanceof Property) {
            $value = $data->value();
            if (!$value) {
                return null;
            }
            if ($this->attribute()->hasMultipleOccurrences() && is_array($value)) {
                $value = $value[0];
            }
            if (is_array($value)) {
                if ($this->display) {
                    $value = $value[$this->display];
                } elseif (isset($value[$this->attribute()->format()->valueName()])) {
                    $value = $value[$this->attribute()->format()->valueName()];
                }
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
                if (isset($this->display)) {
                    return $value->property($this->display)
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
