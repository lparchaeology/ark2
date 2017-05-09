<?php

/**
 * DIME Controller
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
namespace DIME\Controller;

use ARK\Error\ErrorException;
use ARK\Http\Error\NotFoundError;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\Message\Message;
use DIME\Controller\DimeController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageViewController extends DimeController
{

    public function __invoke(Request $request)
    {
        $page = $request->attributes->get('_route');
        if (! $item = ORM::find('ARK\Entity\Page', $page)) {
            throw new ErrorException(new NotFoundError('ITEM_NOT_FOUND', 'Item not found', "Item $page not found"));
        }

        if ($request->getMethod() == 'POST') {
            $value = $item->property('content')->value();
            $value[0]['content'] = $request->getContent();
            $item->property('content')->setValue($value);
            ORM::flush('data');
            return new Response('', 203);
        }

        $options = $this->defaultOptions();
        $value = $item->property('content')->value();
        // TODO Language Switching!!!
        $content = '';

        if (Service::isGranted('ROLE_ADMIN')) {
            $content .= '<button id="pageedit" type="button" class="btn btn-default" data-toggle="button" aria-pressed="false" autocomplete="off">Edit</button>';
            $content .= '<div class="inlineedit">';
        }
        dump($page);
        dump($item);
        dump($item->property('content'));
        dump($value);
        if ($value && $value->content()) {
            $content .= $value->content();
        }
        if (Service::isGranted('ROLE_ADMIN')) {
            $content .= '</div>';
        }

        $items = Service::database()->getUnreadMessages(Service::workflow()->actor()
            ->id());

        $options['notifications'] = ORM::findBy(Message::class, [
            'item' => $items
        ], [
            'created' => 'DESC'
        ]);

        $options['content'][0] = $content;

        return Service::renderResponse('pages/page.html.twig', $options);
    }
}
