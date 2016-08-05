<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Console/BuildConsole.php
*
* An Ark Console for performing build tasks
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
* @see        http://ark.lparchaeology.com/code/src/php/Console/BuildConsole.php
* @since      2.0
*/

namespace ARK\Console;

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use ARK\Console\Command\BuildInstallCommand;
use ARK\Console\Command\BuildUpdateCommand;
use ARK\Console\Command\ThemeBuildCommand;
use ARK\Console\Command\ThemeCreateCommand;
use ARK\Console\Command\ThemeCssCommand;
use ARK\Console\Command\ThemeFontsCommand;
use ARK\Console\Command\ThemeImageCommand;
use ARK\Console\Command\ThemeJsCommand;
use ARK\Console\Command\ThemeTwigCommand;
use ARK\Database\Command\ReverseCommand;

class BuildConsole extends Console
{
    public function __construct()
    {
        parent::__construct('ARK Build Console');

        // Build Environment Commands
        $this->add(new BuildInstallCommand());
        $this->add(new BuildUpdateCommand());

        // Theme Commands
        $this->add(new ThemeBuildCommand());
        $this->add(new ThemeCreateCommand());
        $this->add(new ThemeCssCommand());
        $this->add(new ThemeFontsCommand());
        $this->add(new ThemeImageCommand());
        $this->add(new ThemeJsCommand());
        $this->add(new ThemeTwigCommand());

        // Database Commands
        $this->add(new ReverseCommand());

        // Doctrine DBAL Helper
        $this->getHelperSet()->set(new ConnectionHelper($this->app['db']), 'db');

        // Doctrine Migrations Commands
        $this->add(new DiffCommand());
        $this->add(new GenerateCommand());
    }
}
