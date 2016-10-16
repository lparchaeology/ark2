<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonValidationError.php
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonValidationError.php
* @since      2.0
*/

namespace ARK\Api\JsonAPi\Error;

use League\JsonGuard\ValidationError;
use NilPortugues\Api\JsonApi\Server\Errors\Error as JsonApiError;

class JsonValidationError extends JsonApiError
{
    private $codes = [
        22 => 'INVALID_NUMERIC',
        23 => 'INVALID_NULL',
        24 => 'INVALID_INTEGER',
        25 => 'INVALID_STRING',
        26 => 'INVALID_BOOLEAN',
        27 => 'INVALID_ARRAY',
        28 => 'INVALID_OBJECT',
        29 => 'INVALID_ENUM',
        30 => 'INVALID_MIN',
        31 => 'INVALID_EXCLUSIVE_MIN',
        32 => 'INVALID_MAX',
        33 => 'INVALID_EXCLUSIVE_MAX',
        34 => 'INVALID_MIN_COUNT',
        35 => 'MAX_ITEMS_EXCEEDED',
        36 => 'INVALID_MIN_LENGTH',
        37 => 'INVALID_MAX_LENGTH',
        38 => 'INVALID_MULTIPLE',
        39 => 'NOT_UNIQUE_ITEM',
        40 => 'INVALID_PATTERN',
        41 => 'INVALID_TYPE',
        42 => 'NOT_SCHEMA',
        43 => 'MISSING_REQUIRED',
        44 => 'ONE_OF_SCHEMA',
        45 => 'ANY_OF_SCHEMA',
        46 => 'ALL_OF_SCHEMA',
        47 => 'NOT_ALLOWED_PROPERTY',
        48 => 'INVALID_EMAIL',
        49 => 'INVALID_URI',
        50 => 'INVALID_IPV4',
        51 => 'INVALID_IPV6',
        52 => 'INVALID_DATE_TIME',
        53 => 'INVALID_HOST_NAME',
        54 => 'INVALID_FORMAT',
        55 => 'NOT_ALLOWED_ITEM',
        56 => 'UNMET_DEPENDENCY',
        57 => 'MAX_PROPERTIES_EXCEEDED',
    ];

    public function __construct(ValidationError $error, string $title = 'JSON Validation Error')
    {
        parent::__construct($title, $error->getMessage(), $this->codes[$error->getCode()]);
        $this->setSource('pointer', $error->getPointer());
        $this->setMeta(['value' => $error->getValue(), 'constraints', $error->getConstraints()]);
    }
}
