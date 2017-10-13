<?php

/**
 * ARK Model Float Dataclass.
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

namespace ARK\Model\Dataclass;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class FloatDataclass extends Dataclass
{
    use NumberTrait;

    public function minimumValue() : float
    {
        return $this->minimum;
    }

    public function maximumValue() : float
    {
        return $this->maximum;
    }

    public function multipleOf() : float
    {
        return $this->multipleOf;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_dataclass_float');
        $builder->addField('minimum', 'float');
        $builder->addField('maximum', 'float');
        $builder->addMappedField('multiple_of', 'multipleOf', 'float');
        $builder->addField('preset', 'float');
        NumberTrait::buildNumberMetadata($builder);
    }
}
