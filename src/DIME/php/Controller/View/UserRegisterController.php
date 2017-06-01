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

namespace DIME\Controller\View;

use ARK\Error\ErrorException;
use ARK\Http\Error\NotFoundError;
use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Page;
use ARK\Actor\Actor;
use ARK\Actor\Person;
use ARK\Model\Module;
use ARK\Model\Schema;
use DIME\DIME;
use DIME\Controller\View\DimeFormController;
use Symfony\Component\HttpFoundation\Request;

class UserRegisterController extends DimeFormController
{
    public function __invoke(Request $request)
    {
        return $this->handleRequest($request, 'core_page_user_register');
    }

    public function buildData(Request $request, Page $page)
    {
        $data[$page->content()->name()] = new Person;
        dump($data[$page->content()->name()]->property('license'));
        return $data;
    }

    public function processForm(Request $request, $form, $redirect)
    {
        $data = $form->getData();
        $item = $data[$form->getName()];
        return Service::redirectPath($redirect);
    }
}