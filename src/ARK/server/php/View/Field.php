<?php

/**
 * ARK View Field.
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

use ARK\Actor\Actor;
use ARK\Form\Type\StaticType;
use ARK\Model\Item;
use ARK\Model\LocalText;
use ARK\Model\Property;
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Workflow\Event;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormView;

class Field extends Element
{
    protected $formOptions = '';
    protected $formOptionsArray;
    protected $display = '';
    protected $value = 'excluded';
    protected $parameter = '';
    protected $format = '';
    protected $attribute;

    public function attribute() : SchemaAttribute
    {
        return $this->attribute;
    }

    public function valueModus() : string
    {
        return $this->value;
    }

    public function parameterModus() : ?string
    {
        if (!$this->attribute()->dataclass()->parameterName()) {
            return null;
        }
        return $this->parameter ?: 'hidden';
    }

    public function formatModus() : ?string
    {
        if (!$this->attribute()->dataclass()->formatName()) {
            return null;
        }
        return $this->format ?: 'hidden';
    }

    public function formName() : string
    {
        return $this->attribute->name();
    }

    public function formType() : string
    {
        if ($this->formType) {
            return $this->formType;
        }
        if ($this->attribute()->dataclass()->formType()) {
            return $this->attribute()->dataclass()->formType();
        }
        return parent::formType();
    }

    public function activeFormType() : ?string
    {
        return $this->attribute()->dataclass()->activeFormType();
    }

    public function readonlyFormType() : ?string
    {
        return $this->attribute()->dataclass()->readonlyFormType();
    }

    public function staticFormType() : ?string
    {
        return $this->attribute()->dataclass()->staticFormType();
    }

    public function parameterFormType() : ?string
    {
        return $this->attribute()->dataclass()->parameterFormType();
    }

    public function formatFormType() : ?string
    {
        return $this->attribute()->dataclass()->formatFormType();
    }

    public function keyword() : ?string
    {
        return $this->keyword ?? $this->attribute->keyword();
    }

    public function buildState($data, iterable $state) : iterable
    {
        $state['required'] = $this->attribute()->isRequired();
        $state['multiple'] = $this->attribute->hasMultipleOccurrences();
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
        if ($state['sanitise'] !== 'redact' && $data instanceof Item) {
            if ($state['mode'] === 'edit' && Service::workflow()->can($state['actor'], 'edit', $data, $this->attribute())) {
                $state['mode'] = 'edit';
            } elseif (Service::workflow()->can($state['actor'], 'view', $data, $this->attribute())) {
                $state['mode'] = 'view';
            } else {
                $state['mode'] = 'deny';
            }
        }
        $state['mode'] = $this->displayMode($state['mode']);
        $state['modus'] = $this->modeToModus($state, ($state['modus'] ?? $this->valueModus()));
        $state['template'] = $this->template();
        $state['field'] = $this;
        return $state;
    }

    public function buildData($data, iterable $state)
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

    public function buildOptions($data, iterable $state, iterable $options = []) : iterable
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
        if ($state['mode'] === 'view' || $options['state']['value']['modus'] !== 'active') {
            $options['required'] = false;
        } else {
            $options['required'] = $state['required'];
        }
        $options['state']['value']['options']['required'] = $options['required'];

        return $options;
    }

    public function buildContext($data, iterable $state, FormView $form = null) : iterable
    {
        $context = parent::buildContext($data, $state, $form);
        $context['field'] = $this;
        return $context;
    }

    // FIXME Should probably have some way to use FormTypes here to render 'static' mode
    public function renderView($data, iterable $state) : string
    {
        //dump('RENDER FIELD '.$this->id().' '.$this->keyword());
        $state = $this->buildState($data, $state);
        if ($state['mode'] === 'deny') {
            return '';
        }
        $data = $this->buildData($data, $state);
        $value = '';
        if ($data instanceof Item) {
            $data = $data->property($this->attribute()->name());
        }
        if ($data instanceof Property) {
            $value = $data->value();
            if (!$value) {
                return '';
            }
            if ($this->attribute()->hasMultipleOccurrences() && is_array($value)) {
                $value = $value[0];
            }
            if (is_array($value)) {
                if ($this->display) {
                    $value = $value[$this->display];
                } elseif (isset($value[$this->attribute()->dataclass()->valueName()])) {
                    $value = $value[$this->attribute()->dataclass()->valueName()];
                }
            }
            if ($value instanceof Actor) {
                return $value->property('fullname')->value()->content();
            }
            if ($value instanceof Event) {
                $class = $value->property('class')->value();
                if ($class instanceof Term) {
                    return Service::translate($class->keyword());
                }
                return $class;
            }
            if ($value instanceof Item) {
                if (isset($this->display)) {
                    return $value->property($this->display)->value()->content();
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
        return $value ?? '';
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_field');

        // Fields
        $builder->addStringField('formType', 100, 'form_type');
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
                'nullable' => true,
            ],
            [
                'column' => 'class',
                'nullable' => true,
            ],
            [
                'column' => 'attribute',
                'nullable' => true,
            ],
        ]);
    }

    protected function valueOptions(iterable $state) : iterable
    {
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = ($this->formOptions ? json_decode($this->formOptions, true) : []);
        }
        $options = $this->baseOptions($state, $this->formOptionsArray);
        // TODO Nicer way to set js date pickers?
        if ($state['value']['modus'] === 'active' && isset($options['widget']) && $options['widget'] === 'picker') {
            $options['widget'] = 'single_text';
            $options['html5'] = false;
            $picker = $this->attribute()->dataclass()->datatype()->id().'picker';
            if (isset($options['attr']['class'])) {
                $options['attr']['class'] = $options['attr']['class'].' '.$picker;
            } else {
                $options['attr']['class'] = $picker;
            }
        } else {
            unset($options['widget']);
        }
        if ($state['choices'] && $state['value']['modus'] !== 'static' && $this->attribute()->isItem()) {
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
                        $options['placeholder'] = 'dime.placeholder';
                    }
                }
            }
            if ($state['modus'] === 'readonly') {
                $options['attr']['class'] = $this->concatOption($options, 'attr', 'class', 'readonly-select');
            }
        }
        if ($this->attribute()->hasVocabulary()) {
            $options = $this->vocabularyOptions($this->attribute()->vocabulary(), $options);
            if ($this->attribute()->isRequired() || !$state['placeholder']) {
                $options['placeholder'] = 'dime.placeholder';
            }
        }
        if ($this->attribute()->hasMultipleOccurrences()) {
            $options['compound'] = true;
        }
        //$options['constraints'] = $this->attribute()->constraints();
        return $options;
    }

    protected function baseOptions(iterable $state, iterable $options = []) : iterable
    {
        $options['mapped'] = false;
        $options['label'] = false;
        $options['compound'] = false;
        if ($state['modus'] === 'disabled') {
            $options['disabled'] = true;
        }
        if ($state['modus'] === 'readonly') {
            if ($this->attribute()->hasVocabulary()) {
                $options['attr']['class'] = $this->concatOption($options, 'attr', 'class', 'readonly-select');
            } else {
                $options['attr']['readonly'] = true;
            }
        }
        return $options;
    }

    protected function concatOption(iterable $options, string $option, string $attr, string $value) : string
    {
        if (isset($options[$option][$attr])) {
            return $options[$option][$attr].' '.$value;
        }
        return $value;
    }

    private function modeToModus(iterable $state, string $modus) : string
    {
        if ($modus === 'hidden') {
            return 'hidden';
        }
        $mode = $state['mode'];
        if ($mode === 'view' || $modus === 'static') {
            return 'static';
        }
        if ($mode === 'edit') {
            if ($modus === 'readonly') {
                return 'readonly';
            }
            if ($modus === 'active' || $state['sanitise'] === 'redact') {
                return 'active';
            }
            if ($modus === 'disabled') {
                return 'disabled';
            }
            return 'readonly';
        }
        return 'static';
    }

    private function modusToFormType(string $modus, ?string $active, string $readonly = null, string $static = null) : ?string
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
}
