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
use ARK\Model\KeywordTrait;
use ARK\Model\Property;
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Translation\Translation;
use IntlDateFormatter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormView;

class Field extends Element
{
    protected $attribute;
    protected $valueModus = 'excluded';
    protected $parameterModus;
    protected $formatModus;
    protected $displayProperty;
    protected $displayPattern;
    protected $displayParameter;
    protected $displayFormat;
    protected $exportProperty;
    protected $exportPattern;
    protected $exportParameter;
    protected $exportFormat;
    protected $formOptions = '';
    protected $formOptionsArray;

    public function attribute() : SchemaAttribute
    {
        return $this->attribute;
    }

    public function valueModus() : string
    {
        return $this->valueModus;
    }

    public function parameterModus() : ?string
    {
        if ($this->attribute()->dataclass()->hasParameter()) {
            return $this->parameterModus ?? 'hidden';
        }
        return null;
    }

    public function formatModus() : ?string
    {
        if ($this->attribute()->dataclass()->hasFormat()) {
            return $this->formatModus ?? 'hidden';
        }
        return null;
    }

    public function displayProperty() : ?string
    {
        return $this->displayProperty;
    }

    public function displayPattern() : ?string
    {
        return $this->displayPattern;
    }

    public function displayParameter() : ?string
    {
        return $this->displayParameter;
    }

    public function displayFormat() : ?string
    {
        return $this->displayFormat;
    }

    public function exportProperty() : ?string
    {
        return $this->exportProperty;
    }

    public function exportPattern() : ?string
    {
        return $this->exportPattern;
    }

    public function exportParameter() : ?string
    {
        return $this->exportParameter;
    }

    public function exportFormat() : ?string
    {
        return $this->exportFormat;
    }

    public function name() : string
    {
        return $this->attribute->name();
    }

