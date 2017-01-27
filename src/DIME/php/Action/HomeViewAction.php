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
use ARK\Vocabulary\Vocabulary;
use DIME\Action\DimeFormAction;
use DIME\Entity\Find;
use Symfony\Component\HttpFoundation\Request;

class HomeViewAction extends DimeAction
{
    public function __invoke(Request $request)
    {
        $page_config = array(
            "navlinks" => array(
                array(
                    "name" => "dime.home",
                    "dropdown" => false,
                    "target" => "home"
                ),
                array(
                    "name" => "dime.detector",
                    "dropdown" => true,
                    "target" => "detector",
                    "navlinks" => array(
                        array(
                            "name" => "dime.metaldetector",
                            "target" => "detector"
                        ),
                        array(
                            "name" => "dime.treasure",
                            "target" => "treasure"
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
                    "navlinks" => array(
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
                    "navlinks" => array(
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
            "sidelinks" => array(
                array(
                    "name" => "add",
                    "active" => true,
                    "role" => "ROLE_USER",
                    "links" => array(
                        array(
                            "name" => "dime.find.add",
                            "active" => true,
                            "target" => "finds.add"
                        ),
                        array(
                            "name" => "dime.locality.add",
                            "active" => false,
                            "target" => "localities.add"
                        )
                    )
                ),
                array(
                    "name" => "search",
                    "active" => false,
                    "role" => "IS_AUTHENTICATED_ANONYMOUSLY",
                    "links" => array(
                        array(
                            "name" => "dime.find.list",
                            "active" => false,
                            "target" => "finds.list"
                        ),
                        array(
                            "name" => "dime.locality.list",
                            "active" => false,
                            "target" => "localities.list"
                        )
                    ),
                ),
            )
        );

        
        $data['dime_find_home'] = ORM::findAll(Find::class);
        
        $layout =  ORM::find(Layout::class, 'dime_find_home');
        
        $maplayout = ORM::find(Layout::class, 'dime_find_map');
        
        return Service::render(
            'pages/page.html.twig',
            [
                'forms' => NULL,
                'page_config' => $this->pageConfig(),
                'layout' => $layout,
                'data' => $data,
                'maplayout' => $maplayout
            ]
        );
    }
}
