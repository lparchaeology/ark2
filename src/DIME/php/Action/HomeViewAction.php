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

use ARK\Application;
use ARK\Translation\Key;
use ARK\ORM\EntityManager;
use ARK\Service;
use Symfony\Component\HttpFoundation\Request;
use ARK\View\Element;

class HomeViewAction
{
    public function __invoke(Request $request)
    {
        
        $page_config = array(
            "navlinks" => array (
                array(
                    "name" => "dime.home",
                    "target" => "/"
                ),
                array(
                    "name" => "dime.mnd",
                    "target" => "mnd"
                ),
                array(
                    "name" => "dime.research",
                    "target" => "research"
                ),
                array(
                    "name" => "dime.about",
                    "target" => "about"
                ),
                array(
                    "name" => "dime.digiexibit",
                    "target" => "digiexibit"
                ),
                array(
                    "name" => "dime.news",
                    "target" => "news"
                )
            ),
            "sidelinks" => array (
                array(
                    "name" => "add",
                    "active" => true,
                    "links" => array(
                        array(
                            "name" => "dime.addfind",
                            "active" => false,
                            "target" => "finds/add"
                        ),
                        array(
                            "name" => "dime.addlocation",
                            "active" => true,
                            "target" => "locations/add"
                        )
                    )
                ),
                array(
                    "name" => "search",
                    "active" => false,
                    "links" => array(
                        array(
                            "name" => "dime.searchfind",
                            "active" => false,
                            "target" => "finds"
                        ),
                        array(
                            "name" => "dime.searchlocation",
                            "active" => false,
                            "target" => "locations"
                        )
                    ),
                ),
            )
        );
        
        //$layout = new ARK\Layout()
        
        
        $layout = "Column1";
        $contents2 = "Column2";
        
        
        return Service::render('pages/page.html.twig', array( 'page_config' => $page_config, 'contents' => "Column1", 'contents2' => $contents2 ) );
    }
}
