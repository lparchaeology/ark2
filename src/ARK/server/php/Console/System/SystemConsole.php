<?php

/**
 * ARK Admin Console
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

namespace ARK\Console\System;

use ARK\ARK;
use ARK\Console\SystemApplication;
use ARK\Console\System\Command\DatabaseServerAddCommand;
use ARK\Console\System\Command\SiteCreateCommand;
use ARK\Console\System\Command\SiteFrontendCommand;
use Symfony\Component\Console\Application as Console;

class SystemConsole extends Console
{
    protected $app;

    public function __construct()
    {
        parent::__construct('ARK System Admin Console', ARK::version());
        $this->app = new SystemApplication;

        // Database Commands
        $this->add(new DatabaseServerAddCommand());

        // Site Commands
        $this->add(new SiteCreateCommand());
        $this->add(new SiteFrontendCommand());
    }
}
