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
use ARK\View\Page;
use ARK\Service;
use ARK\Message\Message;
use DIME\Controller\EntityController;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class FindViewController extends EntityController
{

    private $itemSlug = null;

    public function __invoke(Request $request, $itemSlug)
    {
        $this->itemSlug = $itemSlug;
        return $this->renderResponse($request, 'dime_page_find');
    }

    public function buildData(Request $request, Page $page)
    {
        if (! $resource = ORM::find(Find::class, $this->itemSlug)) {
            throw new ErrorException(new NotFoundError('ITEM_NOT_FOUND', 'Find not found', "Find $this->itemSlug not found"));
        }
        $data[$page->content()->name()] = $resource;

        $items = Service::database()->getUnreadMessages('ahavfrue');

        $data['notifications'] = ORM::findBy(Message::class, [
            'item' => $items
        ], [
            'created' => 'DESC'
        ]);

        return $data;
    }
}
