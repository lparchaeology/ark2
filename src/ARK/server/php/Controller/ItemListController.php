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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
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
use ARK\Model\Item\Collection;
use ARK\Model\Item\Item;
use ARK\Model\Module;
use ARK\View\Element;

class ItemController
{
    public function __invoke(Request $request, $siteSlug, $moduleSlug)
    {
        if (!$view = ORM::find('ARK\View\Page', 'core_page_static')) {
            throw new ErrorException(new NotFoundError('VIEW_NOT_FOUND', 'View not found', "Item $route not found"));
        }
        $mod = ORM::find(Module::class, $moduleSlug);
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
