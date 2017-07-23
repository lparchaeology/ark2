<?php

/**
 * ARK System Console.
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
 *
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 * @php        >=5.6, >=7.0
 */

namespace ARK\System;

use ARK\Console\AbstractConsole;
use ARK\Database\Console\DatabaseCloneCommand;
use ARK\Database\Console\DatabaseServerAddCommand;
use ARK\Site\Console\SiteCreateCommand;
use ARK\Site\Console\SiteFrontendCommand;
use ARK\Site\Console\SiteMigrateCommand;
use ARK\Site\Console\SiteMigrateMapCommand;
use ARK\System\Console\SystemAboutCommand;

class Console extends AbstractConsole
{
    public function __construct()
    {
        parent::__construct('ARK System Admin Console', new Application());

        // Database Commands
        $this->add(new DatabaseServerAddCommand());
        $this->add(new DatabaseCloneCommand());

        // Site Commands
        $this->add(new SiteCreateCommand());
        $this->add(new SiteFrontendCommand());
        $this->add(new SiteMigrateCommand());
        $this->add(new SiteMigrateMapCommand());

        // System Commands
        $this->add(new SystemAboutCommand());
    }
}
