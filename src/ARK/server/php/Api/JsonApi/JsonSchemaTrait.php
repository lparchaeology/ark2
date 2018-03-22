<?php

/**
 * ARK JSON:API Schema Trait.
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

namespace ARK\Api\JsonApi;

use ARK\Api\JsonApi\Error\InternalServerError;
use ARK\Error\ErrorBag;
use ARK\Serializer\JsonSchema\ValidationError;
use League\JsonGuard\Dereferencer;
use League\JsonGuard\Validator;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;

trait JsonSchemaTrait
{
    public function lintJson(/*string*/ $json, ErrorBag $errors) : void
    {
        try {
            (new JsonParser())->lint($json);
        } catch (ParsingException $e) {
            $errors->addError(new JsonLintError($e->message(), $e->code()));
            throw new JsonApiException();
        }
    }

    public function loadSchema(/*string*/ $schemaPath, ErrorBag $errors)
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

    public function validateJsonString(/*string*/ $jsonString, $schema, ErrorBag $errors) : void
    {
        $this->validateJsonDecode(json_decode($jsonString), $schema, $errors);
    }

    public function validateJsonDecode($jsonDecode, $schema, ErrorBag $errors) : void
    {
        $validator = new Validator($jsonDecode, $schema);
        if ($validator->fails()) {
            foreach ($validator->errors() as $error) {
                $errors->addError(new ValidationError(json_encode($jsonDecode), $error));
            }
            throw new JsonApiException();
        }
    }
}
