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

use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use DIME\DIME;
use DIME\Controller\DimeController;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class HomePageController extends DimeController
{
    public function __invoke(Request $request)
    {
        $page = ORM::find(Page::class, 'dime_page_home');

        $options = $this->defaultOptions();
        $options['page'] = $page;
        $options['layout'] = $page->content();

        // Find 9 most recent finds for current actor
        $finds = ORM::findAll(Find::class);
        $data[$page->content()->name()] = $finds;
        $data['dime_find_list'] = $finds;

        $data['notifications'] = DIME::getUnreadNotifications();

        $data['dime_find_map'] = (Service::isGranted('ROLE_USER') ? $finds : []);
        $data['kortforsyningenticket'] = DIME::getMapTicket();

        $data['dime_home_action'] = null;

        $options['data'] = $data;
        return Service::renderResponse($page->template(), $options);
    }
}
