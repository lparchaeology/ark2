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

use ARK\Service;

abstract class DimeAction
{
    public function defaultOptions($route = null)
    {
        $options['data'] = null;
        $options['forms'] = null;
        $options['page_config'] = $this->pageConfig($route);
        return $options;
    }

    public function pageConfig($route = null)
    {
        $homeTarget = (Service::isGranted('ROLE_USER') ? 'home' : 'front');
        $config = [
            "navlinks" => [
                ["name" => "dime.home", "dropdown" => false, "target" => $homeTarget],
                ["name" => "dime.treasure", "dropdown" => false, "target" => "treasure"],
                ["name" => "dime.research", "dropdown" => false, "target" => "research"],
                ["name" => "dime.about", "dropdown" => false, "target" => "about"],
                ["name" => "dime.background", "dropdown" => false, "target" => "background"],
            ],
            "sidelinks" => [
                [
                    "name" => "add",
                    "active" => false,
                    "role" => "ROLE_USER",
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
        if ($route) {
            foreach ($config['sidelinks'] as &$section) {
                foreach ($section['links'] as &$link) {
                    if ($link['target'] == $route) {
                        $section['active'] = true;
                        $link['active'] = true;
                    }
                }
            }
        }
        return $config;

        // TODO Full config, restore when have more content, move to View table/class
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
    }
}
