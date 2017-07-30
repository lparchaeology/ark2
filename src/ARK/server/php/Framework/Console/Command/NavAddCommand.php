<?php

/**
 * ARK Nav Add Command.
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
 */

namespace ARK\Framework\Console\Command;

use ARK\Service;
use ARK\View\Bus\NavAddMessage;

class NavAddCommand extends AbstractCommand
{
    protected function configure() : void
    {
        $this->setName('view:nav:add')
            ->setDescription('Add a new Nav view element')
            ->addOptionalArgument('element', 'The Nav view element key');
    }

    protected function doExecute() : void
    {
        $element = $this->getArgument('element');
        if (!$element) {
            $element = $this->askQuestion("Please enter the new Nav view element key (e.g. 'site_nav_home')");
        }
        $element = strtolower($element);

        $parent = $this->askQuestion("Please enter the parent Nav view element key (e.g. 'site_nav_home', default none)");

        $seq = $this->askQuestion('Please enter the sequence number (e.g. 3)', 0);

        $separator = false;
        $route = null;
        $uri = null;
        $type = $this->askChoice('Please choose the Nav type (Default: route)', ['route', 'uri', 'separator', 'root'], 'route');
        if ($type === 'route') {
            $route = $this->askQuestion("Please enter the route (e.g. 'site.home')");
        } elseif ($type === 'uri') {
            $uri = $this->askQuestion("Please enter the URI (e.g. 'http://www.example.com/here')");
        } elseif ($type === 'separator') {
            $separator = true;
        }

        $icon = $this->askQuestion("Please enter the icon key (e.g. 'home.png', default none)");

        Service::bus()->handleCommand(new NavAddMessage($element, $parent, $seq, $separator, $route, $uri, $icon));
    }
}
