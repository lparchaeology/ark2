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
use ARK\Model\Schema\SchemaAttribute;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Type;
use ARK\View\Cell;
use ARK\Vocabulary\Vocabulary;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class Element
{
    use EnabledTrait;
    use KeywordTrait;

    protected $element = '';
    protected $name = '';
    protected $type = '';
    protected $template = '';
    protected $mode = null;

    public function __construct($element, $type, $class = '', $template = '')
    {
        $this->element = $element;
        $this->type = (is_string($type) ? ORM::find(Type::class, $type) : $type);
        $this->class = $class;
        $this->template = $template;
    }

    public function id()
    {
        return $this->element;
    }

    public function formName($cellName = null)
    {
        if ($cellName) {
            return $cellName;
        }
        if ($this->name) {
            return $this->name;
        }
        return $this->element;
    }

    public function type()
    {
        return $this->type;
    }

    public function template()
    {
        if ($this->template) {
            return $this->template;
        }
        return $this->type->template();
    }

    public function defaultMode()
    {
        return $this->mode;
    }

    public function displayMode($parentMode)
    {
        if ($this->defaultMode() !== null && $parentMode == 'edit') {
            return $this->defaultMode();
        }
        return $parentMode;
    }

    public function formData($mode, $data, $options)
    {
        $cellName = $options['cell']['name'];
        if ($cellName && is_array($data) && array_key_exists($cellName, $data)) {
            return $data[$cellName];
        }
        if ($this->name) {
            if (is_array($data) && array_key_exists($this->name, $data)) {
                return $data[$this->name];
            }
            return null;
        }
        $name = $this->formName($cellName);
        return (is_array($data) && array_key_exists($name, $data) ? $data[$name] : $data);
    }

    public function formTypeClass()
    {
        return $this->type->formTypeClass();
    }

    public function defaultOptions($route = null)
    {
        $options['cell']['name'] = null;
        return $options;
    }

    public function buildOptions($mode, $data, $options)
    {
        return array_merge($this->defaultOptions(), $options);
    }

    public function defaultContext($route = null)
    {
        $context['data'] = null;
        $context['forms'] = null;
        $context['sanitise'] = null;
        $context['cell']['name'] = null;
        return $context;
    }

    public function viewContext($mode, $data, $context = [])
    {
        $context = array_merge($this->defaultContext(), $context);
        $context['mode'] = $mode;
        $context['data'] = $data;
        return $context;
    }

    protected function vocabularyOptions(Vocabulary $vocabulary, $options = [])
    {
        $options['choices'] = $vocabulary->terms();
        $options['choice_value'] = 'name';
        $options['choice_name'] = 'name';
        $options['choice_label'] = 'keyword';
        $options['placeholder'] = $vocabulary->keyword();
        return $options;
    }

    public function buildForm(FormBuilderInterface $builder, $mode, $data, $dayaKey, $options = [])
    {
    }

    public function buildForms($mode, $data, $options)
    {
        return [];
    }

    protected function formBuilder($mode, $data, $options, $cellName = null)
    {
        if ($cellName === null && isset($options['cell']['name'])) {
            $cellName = $options['cell']['name'];
        }
        $formName = ($cellName === false ? $formName = null : $this->formName($cellName));
        return Service::forms()->createNamedBuilder(
            $formName,
            $this->formTypeClass(),
            $data,
            $options
        );
    }

    abstract public function renderView($mode, $data, array $options = [], $forms = null, $form = null);

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_element');
        $builder->setReadOnly();
        $builder->setJoinedTableInheritance()->setDiscriminatorColumn('type', 'string', 10);
        $viewTypes = Service::database()->getViewTypes();
        foreach ($viewTypes as $type) {
            $metadata->addDiscriminatorMapClass($type['type'], $type['class']);
        }

        // Key
        $builder->addStringKey('element', 30);

        // Fields
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToOneField('type', Type::class, 'type', 'type', false);
    }
}
