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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\View;

use ARK\EnabledTrait;
use ARK\KeywordTrait;
use ARK\Model\Item\Item;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\FormBuilder;

abstract class Element
{
    use EnabledTrait;
    use KeywordTrait;

    protected $type = '';
    protected $isGroup = false;
    protected $resource = null;
    protected $template = '';

    public function __construct()
    {
        $this->elements = new Collection();
    }

    public function type()
    {
        return $this->type;
    }

    public function template()
    {
        return $this->template;
    }

    public function isGroup()
    {
        return $this->isGroup;
    }

    public function isEditable()
    {
        return $this->editable;
    }

    public function isHidden()
    {
        return $this->hidden;
    }

    public function formData()
    {
        return [];
    }

    public function buildForm(FormBuilder $formBuilder, array $options = [])
    {
        return;
    }

    public function allFields()
    {
        return [];
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_element');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('element', 30);

        // Fields
        $builder->addManyToOneField('type', 'Type', 'type', 'type', false);
        $builder->addManyToOneField('schma', 'Schema', 'schma', 'schma');
        $builder->addStringField('subtype', 30);
        $builder->addStringField('property', 30);
        $builder->addStringField('class', 100);
        $builder->addStringField('template', 100);
        $builder->addStringField('form', 100);
        $builder->addField('editable', 'boolean');
        $builder->addField('hidden', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Relationships
        $builder->addOneToMany('children', 'Element', 'element');

        // Inheritance
        $builder->setSingleTableInheritance()->setDiscriminatorColumn('type', 'string', 10);
        $builder->addDiscriminatorMapClass('field', 'Field');
        $builder->addDiscriminatorMapClass('grid', 'Grid');
        $builder->addDiscriminatorMapClass('tabbed', 'Tabbed');
        $builder->addDiscriminatorMapClass('table', 'Table');
        $builder->addDiscriminatorMapClass('subform', 'Subform');
    }
}
