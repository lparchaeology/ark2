<?php

/**
 * ARK Model Boolean Dataclass.
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

namespace ARK\Model\Dataclass;

use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Symfony\Component\Validator\Constraints\Type;

class BooleanDataclass extends Dataclass
{
    public function emptyValue()
    {
        if ($this->hasMultipleValues()) {
            return [];
        }
        if ($this->isAtomic()) {
            return $this->defaultValue();
        }
        $data = [];
        if ($this->hasFormat()) {
            $data[$this->formatName()] = null;
        }
        if ($this->hasParameter()) {
            $data[$this->parameterName()] = null;
        }
        $data[$this->valueName()] = $this->defaultValue();
        ksort($data);
        return $data;
    }

    public function constraints() : iterable
    {
        $constraints = parent::constraints();
        $constraints[] = new Type('bool');
        return $constraints;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_dataclass_boolean');
        $builder->addField('preset', 'boolean');
    }
}
