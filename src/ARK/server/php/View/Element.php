<?php

/**
 * ARK View Element
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

use ARK\Model\EnabledTrait;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ClassMetadata;
use ARK\Service;
use ARK\View\Type;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class Element
{
    use EnabledTrait;
    use KeywordTrait;

    protected $element = '';
    protected $type = '';
    protected $itemType = '';
    protected $attribute = null;
    protected $class = '';
    protected $template = '';
    protected $form = false;
    protected $formRoot = false;
    protected $formType = '';
    protected $editable = true;
    protected $hidden = false;
    protected $schma = null;
    protected $children = null;
    protected $options = null;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->options = new ArrayCollection();
    }

    public function name()
    {
        return $this->element;
    }

    public function type()
    {
        return $this->type;
    }

    public function schema()
    {
        return $this->schma;
    }

    public function className()
    {
        return $this->class;
    }

    public function template()
    {
        if ($this->template) {
            return $this->template;
        }
        return $this->type->template();
    }

    public function formRoot()
    {
        return $this->formRoot;
    }

    public function formType()
    {
        if ($this->formType) {
            return $this->formType;
        }
        return $this->type->formType();
    }

    public function formOptions()
    {
        $options['label'] = false;
        return $options;
    }

    public function formData($resource)
    {
        return $resource;
    }

    public function isEditable()
    {
        return $this->editable;
    }

    public function isHidden()
    {
        return $this->hidden;
    }

    public function options()
    {
        return $this->options;
    }

    public function optionsArray()
    {
        $opts = [];
        foreach ($this->options as $option) {
            $opts[$option->name()] = $option->value();
        }
        return $opts;
    }

    public function buildForms($data)
    {
        if ($this->formRoot) {
            $builder = $this->formBuilder($data);
            $this->buildForm($data[$this->element], $builder);
            return [$this->element => $builder->getForm()];
        }
        $forms = [];
        if ($this->type->isLayout()) {
            foreach ($this->elements() as $element) {
                $forms = array_merge($forms, $element->buildForms($data));
            }
        }
        return $forms;
    }

    public function buildForm($data, FormBuilderInterface $builder)
    {
        if ($this->type->isLayout()) {
            foreach ($this->elements() as $element) {
                $element->buildForm($data, $builder);
            }
            return;
        }
    }

    protected function formBuilder($data)
    {
        return Service::forms()->createNamedBuilder($this->name(),
                                                    $this->formType(),
                                                    $this->formData($data),
                                                    $this->formOptions());
    }

    abstract public function renderView($resource, $forms = null, $form = null, array $options = []);

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_element');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('element', 30);

        // Fields
        $builder->addManyToOneField('type', Type::class, 'type', 'type', false);
        $builder->addManyToOneField('schma', 'ARK\Model\Schema');
        $builder->addStringField('itemType', 30, 'item_type');
        $builder->addStringField('class', 100);
        $builder->addStringField('template', 100);
        $builder->addField('form', 'boolean');
        $builder->addField('formRoot', 'boolean', [], 'form_root');
        $builder->addStringField('formType', 100, 'form_type');
        $builder->addField('editable', 'boolean');
        $builder->addField('hidden', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addOneToMany('children', 'ARK\View\Child', 'parent');
        $builder->addOneToMany('options', 'ARK\View\Option', 'element');
        $builder->addCompoundManyToOneField(
            'attribute',
            'ARK\Model\Schema\SchemaAttribute',
            [
                ['column' => 'schma', 'nullable' => false],
                ['column' => 'item_type', 'reference' => 'type', 'nullable' => false],
                ['column' => 'attribute', 'nullable' => false]
            ]
        );

        // Inheritance
        $builder->setSingleTableInheritance()->setDiscriminatorColumn('type', 'string', 10);
        $builder->addDiscriminatorMapClass('field', 'ARK\View\Field');
        $builder->addDiscriminatorMapClass('grid', 'ARK\View\Grid');
        $builder->addDiscriminatorMapClass('tabbed', 'ARK\View\Tabbed');
        $builder->addDiscriminatorMapClass('table', 'ARK\View\Table');
    }
}
