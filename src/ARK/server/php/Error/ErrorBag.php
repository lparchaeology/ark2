<?php

/**
 * ARK Error Bag.
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

namespace ARK\Error;

use ARK\Http\StatusCodeTrait;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class ErrorBag implements Countable, IteratorAggregate
{
    use StatusCodeTrait;

    protected $code = '';
    protected $message = '';
    protected $errors = [];

    public function __construct(Error $error = null)
    {
        if ($error) {
            $this->addError($error);
        }
    }

    public function statusCode() : int
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

    public function setCode(string $code) : void
    {
        $this->errorCode = $code;
    }

    public function code() : string
    {
        if ($this->code) {
            return $this->code;
        }
        if (count($this->errors) === 1) {
            return $this->errors[0]->getCode();
        }
        return 'MULTIPLE_ERROR_CODES';
    }

    public function errors() : iterable
    {
        return $this->errors;
    }

    public function addError(Error $error) : void
    {
        $this->errors[] = $error;
    }

    public function prependError(Error $error) : void
    {
        $this->errors = array_merge([$error], $this->errors);
    }

    public function count() : int
    {
        return count($this->errors);
    }

    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->errors);
    }
}
