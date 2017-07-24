<?php

/**
 * ARK Site Controller
 *
 * Copyright (C) 2017  L - P : Heritage LLP.
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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework\Controller;

use ARK\Api\JsonApi\Action\SiteDeleteAction;
use ARK\Api\JsonApi\Action\SiteGetAction;
use ARK\Api\JsonApi\Action\SiteListAction;
use ARK\Api\JsonApi\Action\SitePostAction;
use ARK\Model\Item\Collection;
use ARK\Model\Item\Item;
use ARK\Model\Module\Module;
use ARK\View\Element;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type;

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
        $uri = $request->getSchemeAndHttpHost().$request->getBaseUrl().$request->getPathInfo();
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $jsonapi['jsonapi']['version'] = '1.0';

        try {
            $root = Module::getRoot($app['database'], 'ark');
            $item = $root->submodule($root->schemaId(), 'ste')->item($siteSlug);

            if ($request->get('schema') == 'true') {
                $jsonapi['meta']['schema'] = $app['serializer']->normalize($item->module(), 'json', ['schemaId' => $item->schemaId()]);
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
    }
}
