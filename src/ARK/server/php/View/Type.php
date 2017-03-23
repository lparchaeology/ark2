<?php

/**
 * ARK View Element Type
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

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Symfony\Component\Form\FormBuilder;

class Type
{
    use KeywordTrait;

    protected $type = '';
    protected $layout = false;
    protected $formTypeClass = '';
    protected $template = '';

    public function id()
    {
        return $this->type;
    }

    public function isLayout()
    {
        return $this->layout;
    }

    public function formTypeClass()
    {
        return $this->formTypeClass;
    }

    public function template()
    {
        return $this->template;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_type');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('type', 30);

        // Attributes
        $builder->addField('layout', 'boolean');
        $builder->addStringField('formTypeClass', 100, 'form_type_class');
        $builder->addStringField('template', 100);
        KeywordTrait::buildKeywordMetadata($builder);
    }
}
