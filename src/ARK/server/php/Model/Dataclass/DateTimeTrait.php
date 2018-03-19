<?php

/**
 * ARK Model DateTime Dataclass Trait.
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

use ARK\Model\Fragment\Fragment;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Vocabulary\Concept;
use DateTime;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

trait DateTimeTrait
{
    protected $pattern = '';
    protected $unicode = '';
    protected $php = '';
    protected $minimum;
    protected $exclusiveMinimum = false;
    protected $maximum;
    protected $exclusiveMaximum = false;
    protected $multipleOf;

    public function pattern() : string
    {
        return $this->pattern;
    }

    public function unicode() : string
    {
        return $this->unicode;
    }

    public function php() : string
    {
        return $this->php;
    }

    public function hasMinimumValue() : bool
    {
        return $this->minimum !== null;
    }

    public function minimumValue() : DateTime
    {
        return new DateTime($this->minimum);
    }

    public function exclusiveMinimum() : bool
    {
        return $this->exclusiveMinimum;
    }

    public function hasMaximumValue() : bool
    {
        return $this->maximum !== null;
    }

    public function maximumValue() : DateTime
    {
        return new DateTime($this->maximum);
    }

    public function exclusiveMaximum() : bool
    {
        return $this->exclusiveMaximum;
    }

    public static function buildDateTimeMetadata(ClassMetadataBuilder $builder) : void
    {
        $builder->addStringField('pattern', 255);
        $builder->addStringField('unicode', 50);
        $builder->addStringField('php', 50);
        $builder->addStringField('minimum', 50);
        $builder->addMappedField('exclusive_minimum', 'exclusiveMinimum', 'boolean');
        $builder->addStringField('maximum', 50);
        $builder->addMappedField('exclusive_maximum', 'exclusiveMaximum', 'boolean');
    }

    protected function dateTimeConstraints() : iterable
    {
        $constraints = [];
        if ($this->hasMinimumValue()) {
            if ($this->exclusiveMinimum()) {
                $constraints[] = new GreaterThan($this->minimumValue());
            } else {
                $constraints[] = new GreaterThanOrEqual($this->minimumValue());
            }
        }
        if ($this->hasMaximumValue()) {
            if ($this->exclusiveMaximum()) {
                $constraints[] = new LessThan($this->maximumValue());
            } else {
                $constraints[] = new LessThanOrEqual($this->maximumValue());
            }
        }
        return $constraints;
    }

    protected function fragmentValue($fragment, Collection $properties = null)
    {
        if ($fragment instanceof Collection) {
            $fragment = $fragment->first();
        }
        return $fragment->value();
    }

    protected function hydrateFragment($data, Fragment $fragment, Concept $vocabulary = null) : void
    {
        if ($this->isSpan() || $fragment->isSpan()) {
            $fragment->setSpan($data[0], $data[1]);
        } else {
            $fragment->setValue($data);
        }
    }
}
