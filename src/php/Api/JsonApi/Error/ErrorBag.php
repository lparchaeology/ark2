<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonApi/Error/ErrorBag.php
*
* JSON:API Error Bag
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApi/Error/ErrorBag.php
* @since      2.0
*/

namespace ARK\Api\JsonApi\Error;

use ARK\Http\StatusCodeTrait;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use JsonSerializable;

class ErrorBag implements Countable, IteratorAggregate, JsonSerializable
{
    use StatusCodeTrait;

    protected $code = null;
    protected $errors = null;

    public function statusCode()
    {
        if ($this->statusCode) {
            return $this->statusCode;
        }
        if (count($this->errors) === 1) {
            return $this->errors[0]->statusCode();
        }
        foreach ($this->errors as $error) {
            $statusCode = $error->statusCode();
            if ($statusCode && $statusCode >= 400 && $statusCode < 500) {
                return 400;
            }
        }
        return 500;
    }

    public function setCode(string $code)
    {
        $this->errorCode = $code;
    }

    public function code()
    {
        if ($this->code) {
            return $this->code;
        }
        if (count($this->errors) === 1) {
            return $this->errors[0]->getCode();
        }
        return 'MULTIPLE_ERROR_CODES';
    }

    public function errors()
    {
        return $this->errors;
    }

    public function addError(Error $error)
    {
        $this->errors[] = $error;
    }

    public function count()
    {
        return count($this->errors);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->errors);
    }

    public function toArray()
    {
        $data = null;
        foreach ($this->errors as $error) {
            $data['errors'][] = $error->toArray();
        }
        return $data;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
