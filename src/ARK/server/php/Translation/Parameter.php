<?php

/**
 * ARK Translation Parameter Entity.
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
 */

namespace ARK\Translation;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class Parameter
{
    protected $keyword;
    protected $parameter = '';

    public function __construct(Translation $keyword, string $name)
    {
        $this->keyword = $keyword;
        $this->parameter = $name;
    }

    public function name() : string
    {
        return $this->parameter;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_translation_parameter');
        $builder->addManyToOneKey('keyword', Translation::class);
        $builder->addStringKey('parameter', 30);
    }
}
