<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Controller/SiteController.php
*
* ARK Schema Group
*
* PHP version 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Heritage LLP.
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
* @see        http://ark.lparchaeology.com/code/src/php/Controller/SiteController.php
* @since      2.0
*
*/

namespace ARK\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type;
use ARK\Model\Module;

class SiteController
{
    public function viewSiteAction(Application $app, Request $request, $siteSlug)
    {
        $root = Module::getRoot($app['database'], 'ark');
        $item = $root->submodule('ste')->item($siteSlug);
        $layout = Layout::fetchLayout($app['database'], 'cor_layout_site', $item->module(), $item->modtype());
        return $layout->render($app['twig'], array(), $app['form.factory'], $item);
    }

    public function getSiteAction(Application $app, Request $request, $siteSlug)
    {
        $uri = $request->getSchemeAndHttpHost().$request->getBaseUrl().$request->getPathInfo();
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $jsonapi['jsonapi']['version'] = '1.0';

        try {
            $root = Module::getRoot($app['database'], 'ark');
            $item = $root->submodule($root->schemaId(), 'ste')->item($siteSlug);

            if ($request->get('schema') == 'true') {
                $jsonapi['meta']['schema'] = $item->schema();
            }
            $jsonapi['data']['type'] = $item->module()->type();
            $jsonapi['data']['id'] = $item->id();
            $jsonapi['data']['attributes'] = $item->attributes($app['locale']);
            foreach ($item->submodules() as $submodule) {
                $jsonapi['data']['relationships'][$submodule->type()]['meta']['module'] = $submodule->id();
                $jsonapi['data']['relationships'][$submodule->type()]['links']['related'] = $uri.'/'.$submodule->type();
            }
            $jsonapi['data']['links']['self'] = $uri;
        } catch (Error $e) {
            $jsonapi['errors'][] = $e->payload();
        }

        $response->setData($jsonapi);
        return $response;
    }

    public function getSitesAction(Application $app, Request $request)
    {
        $uri = $request->getSchemeAndHttpHost().$request->getBaseUrl().$request->getPathInfo();
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $jsonapi['jsonapi']['version'] = '1.0';

        try {
            $root = Module::getRoot($app['database'], 'ark');
            $items = $root->submodule('ste')->items();

            foreach ($items as $item) {
                $resource['type'] = $item->module()->type();
                $resource['id'] = $item->id();
                if ($request->get('schema') == 'true') {
                    $resource['meta']['schema'] = $item->schema();
                }
                $resource['links']['self'] = $uri.'/'.$item->index();
                $jsonapi['data'][] = $resource;
            }
        } catch (Error $e) {
            $jsonapi['errors'][] = $e->payload();
        }

        $response->setData($jsonapi);
        //throw new \Exception('crash!');
        return $response;
    }
}
