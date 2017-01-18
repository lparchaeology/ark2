<?php

/**
 * ARK View Child
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

use ARK\EnabledTrait;
use ARK\Model\Item\Item;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Symfony\Component\Form\FormBuilder;

class Child
{
    use EnabledTrait;

    protected $parent = null;
    protected $row = 0;
    protected $col = 0;
    protected $seq = 0;
    protected $subtype = null;
    protected $child = null;

    public function parent()
    {
        return $this->parent;
    }

    public function row()
    {
        return $this->row;
    }

    public function col()
    {
        return $this->col;
    }

    public function seq()
    {
        return $this->seq;
    }

    public function subtype()
    {
        return $this->subtype;
    }

    public function element()
    {
        return $this->child;
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
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_group');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('parent', 'Element', 'element', 'element');
        $builder->addKey('row', 'integer');
        $builder->addKey('col', 'integer');
        $builder->addKey('seq', 'integer');
        $builder->addStringKey('subtype', 30);

        // Fields
        EnabledTrait::buildEnabledMetadata($builder);

        // Relationships
        $builder->addManyToOneField('child', 'Element', 'child', 'element', false);
    }
}
