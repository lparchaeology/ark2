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
use ARK\Error\ErrorException;
use ARK\Http\Error\NotFoundError;
use Symfony\Component\HttpFoundation\Request;

class FindViewAction
{
    public function __invoke(Request $request, $findSlug)
    {
        $find = Service::repository('DIME\\Model\\Find')->find($findSlug);
        if (!$find) {
            throw new ErrorException(new NotFoundError('ITEM_NOT_FOUND', 'Item not found', "Item $findSlug not found"));
        }
        $head = Service::translate('dime.find');
        $html = "
            <div>
                <h3>$head</h3>
        ";
        foreach ($find->attributes() as $property => $value) {
            $html .= $property.'  :  ';
            if (is_array($value)) {
                foreach ($value as $sub) {
                    $html .= $sub.'  ';
                }
                $html .= '<br/><br/>';
            } else {
                $html .= $value.'<br/><br/>';
            }
        }
        $html .= "
            </div>
        ";
        return Service::render(
            'pages/page.html.twig',
            [
                'contents' => 'Panel for details of find process, i.e. finder, location, etc',
                'contents2' => 'Panel for details of find object, i.e. type, dimensions, materials, etc.<br/><br/>'.$html,
                'find' => $find,
            ]
        );
    }
}
