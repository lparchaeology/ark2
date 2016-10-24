<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/SiteGetAction.php
*
* JSON:API Action
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
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApi/Action/SiteGetAction.php
* @since      2.0
*/

namespace ARK\Api\JsonApi\Action;

use ARK\Application;
use ARK\Api\JsonApi\Error\NotFoundError;
use ARK\Api\JsonApi\ItemResource;
use ARK\Api\JsonApi\JsonApiException;
use ARK\Api\JsonApi\JsonApiRequest;
use ARK\Api\JsonApi\JsonApiResponse;
use ARK\Api\JsonApi\Serializer\ItemSerializer;
use ARK\Model\Module;
use Exception;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Resource;

class SiteGetAction extends AbstractGetAction
{
    public function __invoke(Application $app, JsonApiRequest $request, string $siteSlug = null)
    {
        $this->site = $siteSlug;
        return parent::__invoke($app, $request);
    }

    protected function getData()
    {
        try {
            $root = Module::getRoot($this->app['database'], 'ark');
            $item = $root->submodule($root->schemaId(), 'ste')->item($this->site);
            if (!$item->isValid()) {
                throw new Exception();
            }
        } catch (Exception $e) {
            $this->addError(new NotFoundError('sites', $this->site));
            throw new JsonApiException();
        }
        return $item;
    }

    protected function getResponse($data)
    {
        $resource = new ItemResource($data, $this->serializer);
        $document = new Document($resource);
        return new JsonApiResponse($document);
    }
}
