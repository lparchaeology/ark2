<?php

/**
 * ARK Model String Datatype.
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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class StringDatatype extends Datatype
{
    protected $pattern = '';
    protected $minimumLength = 0;
    protected $maximumLength = 0;
    protected $defaultSize = 0;

    public function pattern() : string
    {
        return $this->pattern;
    }

    public function minimumLength() : int
    {
        return $this->minimumLength;
    }

    public function maximumLength() : int
    {
        return $this->maximumLength;
    }

    public function defaultSize() : int
    {
        return $this->defaultSize;
    }

    public function constraints() : iterable
    {
        $constraints = parent::constraints();
        $constraints[] = new Type('string');
        if ($this->pattern) {
            // TODO Multiple items doesn't like???
            //$constraints[] = new Regex(['pattern' => $this->pattern]);
        }
        if ($this->entity === null) {
            $constraints[] = new Length(['min' => $this->minimumLength, 'max' => $this->maximumLength]);
        }
        return $constraints;
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_datatype_string');

        // Attributes
        $builder->addStringField('pattern', 100);
        $builder->addField('minimumLength', 'integer', [], 'min_length');
        $builder->addField('maximumLength', 'integer', [], 'max_length');
        $builder->addField('defaultSize', 'integer', [], 'default_size');
        $builder->addStringField('preset', 4000);
    }
}
