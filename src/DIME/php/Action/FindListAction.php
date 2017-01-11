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
use Symfony\Component\HttpFoundation\Request;

class FindListAction
{
    public function __invoke(Request $request, $actorSlug = null)
    {
        $finds = Service::repository('DIME\\Entity\\Find')->findAll();
        $head = Service::translate('dime.finds.list');
        $id = Service::translate('dime.find');
        $type = Service::translate('dime.find.type');
        $name = Service::translate('dime.find.name');
        $table = "
            <div>
                <h3>$head</h3>
                <table id=\"dime.finds.table\" class=\"table table-striped table-bordered table-hover\">
                    <thead><tr>
                        <th>$id</th>
                        <th>$type</th>
                        <th>$name</th>
                        </tr>
                    </thead>
                    <tbody>
        ";
        foreach ($finds as $find) {
            $id = $find->id();
            $type = $find->subtype()->keyword();
            $name = $find->name();
            $table .= "               <tr>";
            $table .= "                   <td><a href=\"finds/$id\">$id</td>";
            $table .= "                   <td>$type</td>";
            $table .= "                   <td>$name</td>";
            $table .= "               </tr>";
        }
        $table .= "
                    </tbody>
                </table>
            </div>
        ";
        return Service::render(
            'pages/page.html.twig',
            [
                'contents' => 'Panel for list/thumbnails of finds<br/><br/>'.$table,
                'contents2' => 'Panel for map of all finds, or selected find summary<br/><br/>',
                'finds' => $finds,
            ]
        );
    }
}
