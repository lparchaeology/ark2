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
 * @copyright  2017 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework\Console;

use ARK\Database\Console\DatabaseCloneCommand;
use ARK\Database\Console\DatabaseServerAddCommand;
use ARK\Framework\Console\Command\CacheClearCommand;
use ARK\Framework\Console\Command\SiteCreateCommand;
use ARK\Framework\Console\Command\SiteFrontendCommand;
use ARK\Framework\Console\Command\SiteMigrateInfoCommand;
use ARK\Framework\Console\Command\SiteMigrateLoadCommand;
use ARK\Framework\Console\Command\SiteMigrateMapCommand;
use ARK\Framework\Console\Command\SystemAboutCommand;
use ARK\Framework\SystemApplication;

class SystemConsole extends AbstractConsole
{
    public function __construct()
    {
        parent::__construct('ARK System Admin Console', new SystemApplication());

        // Database Commands
        $this->add(new DatabaseServerAddCommand());
        $this->add(new DatabaseCloneCommand());

        // Site Commands
        $this->add(new SiteCreateCommand());
        $this->add(new SiteFrontendCommand());
        $this->add(new SiteMigrateInfoCommand());
        $this->add(new SiteMigrateMapCommand());
        $this->add(new SiteMigrateLoadCommand());

        // System Commands
        $this->add(new SystemAboutCommand());
        $this->add(new CacheClearCommand());
    }
}
