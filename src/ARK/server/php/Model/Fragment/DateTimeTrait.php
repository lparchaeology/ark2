<?php

/**
 * ARK Model DateTime Fragment.
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

namespace ARK\Model\Fragment;

use DateTime;

trait DateTimeTrait
{
    protected $realValue;
    protected $realSpan;

    public function __toString() : string
    {
        return $this->value()->format($this->pattern);
    }

    public function value()
    {
        if ($this->realValue === null && $this->value !== null) {
            $this->realValue = $this->makeDate($this->value);
        }
        return $this->realValue;
    }

    public function span()
    {
        if ($this->realSpan === null && $this->span !== null) {
            $this->realSpan = $this->makeDate($this->span);
        }
        return $this->realSpan;
    }

    public function setValue($value, $parameter = null, $format = null) : void
    {
        if (!$value instanceof DateTime) {
            $value = new DateTime($value);
        }
        // TODO Convert if $parameter set?
        parent::setValue($value, $value->getTimeZone()->getName(), $format);
        $this->realValue = $value;
    }

    public function setSpan($fromValue, $toValue, $parameter = null, $format = null) : void
    {
        if (!$fromValue instanceof DateTime) {
            $fromValue = new DateTime($fromValue);
        }
        if (!$toValue instanceof DateTime) {
            $toValue = new DateTime($toValue);
        }
        $toValue.setTimeZone($value->getTimeZone());
        parent::setSpan($fromValue, $toValue, $value->getTimeZone()->getName(), $format);
        $this->realValue = $fromValue;
        $this->realSpan = $toValue;
    }

    protected function makeDate($date) : DateTime
    {
        $dt = ($date instanceof DateTime ? $date->format($this->pattern) : $date);
        return new DateTime($dt);
    }
}
