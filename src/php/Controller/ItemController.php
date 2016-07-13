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
use Doctrine\DBAL\Connection;

class ItemController
{
    public function viewItemAction(Application $app, Request $request, $site, $module, $item)
    {
        $mod_lower = strtolower($module);
        try {
            $mod = $app['db.conf']->fetchAssoc('SELECT * FROM cor_conf_module WHERE module_id = ? OR url = ?', array($mod_lower, $mod_lower));
        } catch (DBALException $e) {
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$site);
        }
        if (!$mod) {
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$site);
        }

        $forms = array();

        $itemKey = array(
            'site' => $site,
            'module' => $mod['module_id'],
            'item' => $item,
            'key' => $mod['module_id'].'_cd',
            'value' => $site.'_'.$item,
        );
        $formBuilder = $app->form($itemKey);
        $formBuilder->add('site', Type\TextType::class, array('label' => 'Site', 'attr' => array('readonly' => true)));
        $formBuilder->add('module', Type\TextType::class, array('label' => 'Module', 'attr' => array('readonly' => true)));
        $formBuilder->add('item', Type\TextType::class, array('label' => 'Item', 'attr' => array('readonly' => true)));
        $forms['item_form'] = $formBuilder->getForm()->createView();

        $schema = new \ARK\Schema\Group($app['db.conf'], 'micro_view_'.$mod['module_id'].'_section');
        $cols = $schema->elements();
        $i = 1;
        foreach ($cols as $col) {
            $panels = $col->elements();
            foreach ($panels as $panel) {
                //$data = $model->getFields($itemKey, $panel->allFields());
                $data = array();
                $data[$panel->id()] = $this->getFields($app['db'], $itemKey, $panel->allFields());
                dump($data);
                $formBuilder = $app->form($data);
                $panel->buildForm($formBuilder);
                $forms['col'.$i.'_forms'][] = $formBuilder->getForm()->createView();
            }
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

    // TODO Move to Model class
    private function getFields(Connection $connection, $itemKey, $fields)
    {
        $values = array();
        $db = new \ARK\Database\Database();
        foreach ($fields as $field) {
            switch ($field->dataclass()) {
                case 'txt':
                    $row = $db->getText($connection, $itemKey, $field->classtype(), 'en');
                    $values[$field->id()] = $row['txt'];
                    break;
                case 'number':
                    $row = $db->getNumber($connection, $itemKey, $field->classtype());
                    $values[$field->id()] = $row['number'];
                    break;
                case 'date':
                    $row = $db->getDate($connection, $itemKey, $field->classtype());
                    $values[$field->id()] = $row['date'];
                    break;
            }
        }
        return $values;
    }

}
