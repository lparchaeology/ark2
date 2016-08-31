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
use ARK\Model\Item;
use ARK\Model\Site;

class SiteController
{
    public function viewSiteAction(Application $app, Request $request, $site)
    {
        $data = array(
            'site' => $site,
        );
        $formBuilder = $app->form($data);
        $formBuilder->add('site', Type\TextType::class, array('label' => 'Site', 'disabled' => true));
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // do something with the data

            // redirect somewhere
            return $app->redirect('form');
        }

        return $app['twig']->render('pages/page.html.twig', array('form' => $form->createView()));
    }

    public function getSiteAction(Application $app, Request $request, $siteSlug)
    {
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $jsonapi['jsonapi']['version'] = '1.0';
        $errors = array();

        try {
            $site = Site::get($app['database'], $siteSlug);
            $item = Item::get($app['database'], $site->id(), 'ste', $site->id());
            if ($request->get('schema') == 'true') {
                $jsonapi['meta']['schema'] = $site->schema();
            }
            $jsonapi['data']['type'] = $site->type();
            $jsonapi['data']['id'] = $site->id();
            $jsonapi['data']['attributes'] = $site->data($item, $app['locale']);
        } catch (Error $e) {
            $jsonapi['errors'][] = $e->payload();
        }

        $response->setData($jsonapi);
        return $response;
    }

    public function getSitesAction(Application $app, Request $request)
    {
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $jsonapi['jsonapi']['version'] = '1.0';
        $errors = array();

        try {
            $sites = Site::getAll($app['database']);
            foreach ($sites as $site) {
                $resource['type'] = $site->type();
                $resource['id'] = $site->id();
                if ($request->get('schema') == 'true') {
                    $resource['meta']['schema'] = $site->schema();
                }
                $jsonapi['data'][] = $resource;
            }
        } catch (Error $e) {
            $jsonapi['errors'][] = $e->payload();
        }

        $response->setData($jsonapi);
        return $response;
    }
}
