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
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\DBAL\Connection;
use ARK\Database\Database;
use ARK\Schema\Layout;

class ItemController
{
    public function viewItemAction(Application $app, Request $request, $site, $module, $item)
    {
        $mod_lower = strtolower($module);
        try {
            $mod = $app['database']->config()->fetchAssoc('SELECT * FROM cor_conf_module WHERE module_id = ? OR url = ?', array($mod_lower, $mod_lower));
        } catch (DBALException $e) {
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$site);
        }
        if (!$mod) {
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$site);
        }

        try {
            $mod_tbl = $mod['tbl'];
            $modtype_tbl = $mod['modtype_tbl'];
            $itemkey = $mod['itemkey'];
            $modtype = $mod['modtype'];
            if ($modtype) {
                $sql = "
                    SELECT *
                    FROM $mod_tbl, $modtype_tbl
                    WHERE $mod_tbl.$itemkey = :itemvalue
                    AND $modtype_tbl.id = $mod_tbl.$modtype
                ";
            } else {
                $sql = "
                    SELECT *
                    FROM $mod_tbl
                    WHERE $mod_tbl.$itemkey = :itemvalue
                ";
            }
            $params = array(
                ':itemvalue' => $site.'_'.$item,
            );
            $itemRow = $app['database']->data()->fetchAssoc($sql, $params);
        } catch (DBALException $e) {
            throw new NotFoundHttpException('Item '.$site.'_'.$item.' not found!');
        }
        if (!$itemRow) {
            throw new NotFoundHttpException('Item '.$site.'_'.$item.' not found!');
        }

        $forms = array();

        $itemKey = array(
            'site' => $site,
            'module' => $mod['module_id'],
            'modtype' => $itemRow[$mod['modtype']],
            'item' => $item,
            'key' => $mod['itemkey'],
            'modname' => $mod['name'],
            'value' => $itemRow[$mod['itemkey']],
        );
        $formBuilder = $app->form($itemKey);
        $formBuilder->add('site', Type\TextType::class, array('label' => 'Site', 'attr' => array('readonly' => true)));
        $formBuilder->add('module', Type\TextType::class, array('label' => 'Module', 'attr' => array('readonly' => true)));
        $formBuilder->add('item', Type\TextType::class, array('label' => 'Item', 'attr' => array('readonly' => true)));
        $forms['item_form'] = $formBuilder->getForm()->createView();

        if ($itemKey['module'] == 'abk') {
            $layout = Layout::fetchLayout($app['database'], $itemKey['module'].'_layout_item_tabs', $itemKey['modname'], $itemKey['modtype']);
            dump($layout);
            return $layout->render($app['twig'], $app['form.factory'], $itemKey);
            /*
            foreach ($layout->tabs() as $tdx => $tab) {
                foreach ($tab as $rdx => $row) {
                    foreach ($row as $cdx => $col) {
                        foreach ($col as $subform) {
                            $data = array();
                            $data[$subform->id()] = $subform->formData($itemKey, $itemKey);
                            $formBuilder = $app->namedForm($subform->id(), $data);
                            $subform->buildForm($formBuilder);
                            $forms[$tdx][$rdx][$cdx][] = $formBuilder->getForm()->createView();
                        }
                    }
                }
            }
            dump($forms);
            return $app['twig']->render('ark_main_page.html.twig', array('layout' => $layout, 'forms' => $forms));
            */
        }
        $schema = new \ARK\Schema\Group($app['database'], 'micro_view_'.$mod['module_id'].'_section');
        $cols = $schema->elements();
        $i = 1;
        foreach ($cols as $col) {
            $panels = $col->elements();
            foreach ($panels as $panel) {
                //$data = $model->getFields($itemKey, $panel->allFields());
                $data = array();
                //$data[$panel->id()] = $this->getFields($app['db'], $itemKey, $panel->allFields());
                $data[$panel->id()] = $panel->formData($itemKey, $itemKey);
                $formBuilder = $app->namedForm($panel->id(), $data);
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
    private function getFields(Database $db, $itemKey, $fields)
    {
        $values = array();
        foreach ($fields as $field) {
            switch ($field->dataclass()) {
                case 'txt':
                    $row = $db->getText($connection, $itemKey, $field->classtype(), 'en');
                    if (isset($row['txt'])) {
                        $values[$field->id()] = $row['txt'];
                    }
                    break;
                case 'number':
                    $row = $db->getNumber($connection, $itemKey, $field->classtype());
                    if (isset($row['number'])) {
                        $values[$field->id()] = $row['number'];
                    }
                    break;
                case 'date':
                    $row = $db->getDate($connection, $itemKey, $field->classtype());
                    if (isset($row['date'])) {
                        $values[$field->id()] = new \DateTime($row['date']);
                    }
                    break;
                case 'attribute':
                    $row = $db->getAttribute($connection, $itemKey, $field->classtype());
                    if (isset($row['attribute'])) {
                        $values[$field->id()] = $row['attribute'];
                    }
                    break;
                case 'file':
                    $row = $db->getFile($connection, $itemKey, $field->classtype());
                    if (isset($row['txt'])) {
                        //$values[$field->id()] = $row['filename'];
                    }
                    break;
            }
        }
        return $values;
    }

}
