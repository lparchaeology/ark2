<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/Group.php
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/Group.php
* @since      2.0
*
*/

namespace ARK\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ItemController
{
    public function viewItemAction(Application $app, Request $request, $site, $module, $item)
    {
        $mod_lower = strtolower($module);
        try {
            $mod = $app['db']->fetchAssoc('SELECT * FROM cor_conf_module WHERE module_id = ? OR url = ?', array($mod_lower, $mod_lower));
        } catch (DBALException $e) {
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$site);
        }
        if (!$mod) {
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$site);
        }

        $forms = array();

        $data = array(
            'site' => $site,
            'module' => $module,
            'item' => $item,
        );
        $formBuilder = $app->form($data);
        $formBuilder->add('site', Type\TextType::class, array('label' => 'Site', 'disabled' => true));
        $formBuilder->add('module', Type\TextType::class, array('label' => 'Module', 'disabled' => true));
        $formBuilder->add('item', Type\TextType::class, array('label' => 'Item', 'disabled' => true));
        $forms['item_form'] = $formBuilder->getForm()->createView();

        $schema = new \ARK\Schema\Group($app['db'], 'micro_view_'.$mod['module_id'].'_section');
        $cols = $schema->elements();
        $i = 1;
        foreach ($cols as $col) {
            $formBuilder = $app->form(array());
            $col->buildForm($formBuilder);
            $forms['col'.$i.'_form'] = $formBuilder->getForm()->createView();
            $i += 1;
        }
        /*
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // do something with the data

            // redirect somewhere
            return $app->redirect('form');
        }
        */
        return $app['twig']->render('ark_col_form_page.html.twig', $forms);
    }

}