    public function formType() : string
    {
        return $this->formType ?? $this->attribute()->dataclass()->formType() ?? parent::formType();
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

    public function renderValue(iterable $view, iterable $forms = [], FormView $form = null) : string
    {
        //dump('RENDER VALUE : '.get_class($this).' '.$this->id().' '.$this->keyword());
        //dump($view);
        //dump($form);
        if ($view['state']['mode'] === 'deny') {
            return '';
        }
        $view = $this->buildContext($view, $forms, $form);
        $form = $view['form']['display'] ?? $view['form']['static'] ?? null;
        $value = $form->vars['value'] ?? '';
        if (is_string($value)) {
            return Translation::translate($value);
        }
        if (is_array($value)) {
            $out = [];
            foreach ($value as $val) {
                $out[] = Translation::translate($val);
            }
            return implode(' ', $out);
        }
        return (string) $value;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Joined Table Inheritance
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_field');

        // Fields
        $builder->addMappedStringField('value_modus', 'valueModus', 10);
        $builder->addMappedStringField('parameter_modus', 'parameterModus', 10);
        $builder->addMappedStringField('format_modus', 'formatModus', 10);
        $builder->addMappedStringField('display_property', 'displayProperty', 30);
        $builder->addMappedStringField('display_pattern', 'displayPattern', 30);
        $builder->addMappedStringField('display_parameter', 'displayParameter', 30);
        $builder->addMappedStringField('display_format', 'displayFormat', 30);
        $builder->addMappedStringField('export_property', 'exportProperty', 30);
        $builder->addMappedStringField('export_pattern', 'exportPattern', 30);
        $builder->addMappedStringField('export_parameter', 'exportParameter', 30);
        $builder->addMappedStringField('export_format', 'exportFormat', 30);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addStringField('template', 100);
        $builder->addMappedStringField('form_type', 'formType', 100);
        $builder->addMappedStringField('form_options', 'formOptions', 4000);

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

    protected function buildState($data, iterable $state) : iterable
    {
        $state = parent::buildState($data, $state);
        $state['field'] = $this;

        // The Field state overrides the Cell state for the following
        $this->setValue($state, 'required', $this->attribute()->isRequired());
        $this->setValue($state, 'multiple', $this->attribute()->hasMultipleOccurrences());

        // The parent state (i.e. cell) overrides the field state for the following
        $this->inheritGroupValue($state, 'display', 'property', $this->displayProperty());
        $this->inheritGroupValue($state, 'display', 'pattern', $this->displayPattern());
        $this->inheritGroupValue($state, 'display', 'parameter', $this->displayParameter());
        $this->inheritGroupValue($state, 'display', 'format', $this->displayFormat());

        $this->inheritGroupValue($state, 'export', 'property', $this->exportProperty());
        $this->inheritGroupValue($state, 'export', 'pattern', $this->exportPattern());
        $this->inheritGroupValue($state, 'export', 'parameter', $this->exportParameter());
        $this->inheritGroupValue($state, 'export', 'format', $this->exportFormat());

        $this->inheritGroupValue($state, 'value', 'modus', $this->valueModus());
        $this->inheritGroupValue($state, 'parameter', 'modus', $this->parameterModus());
        $this->inheritGroupValue($state, 'format', 'modus', $this->formatModus());
        $this->inheritValue($state, 'keyword', $this->keyword());

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
        $state['modus'] = $this->modeToModus($state, ($state['modus'] ?? $state['value']['modus'] ?? $this->valueModus()));

        return $state;
    }

    protected function buildData($data, iterable $state)
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

    protected function buildOptions($data, iterable $state, iterable $options = []) : iterable
    {
        $options['state'] = $state;

        if ($state['label']) {
            $options['label'] = ($state['keyword'] ? $state['keyword'] : $this->keyword());
        } else {
            $options['label'] = false;
        }

        // If field is static or has a display option, then the value subform is hidden
        $valueModus = $this->modeToModus($state, $state['value']['modus']);
        if ($valueModus === 'static') {
            $options['state']['value']['modus'] = 'static';
            $options['state']['display']['name'] = 'static';
            $options['state']['display']['modus'] = 'static';
            if ($this->attribute()->hasMultipleOccurrences()) {
                $options['state']['display']['type'] = CollectionType::class;
                $options['state']['display']['options'] = $this->valueOptions($options['state']);
                $options['state']['display']['options']['entry_type'] = $this->staticFormType();
                $options['state']['display']['options']['entry_options']['label'] = false;
            } else {
                $options['state']['display']['type'] = $this->staticFormType();
                $options['state']['display']['options'] = $this->valueOptions($options['state']);
            }
            $options['state']['static']['name'] = '_static';
            $options['state']['static']['modus'] = 'hidden';
            if ($this->attribute()->hasMultipleOccurrences()) {
                $options['state']['static']['type'] = CollectionType::class;
                $options['state']['static']['options']['entry_type'] = HiddenType::class;
            } else {
                $options['state']['static']['type'] = HiddenType::class;
                $options['state']['static']['options'] = [];
            }
            $valueModus = 'hidden';
        } elseif ($options['state']['choices']) {
            if (isset($options['state']['display']['property'])) {
                $options['state']['display']['name'] = $options['state']['display']['property'];
            }
        } elseif (isset($options['state']['display']['property'])) {
            $options['state']['value']['modus'] = $valueModus;
            $options['state']['display']['name'] = $options['state']['display']['property'];
            $options['state']['display']['modus'] = $valueModus;
            $options['state']['display']['type'] = $this->modusToFormType(
                $valueModus,
                $options['state']['choices'],
                $this->activeFormType(),
                $this->readonlyFormType(),
                $this->staticFormType()
            );
            $options['state']['display']['options'] = $this->valueOptions($options['state']);
            $valueModus = 'hidden';
        }
        $options['state']['value']['name'] = $this->attribute()->dataclass()->valueName();
        $options['state']['value']['modus'] = $valueModus;
        $options['state']['value']['type'] = $this->modusToFormType(
            $valueModus,
            $options['state']['choices'],
            $this->activeFormType(),
            $this->readonlyFormType(),
            $this->staticFormType()
        );
        $options['state']['value']['options'] = $this->valueOptions($options['state']);
        if ($this->attribute()->hasMultipleOccurrences()
            && ($options['state']['value']['modus'] === 'static' || $options['state']['value']['modus'] === 'hidden')
            && $options['state']['value']['type'] = HiddenType::class
        ) {
            $options['state']['value']['type'] = CollectionType::class;
            $options['state']['value']['options']['entry_type'] = HiddenType::class;
        }

        if (isset($state['parameter']['modus'])) {
            $options['state']['parameter']['name'] = $this->attribute()->dataclass()->parameterName();
            $options['state']['parameter']['modus'] =
                $this->modeToModus($state, $options['state']['parameter']['modus']);
            $options['state']['parameter']['type'] =
                $this->modusToFormType($options['state']['parameter']['modus'], false, $this->parameterFormType());
            $options['state']['parameter']['options'] = $this->baseOptions($options['state']['parameter']);
        } else {
            $options['state']['parameter'] = null;
        }

        if (isset($state['format']['modus'])) {
            $options['state']['format']['name'] = $this->attribute()->dataclass()->formatName();
            $options['state']['format']['modus'] =
                $this->modeToModus($state, $options['state']['format']['modus']);
            $options['state']['format']['type'] =
                $this->modusToFormType($options['state']['format']['modus'], false, $this->formatFormType());
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
        if (!isset($options['state']['display']['modus'])) {
            unset($options['state']['display']);
        }
        return $options;
    }

    protected function valueOptions(iterable $state) : iterable
    {
        if ($state['value']['modus'] === 'static' || $state['value']['modus'] === 'hidden') {
            $options = $this->baseOptions($state, []);
            $options['compound'] = $this->attribute()->hasMultipleOccurrences();
            return $options;
        }
        if ($this->formOptionsArray === null) {
            $this->formOptionsArray = ($this->formOptions ? json_decode($this->formOptions, true) : []);
        }
        $options = $this->baseOptions($state, $this->formOptionsArray);
        $options['compound'] = $this->attribute()->hasMultipleOccurrences();
        // TODO Nicer way to set js date pickers?
        if ($state['value']['modus'] === 'active' && isset($options['widget']) && $options['widget'] === 'picker') {
            $options['widget'] = 'single_text';
            $options['html5'] = false;
            $type = $this->attribute()->dataclass()->datatype()->id();
            $pattern = $state['pattern'] ?? null;
            $moment = null;
            switch ($pattern) {
                case 'full':
                    $pattern = IntlDateFormatter::FULL;
                    if ($type === 'date') {
                        $moment = 'LL';
                    } elseif ($type === 'time') {
                        $moment = 'LT';
                    } else {
                        $moment = 'LLLL';
                    }
                    break;
                case 'long':
                    $pattern = IntlDateFormatter::LONG;
                    if ($type === 'date') {
                        $moment = 'LL';
                    } elseif ($type === 'time') {
                        $moment = 'LT';
                    } else {
                        $moment = 'LLL';
                    }
                    break;
                case 'medium':
                    $pattern = IntlDateFormatter::MEDIUM;
                    if ($type === 'date') {
                        $moment = 'LL';
                    } elseif ($type === 'time') {
                        $moment = 'LT';
                    } else {
                        $moment = 'LL LT';
                    }
                    break;
                case 'short':
                    $pattern = IntlDateFormatter::SHORT;
                    if ($type === 'date') {
                        $moment = 'L';
                    } elseif ($type === 'time') {
                        $moment = 'LT';
                    } else {
                        $moment = 'L LT';
                    }
                    break;
                case null:
                case '':
                    $pattern = null;
                    break;
                default:
                    $moment = $pattern;
                    break;
            }
            if ($pattern !== null) {
                if (is_numeric($pattern)) {
                    switch ($type) {
                        case 'date':
                            $options['format'] = $pattern;
                            //$intl = new IntlDateFormatter(Service::locale(), $pattern, IntlDateFormatter::NONE);
                            //$pattern = $intl->getPattern();
                            break;
                        case 'time':
                            //$intl = new IntlDateFormatter(Service::locale(), IntlDateFormatter::NONE, $pattern);
                            //$pattern = $intl->getPattern();
                            break;
                        case 'datetime':
                        default:
                            $intl = new IntlDateFormatter(Service::locale(), $pattern, $pattern);
                            $options['date_format'] = $pattern;
                            $pattern = $intl->getPattern();
                            $options['format'] = $pattern;
                            break;
                    }
                }
                $options['attr']['data-date-format'] = $moment;
            }
        } else {
            unset($options['widget']);
        }
        if ($state['choices']) {
            if ($this->attribute()->isItem()) {
                $select = $state['select'][$state['name']] ?? [];
                $choices = $select['choices'] ?? ORM::findAll($this->attribute()->entity());
                if ($choices) {
                    $options['choices'] = $choices;
                    if ($state['placeholder']) {
                        $options['placeholder'] = $select['placeholder'] ?? 'core.placeholder';
                    }
                    $options['choice_value'] = $select['choice_value'] ?? 'id';
                    $options['choice_name'] = $select['choice_name'] ?? 'id';
                    $options['choice_label'] = $select['choice_label'] ?? $state['display']['property'] ?? 'id';
                }
            } elseif ($this->attribute()->hasVocabulary()) {
                $options = $this->vocabularyOptions($this->attribute()->vocabulary(), $options);
                if ($this->attribute()->isRequired() || !$state['placeholder']) {
                    $options['placeholder'] = 'core.placeholder';
                }
            }
            if ($state['modus'] === 'readonly') {
                $options['attr']['class'] = $this->concatAttr($options, 'class', 'readonly-select');
                if ($this->attribute()->isRequired()) {
                    $options['attr']['class'] = $this->concatAttr($options, 'class', 'readonly-required');
                }
            }
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
                $options['attr']['class'] = $this->concatAttr($options, 'class', 'readonly-select');
            } else {
                $options['attr']['readonly'] = true;
            }
            if ($this->attribute()->isRequired()) {
                $options['attr']['class'] = $this->concatAttr($options, 'class', 'readonly-required');
            }
        }
        return $options;
    }

    protected function buildContext(iterable $view, iterable $forms = [], FormView $form = null) : iterable
    {
        $view = parent::buildContext($view, $forms, $form);
        $view['field'] = $this;
        if (!$view['form']) {
            $builder = $this->formBuilder($view['state']['name'], $view['state']['form']['type'], $view['data'], $view['options']);
            $view['form'] = $builder->getForm()->createView();
        }
        return $view;
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

    private function modusToFormType(string $modus, ?bool $choices, ?string $active, string $readonly = null, string $static = null) : ?string
    {
        switch ($modus) {
            case 'hidden':
                return HiddenType::class;
            case 'static':
                return $static ?: StaticType::class;
            case 'readonly':
                return $readonly ?? $active;
        }
        if ($choices) {
            return ChoiceType::class;
        }
        return $active;
    }
}
