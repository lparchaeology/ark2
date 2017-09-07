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
use ARK\Error\ErrorException;
use ARK\Http\Error\NotFoundError;
use ARK\ORM\ORM;
use ARK\Service;
use DIME\DIME;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageViewController extends DimeFormController
{
    public function __invoke(Request $request)
    {
        $page = $request->attributes->get('_route');
        if (!$item = ORM::find(Page::class, $page)) {
            throw new ErrorException(new NotFoundError('PAGE_NOT_FOUND', 'Page not found', "Page $page not found"));
        }

        if ($request->getMethod() === 'POST') {
            $value = $item->property('content')->value();
            $value->setContent($request->getContent());
            $item->property('content')->setValue($value);
            ORM::flush('data');
            return new Response('', 203);
        }

        $value = $item->property('content')->value();
        $content = '';

        // TODO Use visibility / permissions
        if (Service::security()->isGranted('ROLE_ADMIN')) {
            $content .= '<button id="pageedit" type="button" class="btn btn-default" data-toggle="button" aria-pressed="false" autocomplete="off">Edit</button>';
            $content .= '<div class="inlineedit">';
            $content .= $value->content();
            $content .= '</div>';
        } else {
            $content .= $value->content();
        }

        $state = $this->buildState($request, $item);

        $options['content'][0] = $content;
        $options['state'] = $state;

        return Service::view()->renderResponse('pages/page.html.twig', $options);
    }
}
