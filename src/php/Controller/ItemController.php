<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Controller/ItemController.php
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
* @see        http://ark.lparchaeology.com/code/src/php/Controller/ItemController.php
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
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\DBAL\Connection;
use ARK\Database\Database;
use ARK\Layout\Layout;
use ARK\Schema\Schema;

class ItemController
{
    public function getItemAction(Application $app, Request $request, $site, $module, $item)
    {
        $mod = $app['database']->getModule(strtolower($module));
        if (!$mod) {
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$site);
        }

        $mod_tbl = $mod['tbl'];
        $modtype = $mod['modtype'];
        $itemkey = $mod['itemkey'];
        $itemvalue = $site.'_'.$item;

        $itemRow = $app['database']->getItem($itemkey, $itemvalue, $mod_tbl);
        if (!$itemRow) {
            throw new NotFoundHttpException('Item '.$itemvalue.' not found!');
        }

        $itemKey = array(
            'site' => $site,
            'module' => $mod['module'],
            'item' => $item,
            'key' => $itemkey,
            'value' => $itemRow[$itemkey],
        );
        if (empty($modtype)) {
            $itemKey['modtype'] = $mod['module'];
        } else {
            $itemKey['modtype'] = $modtype;
            $itemKey[$modtype] = $itemRow[$modtype];
        }

        $schema = new Schema($app['database'], $mod['module']);
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $response->setData($schema->schema());
        return $response;
    }

    public function viewItemAction(Application $app, Request $request, $site, $module, $item)
    {
        $mod = $app['database']->getModule(strtolower($module));
        if (!$mod) {
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$site);
        }

        $mod_tbl = $mod['tbl'];
        $modtype = $mod['modtype'];
        $itemkey = $mod['itemkey'];
        $itemvalue = $site.'_'.$item;

        $itemRow = $app['database']->getItem($itemkey, $itemvalue, $mod_tbl);
        if (!$itemRow) {
            throw new NotFoundHttpException('Item '.$itemvalue.' not found!');
        }

        $itemKey = array(
            'site' => $site,
            'module' => $mod['module'],
            'item' => $item,
            'key' => $itemkey,
            'value' => $itemRow[$itemkey],
        );
        if (empty($modtype)) {
            $itemKey['modtype'] = $mod['module'];
        } else {
            $itemKey['modtype'] = $modtype;
            $itemKey[$modtype] = $itemRow[$modtype];
        }

        // TODO Make into a Subform
        $forms = array();
        $formBuilder = $app->form($itemKey);
        $formBuilder->add('site', Type\TextType::class, array('label' => 'Site', 'attr' => array('readonly' => true)));
        $formBuilder->add('module', Type\TextType::class, array('label' => 'Module', 'attr' => array('readonly' => true)));
        $formBuilder->add('item', Type\TextType::class, array('label' => 'Item', 'attr' => array('readonly' => true)));
        $forms['item_form'] = $formBuilder->getForm()->createView();

        $layout = Layout::fetchLayout($app['database'], 'cor_layout_item', $itemKey['module'], $itemRow[$modtype]);
        $options = array('item_form' => $forms['item_form']);
        return $layout->render($app['twig'], $options, $app['form.factory'], $itemKey);
    }

    public function registerItemAction(Application $app, Request $request, $ste_cd, $mod_slug)
    {
        $module = $app['database']->getModule(strtolower($mod_slug));
        if (!$module) {
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$ste_cd);
        }

        $mod_tbl = $module['tbl'];
        $modtype = $module['modtype'];
        $itemkey = $module['itemkey'];

        $itemKey = array(
            'site' => $ste_cd,
            'mod_slug' => $mod_slug,
            'module' => $module['module'],
            'key' => $itemkey,
        );

        $layout = Layout::fetchLayout($app['database'], 'cor_layout_register', $module['module']);

        $fields = $layout->allFields();
        dump($fields);
        foreach ($fields as $field) {
            if ($field->dataclass() == 'itemkey') {
                $keyfield = $field->id();
            }
        }
        $items = $app['database']->getRecentItems($ste_cd, $module['module'], 5);
        foreach ($items as &$item) {
            if (empty($modtype)) {
                $itemKey['modtype'] = $module['module'];
            } else {
                $itemKey['modtype'] = $modtype;
                $itemKey[$modtype] = $item[$modtype];
            }
            $itemKey['value'] = $item[$itemkey];
            $data = array();
            foreach ($fields as $field) {
                $data = array_merge($data, $field->formData($itemKey, true));
            }
            $item = array_merge($item, $data);
        }


        $options  = array(
            'itemkey' => $module['itemkey'],
            'itemno' => $module['itemno'],
            'items' => $items,
            'keyfield' => $keyfield,
        );
        if ($module['modtype']) {
            $options['modtype'] = $module['modtype'];
        }

        return $layout->render($app['twig'], $options);
    }

    public function listItemsAction(Application $app, Request $request, $ste_cd, $mod_slug)
    {
        $module = $app['database']->getModule(strtolower($mod_slug));
        if (!$module) {
            throw new NotFoundHttpException('Module '.$module.' is not valid for site '.$ste_cd);
        }

        $mod_tbl = $module['tbl'];
        $modtype = $module['modtype'];
        $itemkey = $module['itemkey'];

        $itemKey = array(
            'site' => $ste_cd,
            'mod_slug' => $mod_slug,
            'module' => $module['module'],
            'key' => $itemkey,
        );

        $layout = Layout::fetchLayout($app['database'], 'cor_layout_list', $module['module']);
        $fields = $layout->allFields();
        $items = $app['database']->getItems($ste_cd, $module['module']);
        foreach ($items as &$item) {
            if (empty($modtype)) {
                $itemKey['modtype'] = $module['module'];
            } else {
                $itemKey['modtype'] = $modtype;
                $itemKey[$modtype] = $item[$modtype];
            }
            $itemKey['value'] = $item[$itemkey];
            $data = array();
            foreach ($fields as $field) {
                $data = array_merge($data, $field->formData($itemKey, true));
            }
            $item = array_merge($item, $data);
        }

        $options  = array(
            'itemkey' => $module['itemkey'],
            'itemno' => $module['itemno'],
            'items' => $items,
        );
        if ($module['modtype']) {
            $options['modtype'] = $module['modtype'];
        }

        return $layout->render($app['twig'], $options);
    }

    // TODO Move to Model class
    private function getFields(Database $db, $itemKey, $fields)
    {
        $values = array();
        foreach ($fields as $field) {
            switch ($field->dataclass()) {
                case 'txt':
                    $row = $db->getText($itemKey, $field->classtype(), 'en');
                    if (isset($row['txt'])) {
                        $values[$field->id()] = $row['txt'];
                    }
                    break;
                case 'number':
                    $row = $db->getNumber($itemKey, $field->classtype());
                    if (isset($row['number'])) {
                        $values[$field->id()] = $row['number'];
                    }
                    break;
                case 'date':
                    $row = $db->getDate($itemKey, $field->classtype());
                    if (isset($row['date'])) {
                        $values[$field->id()] = new \DateTime($row['date']);
                    }
                    break;
                case 'attribute':
                    $row = $db->getAttribute($itemKey, $field->classtype());
                    if (isset($row['attribute'])) {
                        $values[$field->id()] = $row['attribute'];
                    }
                    break;
                case 'file':
                    $row = $db->getFile($itemKey, $field->classtype());
                    if (isset($row['txt'])) {
                        //$values[$field->id()] = $row['filename'];
                    }
                    break;
            }
        }
        return $values;
    }

}
