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

use ARK\ORM\ORM;
use ARK\Model\Item;
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use ARK\Vocabulary\Vocabulary;
use ARK\Form\Type\PropertyType;
use ARK\Entity\Actor;
use Symfony\Component\Form\FormBuilderInterface;

class Field extends Element
{
    protected $formType = '';
    protected $formOptions = '';
    protected $formOptionsArray = null;
    protected $editable = true;
    protected $attribute = null;

    public function hasAttribute()
    {
        return $this->attribute !== null;
    }

    public function attribute()
    {
        return $this->attribute;
    }

    public function isEditable()
    {
        return $this->editable;
    }

    public function formType()
    {
        if ($this->formType) {
            return $this->formType;
        }
        return parent::formType();
    }

    public function formOptions($data)
    {
        if ($this->formOptionsArray === null) {
            if ($this->formOptions) {
                $this->formOptionsArray = array_merge($this->formDefaults($data), json_decode($this->formOptions, true));
            } else {
                $this->formOptionsArray = $this->formDefaults($data);
            }
        }
        return $this->formOptionsArray;
    }

    public function keyword()
    {
        if ($this->keyword) {
            return $this->keyword;
        }
        if ($this->attribute) {
            return $this->attribute->keyword();
        }
        return '';
    }

    public function formDefaults($data)
    {
        // FIXME HACK Need to find a better way to build custom fields!
        if ($this->name() == 'dime_find_actions') {
            $actor = ORM::find(Actor::class, 'ahavfrue');
            $options['actions'] = Service::workflow()->actions($actor, $data);
            $options['required'] = false;
        }
        if ($this->name() == 'dime_find_filter_kommune') {
            $options['vocabulary'] = ORM::find(Vocabulary::class, 'dime.denmark.kommune');
            $options['required'] = false;
        }
        if ($this->name() == 'dime_find_filter_type') {
            $options['vocabulary'] = ORM::find(Vocabulary::class, 'dime.find.type');
            $options['required'] = false;
        }
        if ($this->name() == 'dime_find_filter_material') {
            $options['vocabulary'] = ORM::find(Vocabulary::class, 'dime.material');
            $options['required'] = false;
        }
        if ($this->name() == 'dime_find_filter_period') {
            $options['vocabulary'] = ORM::find(Vocabulary::class, 'dime.period');
            $options['required'] = false;
        }
        $options['label'] = ($this->keyword() ? $this->keyword() : false);
        if ($this->attribute()) {
            $name = $this->attribute()->name();
            if ($this->formType || $this->formType() == PropertyType::class) {
                $options['field'] = $this;
            }
            $options['mapped'] = false;
            $options['required'] = $this->attribute()->isRequired();
            //$options['property_path'] = "propertyArray[$name].value";
            if (!Service::isGranted('IS_AUTHENTICATED_REMEMBERED') || $this->name() == 'dime_find_id') {
                $options['attr']['readonly'] = true;
                if ($this->attribute()->vocabulary()) {
                    $options['disabled'] = true;
                }
            }
        }
        return $options;
    }

    public function formData($data)
    {
        if ($data instanceof Item && $this->hasAttribute()) {
            return $data->property($this->attribute->name());
        }
        if (is_array($data) && isset($data[$this->name()])) {
            return $data[$this->name()];
        }
        return null;
    }

    public function buildForm($data, FormBuilderInterface $builder)
    {
        $fieldBuilder = $this->formBuilder($data);
        $builder->add($fieldBuilder);
    }

    public function renderView($data, $forms = null, $form = null, Cell $cell = null, array $options = [])
    {
        $attributeName = ($this->attribute() ? $this->attribute()->name() : '');
        if (($attributeName == 'findpoint' || $this->element == 'dime_save') && !Service::isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            if ($form) {
                $form[$this->element]->setRendered();
            }
            return '';
        }
        if ($form && $this->template()) {
            $options['field'] = $this;
            $options['data'] = $this->formData($data[$form->vars['id']]);
            $options['forms'] = $forms;
            $options['form'] = $form;
            $options['cell'] = $cell;
            $options['formLabel'] = $cell->formLabel();
            return Service::renderView($this->template(), $options);
        }

        // FIXME Should probably have some way to use FormTypes here to render 'flat' compond values
        $value = null;
        if ($data instanceof Item and $this->attribute()) {
            $value = 'FIXME: '.$this->element;
            $value = $data->property($this->attribute()->name())->value();
            if ($this->attribute()->format()->id() == 'shorttext') {
                $language = Service::locale();
                $values = $data->property($this->attribute->name())->value();
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
                $vocab = $this->attribute()->vocabulary();
                foreach ($vocab->terms() as $term) {
                    if ($term->name() == $value) {
                        return Service::translate($term->keyword());
                    }
                }
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
        $builder->addStringField('formType', 100, 'form_type');
        $builder->addStringField('formOptions', 4000, 'form_options');
        $builder->addField('editable', 'boolean');

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
