<?php

/**
 * DIME Controller.
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

namespace DIME\Controller\View;

use ARK\Entity\Page;
use ARK\Http\Exception\ItemNotFoundHttpException;
use ARK\ORM\ORM;
use DIME\DIME;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageViewController extends DimePageController
{
    public function buildData(Request $request)
    {
        $route = $request->attributes->get('_route');
        $page = ORM::find(Page::class, $route);
        if (!$page) {
            throw new ItemNotFoundHttpException('Page', $id);
        }
        return $page;
    }

    public function processForm(Request $request, Form $form) : void
    {
        $page = $this->buildData($request);
        $content = $page->property('content')->value();
        $content->setContent($request->getContent());
        $page->property('content')->setValue($content);
        ORM::flush($page);
        //return new Response('', 203);
    }
}
