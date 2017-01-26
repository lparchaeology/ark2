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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace DIME\Action;

use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Layout;
use Symfony\Component\HttpFoundation\Request;

class EntityAddAction
{
    public function render(Request $request, $class, $schema, $layout, $redirect, $options = [], $template = 'pages/page.html.twig')
    {
        $layout = ORM::find(Layout::class, $layout);
        $data = new $class($schema);
        $form = $layout->buildForm($data);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();
            ORM::persist($item);
            ORM::flush('data');
            $path = Service::path($redirect, ['itemSlug' => $item->id()]);
            return Service::redirect($path);
        }
        $options['layout'] = $layout;
        $options['forms'][$layout->name()] = $form->createView();
        $options['data'] = $data;
        $options['page_config'] = [
            "navlinks" => [
                ["name" => "dime.home", "dropdown" => false, "target" => "home"],
                ["name" => "dime.treasure", "dropdown" => false, "target" => "treasure"],
                ["name" => "dime.research", "dropdown" => false, "target" => "research"],
                ["name" => "dime.about", "dropdown" => false, "target" => "about"],
                ["name" => "dime.background", "dropdown" => false, "target" => "background"],
            ],
            "sidelinks" => [
                [
                    "name" => "add",
                    "active" => false,
                    "role" => "IS_AUTHENTICATED_ANONYMOUSLY",
                    "links" => [
                        ["name" => "dime.find.add", "active" => false, "target" => "finds.add"],
                        ["name" => "dime.locality.add", "active" => false, "target" => "localities.add"],
                    ],
                ],
                [
                    "name" => "search",
                    "active" => false,
                    "role" => "IS_AUTHENTICATED_ANONYMOUSLY",
                    "links" => [
                        ["name" => "dime.find.search", "active" => false, "target" => "finds.list"],
                        ["name" => "dime.locality.search", "active" => false, "target" => "localities.list"],
                    ],
                ],
            ]
        ];
        return Service::render($template, $options);
    }
}
