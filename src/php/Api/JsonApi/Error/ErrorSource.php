<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonApi/Error/ErrorSource.php
*
* JSON:API Error Source
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApi/Error/ErrorSource.php
* @since      2.0
*/

namespace ARK\Api\JsonApi\Error;

class ErrorSource
{
    private $pointer = null;
    private $parameter = null;

    private function __construct()
    {
    }

    public function pointer()
    {
        return $this->pointer;
    }

    public function parameter()
    {
        return $this->parameter;
    }

    public function toArray()
    {
        $data = null;
        if ($this->pointer()) {
            $data['pointer'] = $this->pointer();
        }
        if ($this->parameter()) {
            $data['parameter'] = $this->parameter();
        }
        return $data;
    }

    public static function fromPointer($pointer, $parameter = null)
    {
        $source = new ErrorSource();
        $source->pointer = $pointer;
        $source->paramater = $parameter;
        return $source;
    }

    public static function fromParameter($parameter)
    {
        $source = new ErrorSource();
        $source->paramater = $parameter;
        return $source;
    }
}
