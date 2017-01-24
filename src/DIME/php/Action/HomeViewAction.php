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
use Symfony\Component\HttpFoundation\Request;

class HomeViewAction
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
                            "name" => "dime.location.add",
                            "active" => false,
                            "target" => "locations.add"
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
                            "name" => "dime.location.list",
                            "active" => false,
                            "target" => "locations.list"
                        )
                    ),
                ),
            )
        );

        $page_config = [
            "navlinks" => [
                ["name" => "dime.home", "dropdown" => false, "target" => "home"],
                ["name" => "dime.about", "dropdown" => false, "target" => "about"],
                ["name" => "dime.treasure", "dropdown" => false, "target" => "treasure"],
                ["name" => "dime.research", "dropdown" => false, "target" => "research"],
                ["name" => "dime.background", "dropdown" => false, "target" => "background"],
            ],
            "sidelinks" => [
                [
                    "name" => "add",
                    "active" => false,
                    "role" => "IS_AUTHENTICATED_ANONYMOUSLY",
                    "links" => [
                        ["name" => "dime.find.add", "active" => false, "target" => "finds.add"],
                        ["name" => "dime.location.add", "active" => false, "target" => "locations.add"],
                    ],
                ],
                [
                    "name" => "search",
                    "active" => false,
                    "role" => "IS_AUTHENTICATED_ANONYMOUSLY",
                    "links" => [
                        ["name" => "dime.find.list", "active" => false, "target" => "finds.list"],
                        ["name" => "dime.location.list", "active" => false, "target" => "locations.list"],
                    ],
                ],
            ]
        ];

        $lorem = "
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vel mi eu nulla varius molestie. Integer pharetra dolor diam, in interdum diam iaculis a. Etiam nec finibus magna, non pulvinar est. Suspendisse maximus lacus eget mi laoreet, eget mattis est fermentum. Ut elit felis, iaculis non pellentesque ac, accumsan vitae sapien. Aenean blandit maximus ultrices. Morbi mattis iaculis eros nec volutpat. Donec fermentum felis ac purus ultricies, id varius magna ornare. Ut eget nisl non nisi egestas hendrerit ac id ligula. Pellentesque ac arcu quis diam venenatis ultricies in vitae diam.</p>
            <p>Pellentesque porta risus felis, nec pharetra lacus tempus a. Vivamus tristique massa nec mauris maximus, id eleifend sem ultrices. Duis sollicitudin id neque vitae mollis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam rutrum cursus dui quis maximus. Aliquam a mauris viverra, facilisis eros id, suscipit tortor. Pellentesque ut congue orci. Nullam congue urna non leo bibendum, id tempus leo eleifend. Ut nibh leo, placerat a tempus ac, dapibus quis ante. Phasellus aliquam quam sed nisl gravida, sit amet varius eros suscipit. Aliquam elementum luctus vestibulum.</p>
            <p>Vivamus iaculis eleifend metus sit amet vestibulum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In iaculis auctor purus, vel porttitor nibh ultrices sed. Sed lacus tellus, tristique sed ex eget, ultrices sagittis sem. Phasellus aliquet, mauris ut varius pretium, nunc mi vulputate mauris, et ornare dolor arcu at risus. Integer tristique magna sodales est venenatis maximus. Curabitur vitae tempus sem. In hac habitasse platea dictumst. Sed nec tellus sed eros euismod lacinia ut et enim.</p>
        ";
        $marius = "
            <p>Mauris interdum justo vel libero tristique vestibulum. Quisque et iaculis risus. Praesent vel porttitor elit. Donec nec gravida magna, quis ultricies elit. Nam a dictum dolor. In vitae quam facilisis, varius nisl non, commodo tellus. Donec sagittis sed augue eget ultricies. Phasellus iaculis dictum suscipit. Sed congue lectus vel nisi finibus laoreet. Cras id risus eu tellus suscipit suscipit. Praesent et placerat eros. Vestibulum sit amet libero at ex facilisis tristique. Mauris eget tortor porttitor, mattis libero et, ullamcorper odio. Morbi dui tellus, mattis non sem pretium, convallis sodales velit.</p>
            <p>Pellentesque molestie orci sem. Fusce sit amet tellus nulla. Curabitur accumsan tortor id laoreet pretium. Quisque ex lectus, tristique sit amet metus ac, volutpat semper nulla. Ut id commodo odio. Vivamus mattis ligula vitae urna mattis, non ornare nulla aliquet. In auctor, mauris at vestibulum luctus, ipsum nisi accumsan turpis, et dignissim dolor nulla vel ante. Nunc libero urna, tempor nec sem sed, euismod auctor neque. Proin tincidunt pellentesque venenatis. Nulla non magna sollicitudin, condimentum neque non, facilisis quam. Morbi id mattis nibh, nec sodales enim. Sed blandit euismod convallis. Praesent nec lorem eget leo fringilla volutpat. Mauris placerat tellus et augue imperdiet finibus. Sed accumsan nisl ex, at dictum libero dictum quis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.</p>
        ";

        $content[0] = $lorem;
        $content[1] = $marius;
        $content[2] = $lorem;

        return Service::render(
            'pages/page.html.twig',
            [
                'page_config' => $page_config,
                'content' => $content,
            ]
        );
    }
}
