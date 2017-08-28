<?php

/**
 * ARK Model Number Dataclass Trait.
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

namespace ARK\Model\Dataclass;

use ARK\ORM\ClassMetadataBuilder;
use Symfony\Component\Validator\Constraints\NotEqualTo;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

trait NumberTrait
{
    protected $minimum;
    protected $exclusiveMinimum = false;
    protected $maximum;
    protected $exclusiveMaximum = false;
    protected $multipleOf;

    public function exclusiveMinimum() : bool
    {
        return $this->exclusiveMinimum;
    }

    public function exclusiveMaximum() : bool
    {
        return $this->exclusiveMaximum;
    }

    public function constraints() : iterable
    {
        $constraints = parent::constraints();
        $constraints[] = new Type('numeric');
        if ($this->minimum !== null || $this->maximum !== null) {
            $constraints[] = new Range(['min' => $this->minimum, 'max' => $this->maximum]);
        }
        if ($this->minimum !== null && $this->exclusiveMinimum === true) {
            $constraints[] = new NotEqualTo(['value' => $this->minimum]);
        }
        if ($this->maximum !== null && $this->exclusiveMaximum === true) {
            $constraints[] = new NotEqualTo(['value' => $this->maximum]);
        }
        return $constraints;
    }

    public static function buildNumberMetadata(ClassMetadataBuilder $builder) : void
    {
        $builder->addField('exclusiveMinimum', 'boolean', [], 'exclusive_minimum');
        $builder->addField('exclusiveMaximum', 'boolean', [], 'exclusive_maximum');
    }
}
