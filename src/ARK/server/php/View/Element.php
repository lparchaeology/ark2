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
use ARK\Service;
use ARK\View\Type;
use ARK\View\Cell;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class Element
{
    use EnabledTrait;
    use KeywordTrait;

    protected $element = '';
    protected $type = '';
    protected $class = '';
    protected $template = '';
    protected $hidden = false;

    public function __construct()
    {
        $this->cells = new ArrayCollection();
    }

    public function name()
    {
        return $this->element;
    }

    public function type()
    {
        return $this->type;
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

    public function isHidden()
    {
        return $this->hidden;
    }

    public function formData($resource)
    {
        return $resource;
    }

    public function formDefaults($data)
    {
        $options['label'] = false;
        return $options;
    }

    public function formTypeClass()
    {
        return $this->type->formTypeClass();
    }

    public function formOptions($data)
    {
        return $this->formDefaults($data);
    }

    public function buildForm($data, FormBuilderInterface $builder)
    {
    }

    public function buildForms($data)
    {
        return [];
    }

    protected function formBuilder($data)
    {
        return Service::forms()->createNamedBuilder($this->name(),
                                                    $this->formTypeClass(),
                                                    $this->formData($data),
                                                    $this->formOptions($data));
    }

    abstract public function renderView($data, $forms = null, $form = null, Cell $cell = null, array $options = []);

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
        $builder->addStringField('class', 100);
        $builder->addStringField('template', 100);
        $builder->addField('hidden', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addManyToOneField('type', Type::class, 'type', 'type', false);
    }
}
