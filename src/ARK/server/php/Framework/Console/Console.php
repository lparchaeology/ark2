<?php

/**
 * ARK Site Admin Console.
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
 */

namespace ARK\Framework\Console;

use ARK\ARK;
use ARK\Framework\Application;
use ARK\Framework\Console\Command\SiteAboutCommand;

class Console extends AbstractConsole
{
    public function __construct($site)
    {
        parent::__construct('ARK Site Admin Console', new Application($site));

        // Site Commands
        $this->add(new SiteAboutCommand());

        // Add custom commands
        $commands = $this->app['ark']['console']['commands'] ?? [];
        foreach ($commands as $command) {
            $this->add(new $command());
        }
    }
}
