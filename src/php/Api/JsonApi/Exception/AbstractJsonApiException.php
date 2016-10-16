<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonApi/Exception/AbstractJsonApiException.php
*
* JSON:API Invalid JSON:API Error
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApi/Exception/AbstractJsonApiException.php
* @since      2.0
*/

namespace ARK\Api\JsonApi\Exception;

use Exception;
use NilPortugues\Api\JsonApi\Server\Errors\Error;
use NilPortugues\Api\JsonApi\Server\Errors\ErrorBag;

class AbstractJsonApiException extends Exception
{
    protected $errors = null;
    protected $responseClass = null;

    public function __construct(string $message, $code, string $responseClass)
    {
        parent::__construct($message, $code);
        $this->errors = new ErrorBag();
        $this->responseClass = $responseClass;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors(ErrorBag $errors)
    {
        $this->errors = $errors;
    }

    public function addErrors(ErrorBag $errors)
    {
        $this->errors =array_merge($this->errors, $errors);
    }

    public function addError(Error $error)
    {
        $this->errors[] = $error;
    }

    public function getResponse()
    {
        return new $this->responseClass($this->errors);
    }
}
