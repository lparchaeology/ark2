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
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;

class SiteGetAction extends AbstractGetAction
{
    public function __invoke(Application $app, HttpFoundationRequest $request, string $site)
    {
        $this->site = $site;
        parent::__invoke($app, $request);
    }

    protected function getData()
    {
        $root = Module::getRoot($this->app['database'], 'ark');
        $item = $root->submodule($root->schemaId(), 'ste')->item($this->site);
        if (!$item->isValid()) {
            $error = new NotFoundError('sites', $this->site());
            throw new ResourceNotFoundException();
        }
        return $item;
    }
}
