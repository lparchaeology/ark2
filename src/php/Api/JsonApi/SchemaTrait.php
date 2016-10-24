<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonApi/SchemaTrait.php
*
* JSON:API Schema Trait
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApi/SchemaTrait.php
* @since      2.0
*/

namespace ARK\Api\JsonApi;

use ARK\Api\JsonApi\Error\ErrorBag;
use ARK\Api\JsonApi\Error\InternalServerError;
use ARK\Api\JsonApi\Error\JsonValidationError;
use League\JsonGuard\Dereferencer;
use League\JsonGuard\Validator;
use Seld\JsonLint\JsonParser;

trait SchemaTrait
{
    public function lintJson(string $json, ErrorBag $errors)
    {
        try {
            (new JsonParser())->lint($json);
        } catch (ParsingException $e) {
            $errors->addError(new JsonLintError($e->message(), $e->code()));
            throw new JsonApiException();
        }
    }

    public function loadSchema(string $schemaPath, ErrorBag $errors)
    {
        $schema = (new Dereferencer())->dereference($schemaPath);
        if (!$schema) {
            $error = new InternalServerError(
                'JSON:API JSON Schema not valid',
                'The JSON:API JSON Schema could not be validated.'
            );
            $errors->addError($error);
            throw new JsonApiException();
        }
        return $schema;
    }

    public function validateJsonSchema(string $json, $schema, ErrorBag $errors)
    {
        $validator = new Validator(json_decode($json), $schema);
        if ($validator->fails()) {
            foreach ($validator->errors() as $error) {
                $errors->addError(new JsonValidationError($error));
            }
            throw new JsonApiException();
        }
    }
}
