<?php

/**
 * JSON Schema Validation Error
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\Serializer\JsonSchema;

use ARK\Error\Error;
use ARK\Error\ErrorSource;
use League\JsonGuard\ValidationError as GuardValidationError;

class ValidationError extends Error
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

    public function __construct(/*string*/ $json, GuardValidationError $error, /*string*/ $title = 'JSON Schema Validation Error')
    {
        parent::__construct($this->codes[$error->getCode()], $title, $error->getMessage(), 400);
        $this->setSource(ErrorSource::fromPointer($error->getPointer()));
        $this->setVariable('value', $error->getValue());
        $this->setVariable('constraints', $error->getConstraints());
        $this->setVariable('content', $json);
        $this->setVariable('pointer', $error->getPointer());
        if ($error->getCode() == 43) {
            $missing = array_values(array_diff($error->getConstraints()['required'], array_keys(get_object_vars($error->getValue()))));
            $this->setVariable('missing', $missing);
        }
    }
}
