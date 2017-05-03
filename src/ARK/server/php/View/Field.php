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
use ARK\Vocabulary\Vocabulary;
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

    public function valueMode()
    {
        if (!Service::isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return 'static';
        }
        return $this->value;
    }

    public function parameterMode()
    {
        if (!$this->attribute()->format()->parameterName()) {
            return null;
        }
        return ($this->parameter ?: 'hidden');
    }

    public function formatMode()
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

    private function modeToType($mode, $default = null)
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
        return $this->modeToType($this->value, $this->attribute()->format()->valueFormType());
    }

    public function parameterFormType()
    {
        return $this->modeToType($this->parameter, $this->attribute()->format()->parameterFormType());
    }

    public function formatFormType()
    {
        return $this->modeToType($this->format, $this->attribute()->format()->formatFormType());
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
        if ($options['mode'] == 'view') {
            $options['required'] = false;
        } elseif ($options['required'] === null) {
            $options['required'] = $this->attribute()->isRequired();
        }
        if (!Service::isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $options['attr']['readonly'] = true;
        }
        $options['field']['object'] = $this;
        $options['field']['value'] = $this->valueOptions($cellOptions['value']);
        $options['field']['parameter'] = $this->parameterOptions($cellOptions['parameter']);
        $options['field']['format'] = $this->formatOptions($cellOptions['format']);
        return $options;
    }

    protected function valueOptions($cellOptions)
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
        return $this->baseOptions($cellOptions, $options, $this->valueMode(), $this->valueFormType());
    }

    protected function parameterOptions($cellOptions)
    {
        return $this->baseOptions($cellOptions, [], $this->parameterMode(), $this->parameterFormType());
    }

    protected function formatOptions($cellOptions)
    {
        return $this->baseOptions($cellOptions, [], $this->formatMode(), $this->formatFormType());
    }

    protected function baseOptions($cellOptions, $subOptions, $fieldMode, $formType)
    {
        if (!$fieldMode) {
            return null;
        }
        $base['mode'] = ($cellOptions['mode'] ?: $fieldMode);
        $base['type'] = $this->modeToType($base['mode'], $formType);
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
        // TODO Do this properly
        if ($this->formName() == 'location' && !Service::isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return;
        }
        //if (!Service::security()->hasVisibility($actor, $this->attribute())) {
        //    return;
        //}
        $options = $this->formOptions($data, $options);
        $fieldBuilder = $this->formBuilder($data, $options);
        $builder->add($fieldBuilder);
    }

    public function renderView($data, $forms = null, $form = null, array $options = [])
    {
        // TODO Do this properly
        if ($this->formName() == 'location' && !Service::isGranted('IS_AUTHENTICATED_REMEMBERED')) {
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
        if ($data instanceof Item) {
            $item = $data;
        } elseif (is_array($data) && isset($data['data'])) {
            $item = $data['data'];
        }

        if ($item) {
            $value = 'FIXME: '.$this->element;
            $value = $item->property($this->attribute()->name())->value();
            if ($this->attribute()->format()->datatype()->id() == 'text') {
                $language = Service::locale();
                $values = $item->property($this->attribute->name())->value();
                foreach ($values as $trans) {
                    if ($trans['language'] == $language) {
                        return $trans['content'];
                    }
                }
                return $values[0]['content'];
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
