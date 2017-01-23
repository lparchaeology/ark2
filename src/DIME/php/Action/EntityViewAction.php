<?php

/**
 * DIME Action
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

namespace DIME\Action;

use ARK\Error\ErrorException;
use ARK\Http\Error\NotFoundError;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Layout;
use Symfony\Component\HttpFoundation\Request;

class EntityViewAction
{
    public function render(Request $request, $itemSlug, $class, $layout, $options = [], $template = 'pages/page.html.twig')
    {
        if (!$item = ORM::find($class, $itemSlug)) {
            throw new ErrorException(new NotFoundError('ITEM_NOT_FOUND', 'Item not found', "Item $itemSlug not found"));
        }

        $viewLayout = ORM::find(Layout::class, $layout);
        $form = $viewLayout->buildForm($item);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            ORM::persist($item);
            ORM::flush('data');
            $path = Service::path('finds.view', ['findSlug' => $item->id()]);
            return Service::redirect($path);
        }

        $options['layout'] = $viewLayout;
        $options['forms'][$viewLayout->name()] = $form->createView();
        $options['data'] = $item;
        return Service::render($template, $options);
    }
}
