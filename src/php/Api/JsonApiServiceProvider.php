<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonApiServiceProvider.php
*
* SimpleBus Service Provider
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApiServiceProvider.php
* @since      2.0
*/

namespace ARK\Api;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use NilPortugues\Api\JsonApi\JsonApiSerializer;
use NilPortugues\Api\JsonApi\JsonApiTransformer;
use NilPortugues\Api\Mapping\Mapper;

class JsonApiServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['jsonapi.mapping'] = [
            $classConfig = [
                SiteMapping::class,
            ]
        ];

        $app['jsonapi.mapper'] = function () use ($app) {
            return new Mapper($app['jsonapi.mapping']);
        };

        $app['jsonapi.transformer'] = function () use ($app) {
            return new JsonApiTransformer($app['jsonapi.mapper']);
        };

        $app['jsonapi.serializer'] = function () use ($app) {
            return new JsonApiSerializer($app['jsonapi.transformer']);
        };

        $app['jsonapi.schema'] = function () use ($app) {
            return $app['jsonschema.dereferencer']->dereference('file://../../schema/json/jsonapi.json');
        };
    }
}
