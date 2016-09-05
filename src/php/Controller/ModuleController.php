<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Controller/ModuleController.php
*
* ARK Module Controller
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
* @see        http://ark.lparchaeology.com/code/src/php/Controller/ModuleController.php
* @since      2.0
*
*/

namespace ARK\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ARK\Model\Item;
use ARK\Model\Module;
use ARK\Model\Site;

class ModuleController
{
    public function viewModuleAction(Application $app, Request $request, $site, $module)
    {
        $mod = $app['database']->getModule(strtolower($module));
        if (!$mod) {
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$site);
        }

        $data = array(
            'site' => $site,
            'module' => $module,
        );
        $formBuilder = $app->form($data);
        $formBuilder->add('site', Type\TextType::class, array('label' => 'Site', 'disabled' => true));
        $formBuilder->add('module', Type\TextType::class, array('label' => 'Module', 'disabled' => true));
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

    public function getModuleAction(Application $app, Request $request, $siteSlug, $moduleSlug)
    {
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $jsonapi['jsonapi']['version'] = '1.0';
        $errors = array();

        try {
            $ark = Module::get($app['database'], 'ark');
            $module = Module::getSubmodule($app['database'], $ark, 'ste');
            $item = $module->item($siteSlug);
            $submodule = Module::getSubmodule($app['database'], $module, 'ste');

            $site = Site::get($app['database'], $siteSlug);
            $module = Module::get($app['database'], $site, $moduleSlug);
            $item = Item::get($app['database'], $site->id(), $module->id(), '');
            if ($request->get('schema') == 'true') {
                $jsonapi['meta']['schema'] = $module->schema();
            }
            $jsonapi['data']['type'] = $module->type();
            $jsonapi['data']['id'] = $module->id();
            $jsonapi['data']['attributes'] = $module->data($item, $app['locale']);
        } catch (Error $e) {
            $jsonapi['errors'][] = $e->payload();
        }

        $response->setData($jsonapi);
        return $response;
    }

    public function getModulesAction(Application $app, Request $request, $siteSlug)
    {
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $jsonapi['jsonapi']['version'] = '1.0';
        $errors = array();

        try {
            $site = Site::get($app['database'], $siteSlug);
            $modules = Module::getAll($app['database'], $site);
            foreach ($modules as $module) {
                $resource['type'] = $module->type();
                $resource['id'] = $module->id();
            if ($request->get('schema') == 'true') {
                $resource['meta']['schema'] = $module->schema();
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
