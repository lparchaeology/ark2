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
use ARK\Model\Collection;
use ARK\Model\Item;
use ARK\Model\Module;
use ARK\Model\Site;
use ARK\View\Element;

class ItemController
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

    public function getItemAction(Application $app, Request $request, $siteSlug, $moduleSlug, $itemSlug)
    {
        $uri = $request->getSchemeAndHttpHost().$request->getBaseUrl().$request->getPathInfo();
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $jsonapi['jsonapi']['version'] = '1.0';

        try {
            $root = Module::getRoot($app['database'], 'ark');
            $site = $root->submodule($root->schemaId(), 'ste')->item($siteSlug);
            $item = $site->submodule($moduleSlug)->itemFromIndex($site, $itemSlug);

            if ($request->get('schema') == 'true') {
                $jsonapi['meta']['schema'] = $item->schema();
            }
            $jsonapi['data']['type'] = $item->module()->type();
            $jsonapi['data']['id'] = $item->id();
            $jsonapi['data']['attributes'] = $item->attributes();
            foreach ($item->submodules() as $submodule) {
                $jsonapi['data']['relationships'][$submodule->type()]['links']['related'] = $uri.'/'.$submodule->type();
            }
            foreach ($item->relationships() as $relationship) {
                $jsonapi['data']['relationships'][$relationship->type()]['links']['self'] = $request->getUri().'/relationships/'.$relationship->type();
                $jsonapi['data']['relationships'][$relationship->type()]['links']['related'] = $uri.'/'.$relationship->type();
                foreach ($item->related($relationship) as $related) {
                    $resource['type'] = $related->module()->type();
                    $resource['id'] = $related->id();
                    $jsonapi['data']['relationships'][$relationship->type()]['data'][] = $resource;
                }
            }
            $jsonapi['data']['links']['self'] = $uri;
        } catch (Error $e) {
            $jsonapi['errors'][] = $e->payload();
        }

        $response->setData($jsonapi);
        return $response;
    }

    public function putItemAction(Application $app, Request $request, $siteSlug, $moduleSlug)
    {
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);

        $root = Module::getRoot($app['database'], 'ark');
        $site = $root->submodule($root->schemaId(), 'ste')->item($siteSlug);
        $module = $site->submodule($moduleSlug);
        $data = json_decode($request->getContent(), true);
        $last = $app['database']->getLastItem($module->id(), $site->id());
        $next = intval($last['idx']) + 1;
        $res = $app['database']->addItem($module->id(), $site->index(), $next, $data['modtype']);

        if ($res) {
            $item = $site->submodule($moduleSlug)->itemFromIndex($site, (string)$next);
            $data = $item->attributes();
        } else {
            $data['error'] = 'Uh oh...';
        }
        $response->setData($data);
        return $response;
    }

    public function getItemsAction(Application $app, Request $request, $siteSlug, $moduleSlug)
    {
        $uri = $request->getSchemeAndHttpHost().$request->getBaseUrl().$request->getPathInfo();
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $jsonapi['jsonapi']['version'] = '1.0';

        try {
            $root = Module::getRoot($app['database'], 'ark');
            $site = $root->submodule($root->schemaId(), 'ste')->item($siteSlug);
            $items = $site->submodule($moduleSlug)->items($site);

            $jsonapi['data'] = array();
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
        return $response;
    }

    public function viewItemAction(Application $app, Request $request, $siteSlug, $moduleSlug, $itemSlug)
    {
        $this->loadFlashes($app);

        $root = Module::getRoot($app['database'], 'ark');
        $site = $root->submodule($root->schemaId(), 'ste')->item($siteSlug);
        if (!$site->isValid()) {
            throw new NotFoundHttpException('Site Code '.$siteSlug.' is not valid.');
        }

        if (!$site->submodule($moduleSlug)->isValid()) {
            throw new NotFoundHttpException('Module '.$moduleSlug.' is not valid for Site Code '.$siteSlug);
        }

        $item = $site->submodule($moduleSlug)->itemFromIndex($site, $itemSlug);
        if (!$item->isValid()) {
            throw new NotFoundHttpException('Item '.$itemSlug.' is not valid for Site Code '.$siteSlug.' and Module '.$moduleSlug);
        }

        // TODO Make into a Subform
        $forms = array();
        $formBuilder = $app->form($item);
        $formBuilder->add('parentId', Type\TextType::class, array('label' => 'Site', 'attr' => array('readonly' => true)));
        $formBuilder->add('moduleId', Type\TextType::class, array('label' => 'Module', 'attr' => array('readonly' => true)));
        $formBuilder->add('index', Type\TextType::class, array('label' => 'Item', 'attr' => array('readonly' => true)));
        $forms['item_form'] = $formBuilder->getForm()->createView();

        $layout =  'cor_layout_item';
        if ($request->get('layout')) {
             $layout .= '_'.$request->get('layout');
        }

        $layout = Element::get($app['database'], $layout, $item);
        $options = array('item_form' => $forms['item_form']);
        return $layout->render($app['twig'], $options, $app['form.factory'], $item);
    }

    public function registerItemAction(Application $app, Request $request, $siteSlug, $moduleSlug)
    {
        $this->loadFlashes($app);

        $root = Item::getRoot($app['database'], 'ark');
        $site = $root->submodule('ste')->item($siteSlug);
        if (!$site->isValid()) {
            throw new NotFoundHttpException('Site Code '.$siteSlug.' is not valid.');
        }
        $mod = $app['database']->getModule($moduleSlug);
        $module = $site->submodule($mod['module']);
        if (!$module->isValid()) {
            throw new NotFoundHttpException('Module '.$moduleSlug.' is not valid for Site Code '.$siteSlug);
        }
        $coll = Collection::get($app['database'], $module, $site, 'items');
        $layout = Element::get($app['database'], 'cor_layout_list', $coll);

        $fields = $layout->allFields();
        $items = $coll->recentItems(5);
        $rows = array();
        foreach ($items as $item) {
            $data = array();
            foreach ($fields as $field) {
                $data = array_merge($data, $field->itemData($item, true));
            }
            $data['item'] = $item->id();
            $data['parent'] = $item->parent();
            $data['idx'] = $item->index();
            if ($item->modtype()) {
                $data['modtype'] = $item->modtype();
            }
            $data['cre_by'] = '';
            $data['cre_on'] = '';
            $rows[] = $data;
        }

        $options  = array(
            'items' => $rows,
        );

        return $layout->render($app['twig'], $options);
    }

    public function listItemsAction(Application $app, Request $request, $siteSlug, $moduleSlug)
    {
        $this->loadFlashes($app);

        $root = Item::getRoot($app['database'], 'ark');
        $site = $root->submodule('ste')->item($siteSlug);
        if (!$site->isValid()) {
            throw new NotFoundHttpException('Site Code '.$siteSlug.' is not valid.');
        }
        $mod = $app['database']->getModule($moduleSlug);
        $module = $site->submodule($mod['module']);
        if (!$module->isValid()) {
            throw new NotFoundHttpException('Module '.$moduleSlug.' is not valid for Site Code '.$siteSlug);
        }
        $coll = Collection::get($app['database'], $module, $site, 'items');
        $layout = Element::get($app['database'], 'cor_layout_list', $coll);

        $fields = $layout->allFields();
        $items = $coll->items();
        $rows = array();
        foreach ($items as $item) {
            $data = array();
            $data['item'] = $item->id();
            $data['parent'] = $item->parent();
            $data['idx'] = $item->index();
            $data['modtype'] = $item->modtype();
            $data['item'] = $item->id();
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
