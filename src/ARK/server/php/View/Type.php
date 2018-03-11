<?php

/**
 * ARK View Element Type.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\View;

use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class Type
{
    use KeywordTrait;

    protected $type = '';
    protected $layout = false;
    protected $formType;
    protected $template;

    public function id() : string
    {
        return $this->type;
    }

    public function isLayout() : bool
    {
        return $this->layout;
    }

    public function formType() : ?string
    {
        return $this->formType;
    }

    public function template() : ?string
    {
        return $this->template;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_type');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('type', 30);

        // Attributes
        $builder->addField('layout', 'boolean');
        $builder->addMappedStringField('form_type', 'formType', 100);
        $builder->addStringField('template', 100);
        KeywordTrait::buildKeywordMetadata($builder);
    }
}
