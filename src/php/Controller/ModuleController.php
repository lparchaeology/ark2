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
use ARK\Model\Module;

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

    public function getSchemaAction(Application $app, Request $request, $site, $module)
    {
        $schema = new Module($app['database'], $site, $module);

        if (!$schema->valid()) {
            $ste = $app['database']->getItem('ste_cd', $site);
            if (!$ste) {
                throw new NotFoundHttpException('Site '.$site.' is not valid.');
            }
            $mod = $app['database']->getModule($module);
            if (!$mod) {
                throw new NotFoundHttpException('Module '.$module.' is not valid');
            }
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$site);
        }

        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $response->setData($schema->schema());
        return $response;
    }

}
