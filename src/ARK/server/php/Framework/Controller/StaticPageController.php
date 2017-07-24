<?php

/**
 * ARK Site Controller
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
 */

namespace ARK\Framework\Controller;

use ARK\Error\ErrorException;
use ARK\Http\Error\NotFoundError;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Element;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StaticPageController
{
    public function __invoke(Request $request, $view, $item)
    {
        if (!$view = ORM::find('ARK\View\Page', $page)) {
            throw new ErrorException(new NotFoundError('VIEW_NOT_FOUND', 'View not found', "Page view for $view not found"));
        }
        if (!$item = ORM::find('ARK\Entity\Page', $item)) {
            throw new ErrorException(new NotFoundError('ITEM_NOT_FOUND', 'Item not found', "Item $route not found"));
        }

        if ($request->getMethod() == 'POST') {
            $value = $item->property('content')->value();
            $value[0]['content'] = $request->getContent();
            $item->property('content')->setValue($value);
            ORM::flush('data');
            return new Response('', 203);
        }

        $options['page'] = $page;
        $options['data'] = $item;

        // TODO Use visibility / permissions
        if (Service::security()->isGranted('ROLE_ADMIN')) {
            $content .= '<button id="pageedit" type="button" class="btn btn-default" data-toggle="button" aria-pressed="false" autocomplete="off">Edit</button>';
            $content .= '<div class="inlineedit">';
        }
        if ($value) {
            $content .= $value[0]['content'];
        }
        // TODO Use visibility / permissions
        if (Service::security()->isGranted('ROLE_ADMIN')) {
            $content .= '</div>';
        }

        $page = $view->renderView($options);
        return new Response($page);
    }
}
