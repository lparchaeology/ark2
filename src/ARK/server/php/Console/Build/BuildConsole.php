<?php

/**
 * ARK Build Console
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

namespace ARK\Console\Build;

use ARK\ARK;
use ARK\Console\Console;
use ARK\Console\SystemApplication;
use ARK\Console\Build\Command\BuildInstallCommand;
use ARK\Console\Build\Command\BuildUpdateCommand;
use ARK\Console\Build\Command\BuildFrontendCommand;
use ARK\Console\Build\Command\BuildFrontendCreateCommand;
use ARK\Console\Build\Command\BuildFrontendCssCommand;
use ARK\Console\Build\Command\BuildFrontendJsCommand;
use ARK\Console\Build\Command\BuildFrontendTwigCommand;
use ARK\Database\Console\DatabaseReverseCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;

class BuildConsole extends Console
{
    public function __construct()
    {
        parent::__construct('ARK Build Console');

        // Build Environment Commands
        $this->add(new BuildInstallCommand());
        $this->add(new BuildUpdateCommand());

        // Build Commands
        $this->add(new BuildFrontendCommand());
        $this->add(new BuildFrontendCreateCommand());
        $this->add(new BuildFrontendCssCommand());
        $this->add(new BuildFrontendJsCommand());
        $this->add(new BuildFrontendTwigCommand());

        // Database Commands
        $this->add(new DatabaseReverseCommand());

        // Doctrine DBAL Helper
        //$this->getHelperSet()->set(new ConnectionHelper($this->app['db']), 'db');

        // Doctrine Migrations Commands
        $this->add(new DiffCommand());
        $this->add(new GenerateCommand());
    }
}
