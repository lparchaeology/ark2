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
use ARK\Form\Type\PropertyType;
use ARK\Form\Type\ActionChoiceType;
use ARK\Form\Type\VocabularyChoiceType;
use ARK\Model\Item;
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ORM;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use ARK\Vocabulary\Term;
use ARK\Vocabulary\Vocabulary;
use ARK\Workflow\Event;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

class Field extends Element
{
    protected $formTypeClass = '';
    protected $formOptions = '';
    protected $formOptionsArray = null;
    protected $label = true;
    protected $mode = null;
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

    public function defaultMode()
    {
        return $this->mode;
    }

    public function displayMode($options)
    {
        if ($this->mode !== null && $options['mode'] == 'edit') {
            return $this->mode;
        }
        return $options['mode'];
    }

    public function valueFormMode()
    {
        return $this->value;
    }

    public function parameterFormMode()
    {
        if (!$this->attribute()->format()->parameterName()) {
            return null;
        }
        return ($this->parameter ?: 'hidden');
    }

    public function formatFormMode()
    {
        if (!$this->attribute()->format()->formatName()) {
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

    private function modeToAppearance($mode, $appearance)
    {
        if ($appearance == 'excluded' || $appearance == 'hidden') {
            return $appearance;
        }
        if ($mode == 'view') {
            return 'static';
        }
        return $appearance;
    }

    private function appearanceToFormType($mode, $default = null)
    {
        switch ($mode) {
            case 'hidden':
                return HiddenType::class;
            case 'static':
                return StaticType::class;
        }
        return $default;
    }

    public function valueFormType()
    {
        return $this->appearanceToFormType($this->value, $this->attribute()->format()->valueFormType());
    }

    public function parameterFormType()
    {
        return $this->appearanceToFormType($this->parameter, $this->attribute()->format()->parameterFormType());
    }

    public function formatFormType()
    {
        return $this->appearanceToFormType($this->format, $this->attribute()->format()->formatFormType());
    }

    public function keyword()
    {
        return ($this->keyword ?: $this->attribute->keyword());
    }

    public function formOptions($data, $options)
    {
        $cellOptions = $options['cell'];
        unset($options['cell']);
        if ($options['label'] === null) {
            $options['label'] = ($this->keyword() ?: false);
        }
        $options['mode'] = $this->displayMode($cellOptions);
        if ($options['mode'] == 'view') {
            $options['required'] = false;
        } elseif ($options['required'] === null) {
            $options['required'] = $this->attribute()->isRequired();
        }
        $options['field']['object'] = $this;
        $options['field']['value'] = $this->valueOptions($options['mode'], $cellOptions['value']);
        $options['field']['parameter'] = $this->baseOptions(
            $options['mode'],
            $cellOptions['parameter'],
            [],
            $this->parameterFormMode(),
            $this->parameterFormType()
        );
        $options['field']['format'] = $this->baseOptions(
            $options['mode'],
            $cellOptions['format'],
            [],
            $this->formatFormMode(),
            $this->formatFormType()
        );
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
            $options = $this->vocabularyOptions($this->attribute()->vocabulary(), $options);
        }
        if ($this->attribute()->hasMultipleOccurrences()) {
            $options['multiple'] = true;
        }
        if (!Service::isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            if ($this->attribute()->hasVocabulary()) {
                $options['disabled'] = true;
            }
        }
        return $this->baseOptions($mode, $cellOptions, $options, $this->valueFormMode(), $this->valueFormType());
    }

    protected function baseOptions($mode, $cellOptions, $subOptions, $appearance, $formType)
    {
        if (!$appearance) {
            return null;
        }
        $base['mode'] = $this->modeToAppearance($mode, ($cellOptions['mode'] ?: $appearance));
        $base['type'] = $this->appearanceToFormType($base['mode'], $formType);
        $base['options'] = $subOptions;
        $base['options']['mapped'] = false;
        $base['options']['label'] = false;
        if ($base['mode'] == 'disabled') {
            $base['options']['disabled'] = true;
        }
        if ($base['mode'] == 'readonly') {
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
            return $options[$option][$attr].' '.$value;
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

    public function formData($data)
    {
        if ($data instanceof Item) {
            return $data->property($this->attribute->name());
        }
        if (is_array($data) && isset($data[$this->name()])) {
            return $data[$this->name()];
        }
        return null;
    }

    public function buildForm(FormBuilderInterface $builder, $data, $options = [])
    {
        //if (!Service::security()->hasVisibility($actor, $this->attribute())) {
        //    return;
        //}
        if (!Service::workflow()->hasPermission($this->attribute->readPermission())) {
            return;
        }
        $options = $this->formOptions($data, $options);
        $fieldBuilder = $this->formBuilder($data, $options);
        $builder->add($fieldBuilder);
    }

    public function renderView($data, $forms = null, $form = null, array $options = [])
    {
        if (!Service::workflow()->hasPermission($this->attribute->readPermission())) {
            return;
        }
        if ($form && $this->template()) {
            $options['field'] = $this;
            $options['data'] = $this->formData($data[$form->vars['id']]);
            $options['forms'] = $forms;
            $options['form'] = $form;
            return Service::renderView($this->template(), $options);
        }

        // FIXME Should probably have some way to use FormTypes here to render 'flat' compond values
        $value = null;
        $item = null;
        $options = $this->valueOptions('view', ['mode' => 'view']);
        if ($data instanceof Item) {
            $item = $data;
        } elseif (is_array($data) && isset($data['data'])) {
            $item = $data['data'];
        }

        if ($item instanceof Item) {
            $value = 'FIXME: '.$this->element;
            $value = $item->property($this->attribute()->name())->value();
            if ($value === null) {
                return null;
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
                if (isset($options['options']['display_property'])) {
                    return $value->property($options['options']['display_property'])->value()->content();
                }
                return $value->property('id')->serialize();
            }
            if ($value instanceof Term) {
                return Service::translate($value->keyword());
            }
            if ($this->attribute()->format()->datatype()->id() == 'text') {
                return $item->property($this->attribute->name())->value()->content();
            }
            if (is_array($value)) {
                $value = $value[$this->attribute()->format()->valueName()];
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
        $builder->addStringField('value', 10);
        $builder->addStringField('parameter', 10);
        $builder->addStringField('format', 10);

        // Associations
        $builder->addCompositeManyToOneField(
            'attribute',
            'ARK\Model\Schema\SchemaAttribute',
            [
                ['column' => 'schma', 'nullable' => true],
                ['column' => 'item_type', 'reference' => 'type', 'nullable' => true],
                ['column' => 'attribute', 'nullable' => true],
            ]
        );
    }
}
