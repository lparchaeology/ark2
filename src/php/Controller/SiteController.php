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
use ARK\Api\ItemResourceDocument;
use ARK\Api\ItemResourceTransformer;
use ARK\Api\JsonApiAction;
use ARK\Model\Collection;
use ARK\Model\Item;
use ARK\Model\Module;
use ARK\View\Element;

class SiteController
{
    private function loadFlashes(Application $app)
    {
        $app['session']->getFlashBag()->clear();
        $flashes = $app['database']->getFlashes($app['locale']);
        //$flashes = array();
        foreach ($flashes as $flash) {
            $app['session']->getFlashBag()->add($flash['type'], $flash['text']);
        }
    }

    public function viewSiteAction(Application $app, Request $request, $siteSlug)
    {
        $this->loadFlashes($app);
        $root = Item::getRoot($app['database'], 'ark');
        $item = $root->submodule('ste')->item($siteSlug);
        if (!$item->isValid()) {
            throw new NotFoundHttpException('Site Code '.$siteSlug.' is not valid.');
        }
        $layout = Element::get($app['database'], 'cor_layout_item', $item);
        return $layout->render($app['twig'], array(), $app['form.factory'], $item);
    }

    public function listSitesAction(Application $app, Request $request)
    {
        $this->loadFlashes($app);
        $root = Item::getRoot($app['database'], 'ark');
        $sites = Collection::get($app['database'], $root->submodule('ste'), null, 'sites');
        $layout = Element::get($app['database'], 'cor_layout_list', $sites);

        $fields = $layout->allFields();
        $items = $sites->items();
        $rows = array();
        foreach ($items as $item) {
            $data = array();
            $data['id'] = $item->id();
            $data['parent'] = $item->parent();
            $data['idx'] = $item->index();
            $data['name'] = $item->name();
            $data['modtype'] = $item->modtype();
            foreach ($fields as $field) {
                $data = array_merge($data, $field->itemData($item, true));
            }
            $rows[] = $data;
        }
        $options  = array(
            'items' => $rows,
        );

        return $layout->render($app['twig'], $options);
    }

    public function getSiteAction(Application $app, Request $request, $siteSlug)
    {
        try {
            $action = JsonApiAction($app, $request);
            $action->validateRequest();
            $root = Module::getRoot($app['database'], 'ark');
            $item = $root->submodule($root->schemaId(), 'ste')->item($siteSlug);
            $transformer = new ItemResourceTransformer($request->get('schema') == 'true');
            $doc = new ItemResourceDocument($transformer);
        } catch (JsonApiException $e) {
            $response = $e->response();
        } catch (\Exception $e) {
            $error = new ApplicationError();
            $response = $error->response();
        }
        return $action->getFoundationResponse();
        /*
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
            $jsonapi['data']['attributes'] = $item->attributes();
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
        */
    }

    public function getSitesAction(Application $app, Request $request)
    {
        $uri = $request->getSchemeAndHttpHost().$request->getBaseUrl().$request->getPathInfo();
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $jsonapi['jsonapi']['version'] = '1.0';

        try {
            $root = Module::getRoot($app['database'], 'ark');
            $items = $root->submodule($root->schemaId(), 'ste')->items();

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
