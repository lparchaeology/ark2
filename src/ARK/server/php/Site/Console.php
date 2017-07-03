<?php

/**
 * ARK Site Admin Console
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

namespace ARK\Site;

use ARK\ARK;
use ARK\Console\AbstractConsole;
use ARK\Framework\Application;
use ARK\ORM\Console\GenerateItemEntityCommand;
use ARK\Translation\Console\TranslationAddCommand;
use ARK\Translation\Console\TranslationDimeCommand;
use ARK\View\Console\NavAddCommand;
use ARK\Routing\Console\RouteDumpCommand;
use Doctrine\DBAL\Tools\Console\Command\ImportCommand;
use Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
use Security\Command\UserCreateCommand;
use Security\Command\UserDeleteCommand;
use Security\Command\UserListCommand;
use Security\Command\UserRoleAddCommand;
use Security\Command\UserRoleListCommand;
use Security\Command\UserRoleRemoveCommand;

class Console extends AbstractConsole
{
    public function __construct($site)
    {
        parent::__construct('ARK Site Admin Console', new Application($site));

        // Route Commands
        $this->add(new RouteDumpCommand);

        // Translation Commands
        $this->add(new TranslationAddCommand());
        $this->add(new TranslationDimeCommand());

        // User Commands
        //$this->add(new UserCreateCommand($this->app));
        //$this->add(new UserListCommand($this->app));
        //$this->add(new UserDeleteCommand($this->app));
        //$this->add(new UserRoleAddCommand($this->app));
        //$this->add(new UserRoleListCommand($this->app));
        //$this->add(new UserRoleRemoveCommand($this->app));

        // View Commands
        $this->add(new NavAddCommand);

        // Doctrine DBAL Commands
        $this->add(new ImportCommand());
        $this->add(new RunSqlCommand());

        // Doctrine DBAL Helper
        // TODO Make configurable??? Move to commands?
        $this->getHelperSet()->set(new ConnectionHelper($this->app['db']), 'db');

        // Doctrine Migrations Commands, just the ones needed for production
        $this->add(new ExecuteCommand());
        $this->add(new MigrateCommand());
        $this->add(new StatusCommand());
        $this->add(new VersionCommand());

        // ORM Commands
        $this->add(new GenerateItemEntityCommand());
    }
}
