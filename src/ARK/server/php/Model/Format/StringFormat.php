<?php

/**
 * ARK Model String Format
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

namespace ARK\Model\Format;

use ARK\Model\Format;
use ARK\Model\Format\StringFormat;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class StringFormat extends Format
{
    protected $pattern = '';
    protected $minimumLength = 0;
    protected $maximumLength = 0;
    protected $defaultSize = 0;

    public function pattern()
    {
        return $this->pattern;
    }

    public function minimumLength()
    {
        return $this->minimumLength;
    }

    public function maximumLength()
    {
        return $this->maximumLength;
    }

    public function defaultSize()
    {
        return $this->defaultSize;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_format_string');

        // Attributes
        $builder->addStringField('pattern', 100);
        $builder->addField('minimumLength', 'integer', [], 'min_length');
        $builder->addField('maximumLength', 'integer', [], 'max_length');
        $builder->addField('defaultSize', 'integer', [], 'default_size');
        $builder->addStringField('preset', 4000);
    }
}
