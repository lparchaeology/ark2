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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace DIME\Action;

use ARK\Service;
use ARK\ORM\ORM;
use DIME\Entity\Location;
use Symfony\Component\HttpFoundation\Request;

class LocationListAction
{
    public function __invoke(Request $request, $actorSlug = null)
    {
        $locations = ORM::findAll(Location::class);

        $list = "<h3>dime.locations</h3>";
        foreach ($locations as $location) {
            $id = $location->id();
            $type = $location->subtype() ? $type = $location->subtype()->keyword() : 'none';
            $name = $location->name();
            $list .= "<p><a href=\"locations/$id\">$id</a> : $type : $name</p>";
        }

        $content[0] = $list;
        $content[1] = 'Panel for map of all locations, or selected find summary<br/><br/>';

        return Service::render(
            'pages/page.html.twig',
            [
                'content' => $content,
                'items' => $locations,
            ]
        );
    }
}
