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
use ARK\Model\Item;
use ARK\Model\Module;
use ARK\Model\Site;
use ARK\View\Layout;

class ItemController
{
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

    public function getItemsAction(Application $app, Request $request, $siteSlug, $moduleSlug)
    {
        $uri = $request->getSchemeAndHttpHost().$request->getBaseUrl().$request->getPathInfo();
        $response = new JsonResponse(null);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        $jsonapi['jsonapi']['version'] = '1.0';

        try {
            $root = Module::getRoot($app['database'], 'ark');
            $site = $root->submodule('ste')->item($siteSlug);
            $items = $site->submodule($moduleSlug)->items($site->id());

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
        $root = Module::getRoot($app['database'], 'ark');
        $site = $root->submodule('ste', $root->schemaId())->item($siteSlug);
        if (!$site->isValid()) {
            throw new NotFoundHttpException('Site Code '.$siteSlug.' is not valid.');
        }

        if (!$site->submodule($moduleSlug)->isValid()) {
            throw new NotFoundHttpException('Module '.$moduleSlug.' is not valid for Site Code '.$siteSlug);
        }

        $item = $site->submodule($moduleSlug)->itemFromIndex($site->id(), $itemSlug);
        if (!$item->isValid()) {
            throw new NotFoundHttpException('Item '.$itemSlug.' is not valid for Site Code '.$siteSlug.' and Module '.$moduleSlug);
        }

        // TODO Make into a Subform
        $forms = array();
        $formBuilder = $app->form($item);
        $formBuilder->add('parent', Type\TextType::class, array('label' => 'Site', 'attr' => array('readonly' => true)));
        $formBuilder->add('moduleId', Type\TextType::class, array('label' => 'Module', 'attr' => array('readonly' => true)));
        $formBuilder->add('index', Type\TextType::class, array('label' => 'Item', 'attr' => array('readonly' => true)));
        $forms['item_form'] = $formBuilder->getForm()->createView();

        $layout = Layout::fetchLayout($app['database'], 'cor_layout_item', $item->module(), $item->modtype());
        $options = array('item_form' => $forms['item_form']);
        return $layout->render($app['twig'], $options, $app['form.factory'], $item);
    }

    public function registerItemAction(Application $app, Request $request, $siteSlug, $moduleSlug)
    {
        $arkMod = Module::get($app['database'], 'ark');
        $ark = $arkMod->item('ark');
        $siteMod = $ark->submodule('ste');
        $site = $siteMod->item($siteSlug);
        if (!$site->isValid()) {
            throw new NotFoundHttpException('Site Code '.$siteSlug.' is not valid.');
        }
        $mod = $app['database']->getModule($moduleSlug);
        $module = $site->submodule($mod['module']);
        if (!$module->isValid()) {
            throw new NotFoundHttpException('Module '.$moduleSlug.' is not valid for Site Code '.$siteSlug);
        }

        $layout = Layout::fetchLayout($app['database'], 'cor_layout_register', $module);

        $fields = $layout->allFields();
        $items = Item::getRecent($app['database'], $module, $site->id(), 5);
        $rows = array();
        foreach ($items as $item) {
            $data = array();
            foreach ($fields as $field) {
                $data = array_merge($data, $field->formData($item, true));
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
        $arkMod = Module::get($app['database'], 'ark');
        $ark = $arkMod->item('ark');
        $siteMod = $ark->submodule('ste');
        $site = $siteMod->item($siteSlug);
        if (!$site->isValid()) {
            throw new NotFoundHttpException('Site Code '.$siteSlug.' is not valid.');
        }
        $mod = $app['database']->getModule($moduleSlug);
        $module = $site->submodule($mod['module']);
        if (!$module->isValid()) {
            throw new NotFoundHttpException('Module '.$moduleSlug.' is not valid for Site Code '.$siteSlug);
        }

        $layout = Layout::fetchLayout($app['database'], 'cor_layout_list', $module);

        $fields = $layout->allFields();
        $items = Item::getAll($app['database'], $module, $site->id());
        $rows = array();
        foreach ($items as $item) {
            $data = array();
            foreach ($fields as $field) {
                $data = array_merge($data, $field->formData($item, true));
            }
            $field = 'conf_field_'.$module->id().'_cd';
            $data[$field] = $item->id();
            $data['item'] = $item->id();
            $data['parent'] = $item->parent();
            $data['idx'] = $item->index();
            $data['modtype'] = $item->modtype();
            $data['item'] = $item->id();
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
