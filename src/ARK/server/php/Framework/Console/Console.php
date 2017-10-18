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
use ARK\Database\Console\Command\DatabaseDropCommand;
use ARK\Database\Console\Command\DatabaseImportCommand;
use ARK\Database\Console\Command\DatabaseTruncateCommand;
use ARK\Framework\Application;
use ARK\Framework\Console\Command\CacheClearCommand;
use ARK\Framework\Console\Command\NavAddCommand;
use ARK\Framework\Console\Command\RouteDumpCommand;
use ARK\Framework\Console\Command\SiteAboutCommand;
use ARK\ORM\Console\Command\GenerateItemEntityCommand;
use ARK\Security\Console\Command\UserCreateCommand;
use ARK\Security\Console\Command\UserDeleteCommand;
use ARK\Security\Console\Command\UserDisableCommand;
use ARK\Security\Console\Command\UserEnableCommand;
use ARK\Security\Console\Command\UserListCommand;
use ARK\Security\Console\Command\UserPasswordResetCommand;
use ARK\Security\Console\Command\UserPasswordSetCommand;
use ARK\Security\Console\Command\UserRoleAddCommand;
use ARK\Security\Console\Command\UserRoleDeleteCommand;
use ARK\Security\Console\Command\UserVerifyCommand;
use ARK\Translation\Console\Command\TranslationAddCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;

class Console extends AbstractConsole
{
    public function __construct($site)
    {
        parent::__construct('ARK Site Admin Console', new Application($site));

        // System Commands
        $this->add(new SiteAboutCommand());
        $this->add(new CacheClearCommand());
        $this->add(new RouteDumpCommand());

        // Translation Commands
        $this->add(new TranslationAddCommand());

        // User Commands
        $this->add(new UserCreateCommand());
        $this->add(new UserDeleteCommand());
        $this->add(new UserDisableCommand());
        $this->add(new UserEnableCommand());
        $this->add(new UserListCommand());
        $this->add(new UserPasswordSetCommand());
        $this->add(new UserPasswordResetCommand());
        $this->add(new UserRoleAddCommand());
        $this->add(new UserRoleDeleteCommand());
        $this->add(new UserVerifyCommand());

        // View Commands
        //$this->add(new NavAddCommand());

        // Database Commands
        $this->add(new DatabaseDropCommand());
        $this->add(new DatabaseImportCommand());
        $this->add(new DatabaseTruncateCommand());

        // ORM Commands
        $this->add(new GenerateItemEntityCommand());

        // Doctrine Migrations Commands, just the ones needed for production
        //$this->getHelperSet()->set(new ConnectionHelper($this->app['db']), 'db');
        //$this->add(new ExecuteCommand());
        //$this->add(new MigrateCommand());
        //$this->add(new StatusCommand());
        //$this->add(new VersionCommand());

        // Add custom commands
        $commands = $this->app['ark']['console']['commands'] ?? [];
        foreach ($commands as $command) {
            $this->add(new $command());
        }
    }
}
