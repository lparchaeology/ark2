<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Console/AdminConsole.php
*
* An Ark Console for performing admin tasks
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Console/AdminConsole.php
* @since      2.0
*/

namespace ARK\Console;

use rootLogin\UserProvider\Command\UserCreateCommand;
use rootLogin\UserProvider\Command\UserListCommand;
use rootLogin\UserProvider\Command\UserDeleteCommand;
use rootLogin\UserProvider\Command\UserRoleAddCommand;
use rootLogin\UserProvider\Command\UserRoleListCommand;
use rootLogin\UserProvider\Command\UserRoleRemoveCommand;

class AdminConsole extends Console
{
    public function __construct()
    {
        parent::__construct('ARK Admin Console');

        // User Commands
        $this->add(new UserCreateCommand($this->app));
        $this->add(new UserListCommand($this->app));
        $this->add(new UserDeleteCommand($this->app));
        $this->add(new UserRoleAddCommand($this->app));
        $this->add(new UserRoleListCommand($this->app));
        $this->add(new UserRoleRemoveCommand($this->app));

        // Doctrine DBAL Commands
        $this->add(new \Doctrine\DBAL\Tools\Console\Command\ImportCommand());
        $this->add(new \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand());

        // Doctrine DBAL Helper
        $this->getHelperSet()->set(new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($this->app['db']), 'db');

        // Doctrine Migrations Commands, just the ones needed for production
        $this->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand());
        $this->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand());
        $this->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand());
        $this->add(new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand());
    }
}
