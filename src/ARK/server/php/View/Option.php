<?php

/**
 * ARK View Option
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

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\View\Element;

class Option
{
    protected $element = null;
    protected $name = '';
    protected $type = '';
    protected $value = '';
    protected $rawValue = null;

    public function __construct(Element $element, $name, $value)
    {
        $this->element = $element;
        $this->name = $name;
        $this->type = gettype($value);
        $this->rawValue = $value;
        $this->value = serialize($value);
    }

    public function element()
    {
        return $this->element;
    }

    public function name()
    {
        return $this->name;
    }

    public function type()
    {
        return $this->type;
    }

    public function value()
    {
        if (!$this->rawValue) {
            $this->rawValue = unserialize($this->value);
        }
        return $this->rawValue;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_view_option');
        $builder->setReadOnly();

        // Key
        $builder->addManyToOneKey('element', 'ARK\View\Element');
        $builder->addStringKey('name', 30);

        // Fields
        $builder->addStringField('type', 30);
        $builder->addStringField('value', 4000);
    }
}
