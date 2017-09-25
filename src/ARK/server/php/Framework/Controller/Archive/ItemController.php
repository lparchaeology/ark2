<?php

/**
 * ARK Item Controller
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework\Controller;

use ARK\Database\Database;
use ARK\Model\Item\Collection;
use ARK\Model\Item\Item;
use ARK\Model\Module\Module;
use ARK\View\Element;
use Doctrine\DBAL\Connection;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;

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
}
