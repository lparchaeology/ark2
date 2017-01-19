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

use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Element;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class FindListAction
{
    public function __invoke(Request $request, $actorSlug = null)
    {
        $page_config = array(
            "navlinks" => array (
                array(
                    "name" => "dime.home",
                    "dropdown" => false,
                    "target" => "home"
                ),
                array(
                    "name" => "dime.detector",
                    "dropdown" => true,
                    "target" => "detector",
                    "navlinks" => array (
                        array(
                            "name" => "dime.metaldetector",
                            "target" => "detector"
                        ),
                        array(
                            "name" => "dime.treasure",
                            "target" => "detector"
                        ),
                    ),
                ),
                array(
                    "name" => "dime.research",
                    "target" => "research",
                    "dropdown" => false,
                ),
                array(
                    "name" => "dime.about",
                    "dropdown" => true,
                    "target" => "about",
                    "navlinks" => array (
                        array(
                            "name" => "dime.about.groups",
                            "target" => "about"
                        ),
                        array(
                            "name" => "dime.about.background",
                            "target" => "about"
                        ),
                        array(
                            "name" => "dime.about.museums",
                            "target" => "about"
                        ),
                        array(
                            "name" => "dime.about.partners",
                            "target" => "about"
                        ),
                        array(
                            "name" => "dime.about.instructions",
                            "target" => "about"
                        ),
                    ),
                ),
                array(
                    "name" => "dime.exhibits",
                    "dropdown" => true,
                    "target" => "exhibits",
                    "navlinks" => array (
                        array(
                            "name" => "dime.exhibits.forests",
                            "target" => "exhibits"
                        ),
                        array(
                            "name" => "dime.exhibits.weapons",
                            "target" => "exhibits"
                        ),
                    ),
                ),
                array(
                    "name" => "dime.news",
                    "dropdown" => false,
                    "target" => "news"
                )
            ),
            "sidelinks" => array (
                array(
                    "name" => "add",
                    "active" => false,
                    "role" => "ROLE_USER",
                    "links" => array(
                        array(
                            "name" => "dime.find.add",
                            "active" => false,
                            "target" => "finds.add"
                        ),
                        array(
                            "name" => "dime.location.add",
                            "active" => false,
                            "target" => "locations.add"
                        )
                    )
                ),
                array(
                    "name" => "search",
                    "active" => true,
                    "role" => "IS_AUTHENTICATED_ANONYMOUSLY",
                    "links" => array(
                        array(
                            "name" => "dime.find.list",
                            "active" => true,
                            "target" => "finds.list"
                        ),
                        array(
                            "name" => "dime.location.list",
                            "active" => false,
                            "target" => "locations.list"
                        )
                    ),
                ),
            )
        );


        $finds = ORM::findAll(Find::class);
        
        $findsTableLayout = ORM::find(Element::class, 'dime_finds_table');

        $content[0] = $findsTableLayout->renderView($finds);
        $content[1] = 'Panel for map of all finds, or selected find summary<br/><br/>';

        return Service::render(
            'pages/page.html.twig',
            [
                'content' => $content,
                'page_config' => $page_config,
            ]
        );
    }
}
