<?php

/**
 * ARK Translation Add Command
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

namespace ARK\View\Bus;

use ARK\ORM\ORM;
use ARK\Service;
use ARK\View\Command\NavAddMessage;
use ARK\View\Nav;

class NavAddHandler
{
    public function __invoke(NavAddMessage $msg)
    {
        // Validate / Defaults
        if ($nav = ORM::find(Nav::class, $msg->nav())) {
            // TODO Proper error
            throw new \Exception;
        }
        $parent = $msg->parent();
        if ($parent) {
            $parent = ORM::find(Nav::class, $msg->parent());
            if (!$parent) {
                // TODO Proper error
                throw new \Exception;
            }
        }
        if ($msg->route()) {
            // TODO Route object
        }

        // Create
        $nav = Nav::fromMessage($msg);
        ORM::persist($nav);
        ORM::flush($nav);
    }
}
