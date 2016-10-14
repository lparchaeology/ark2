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
* @see        http://ark.lparchaeology.com/code/src/php/Api/SiteGetAction.php
* @since      2.0
*/

namespace ARK\Api;

use ARK\Application;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class SiteGetAction extends JsonApiAction
{
    public function __construct(Application $app, HttpFoundationRequest $request, string $site)
    {
        parent::__construct($app, $request);
        try {
            $this->validateRequest();
            $root = Module::getRoot($this->app['database'], 'ark');
            $item = $root->submodule($root->schemaId(), 'ste')->item($site);
            $additionalMeta = ($this->request->get('schema') == 'true') ? ['schema' => $item->schema()] : [];
            $this->response = $this->transformResponse(new JsonApiResponse(200), new ItemResourceDocument(), $item, $additionalMeta);
        } catch (JsonApiException $e) {
            $this->response = $this->transformErrors($e->getErrors());
        } catch (\Exception $e) {
            $e = new ApplicationError();
            $this->response = $this->transformErrors($e->getErrors());
        }
    }
}
