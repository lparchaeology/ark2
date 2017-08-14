<?php

/**
 * ARK Model Decimal Datatype.
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

namespace ARK\Model\Datatype;

use ARK\Model\Datatype;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;

class DecimalDatatype extends Datatype
{
    use NumberTrait;

    protected $precision = 200;
    protected $scale = 0;

    public function minimumValue() : string
    {
        return $this->minimum;
    }

    public function maximumValue() : string
    {
        return $this->maximum;
    }

    public function multipleOf() : string
    {
        return $this->multipleOf;
    }

    public function precision() : int
    {
        return $this->precision;
    }

    public function scale() : int
    {
        return $this->scale;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_datatype_decimal');
        $builder->addField('precision', 'integer', [], 'prec');
        $builder->addField('scale', 'integer');
        $builder->addStringField('minimum', 200);
        $builder->addStringField('maximum', 200);
        $builder->addStringField('multipleOf', 200, 'multiple_of');
        $builder->addStringField('preset', 200);
        NumberTrait::buildNumberMetadata($builder);
    }
}
