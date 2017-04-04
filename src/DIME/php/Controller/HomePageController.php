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
use DIME\Controller\DimeController;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;
use ARK\Application;

class HomePageController extends DimeController
{
    public function __invoke(Request $request)
    {
        $layout = 'dime_home_page';
        $options = $this->defaultOptions();
        $options['layout'] = Service::layout($layout);
        $data[$layout] = ORM::findAll(Find::class);
        $data['dime_find_list'] = $data[$layout];
        $data['dime_find_map'] = (Service::isGranted('ROLE_USER') ? $data[$layout] : []);
        $data['dime_home_action'] = null;
        $kortforsyningenticket = false;
        $passPath = Service::configDir().'/credentials.json';
        if ($passwords = json_decode(file_get_contents($passPath), true) && isset($passwords['kortforsyningen'])) {
            $user = $passwords['kortforsyningen']['user'];
            $password = $passwords['kortforsyningen']['password'];
            $kortforsyningenticket = file_get_contents("http://services.kortforsyningen.dk/service?request=GetTicket&login=$user&password=$password");
        }
        if (strlen($kortforsyningenticket) == 32) {
            $data['kortforsyningenticket'] = $kortforsyningenticket;
        } else {
            $data['kortforsyningenticket'] = false;
        }
        $options['data'] = $data;
        return Service::renderResponse('pages/page.html.twig', $options);
    }
}
