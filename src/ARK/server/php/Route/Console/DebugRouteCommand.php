<?php

/**
 * ARK Debug Route Command
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

namespace ARK\Route\Console;

use ARK\Console\AbstractCommand;
use ARK\Service;

class DebugRouteCommand extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('debug:route')
             ->setDescription('Dump configured route(s)')
             ->addOptionalArgument('name', 'A specific route name')
             ->addOption('controller', 'Print out the controller a route is mapped to')
             ->addOption('raw', 'A route name');
    }

    protected function do()
    {
        $route = $this->getArgument('route');

        $parent = $this->askQuestion("Please enter the parent Nav view element key (e.g. 'site_nav_home', default none)");

        $seq = $this->askQuestion("Please enter the sequence number (e.g. 3)", 0);

        $separator = false;
        $route = null;
        $uri = null;
        $type = $this->askChoice("Please choose the Nav type (Default: route)", ['route', 'uri', 'separator'], 'route');
        if ($type == 'route') {
            $route = $this->askQuestion("Please enter the route (e.g. 'site.home')");
        } elseif ($type == 'uri') {
            $uri = $this->askQuestion("Please enter the URI (e.g. 'http://www.example.com/here')");
        } else {
            $separator = true;
        }

        $parent = $this->askQuestion("Please enter the icon key (e.g. 'home.png', default none)");

        Service::handleCommand(new NavAddMessage($element, $parent, $seq, $separator, $route, $uri, $icon));

        return $this->successCode();
    }
}
