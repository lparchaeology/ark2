<?php

/**
 * ARK Error Source.
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

namespace ARK\Error;

class ErrorSource
{
    private $pointer = '';
    private $parameter = '';

    private function __construct()
    {
    }

    public function pointer() : string
    {
        return $this->pointer;
    }

    public function parameter() : string
    {
        return $this->parameter;
    }

    public static function fromPointer(string $pointer, string $parameter = null) : self
    {
        $source = new self();
        $source->pointer = $pointer;
        $source->paramater = $parameter;
        return $source;
    }

    public static function fromParameter(string $parameter) : self
    {
        $source = new self();
        $source->paramater = $parameter;
        return $source;
    }
}
