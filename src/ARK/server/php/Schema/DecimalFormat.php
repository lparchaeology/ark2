<?php

/**
 * ARK Schema Decimal Format
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

namespace ARK\Schema;

use ARK\Schema\Format;
use ARK\Schema\NumberTrait;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class DecimalFormat extends Format
{
    use NumberTrait;

    public $precision = 200;
    public $scale = 0;

    public function precision()
    {
        return $this->precision;
    }

    public function scale()
    {
        return $this->scale;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_format_decimal');
        $builder->addField('precision', 'integer', [], 'prec');
        $builder->addField('scale', 'integer');
        $builder->addStringField('minimum', 200);
        $builder->addStringField('maximum', 200);
        $builder->addStringField('multipleOf', 200, 'multiple_of');
        NumberTrait::buildNumberMetadata($builder);
    }
}
