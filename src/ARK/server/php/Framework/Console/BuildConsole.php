<?php

/**
 * ARK Build Console.
 *
 * Copyright (C) 2018  L - P : Heritage LLP.
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
 * @copyright  2018 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework\Console;

use ARK\ARK;
use ARK\Database\Console\Command\DatabaseReverseCommand;
use ARK\Framework\Console\Command\BuildFrontendAssetsCommand;
use ARK\Framework\Console\Command\BuildFrontendBaseCommand;
use ARK\Framework\Console\Command\BuildFrontendCommand;
use ARK\Framework\Console\Command\BuildFrontendCreateCommand;
use ARK\Framework\Console\Command\BuildFrontendScriptsCommand;
use ARK\Framework\Console\Command\BuildFrontendStylesCommand;
use ARK\Framework\Console\Command\BuildFrontendTemplatesCommand;
use ARK\Framework\Console\Command\BuildStatusCommand;
use ARK\Framework\Console\Command\BuildUpdateCommand;
use ARK\Framework\SystemApplication;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;

class BuildConsole extends AbstractConsole
{
    public function __construct()
    {
        parent::__construct('ARK Build Console', new SystemApplication());

        // Build Environment Commands
        $this->add(new BuildStatusCommand());
        $this->add(new BuildUpdateCommand());

        // Build Commands
        $this->add(new BuildFrontendCommand());
        $this->add(new BuildFrontendCreateCommand());
        $this->add(new BuildFrontendAssetsCommand());
        $this->add(new BuildFrontendBaseCommand());
        $this->add(new BuildFrontendScriptsCommand());
        $this->add(new BuildFrontendStylesCommand());
        $this->add(new BuildFrontendTemplatesCommand());

        // Database Commands
        $this->add(new DatabaseReverseCommand());

        // Doctrine Migrations Commands
        //$this->add(new DiffCommand());
        //$this->add(new GenerateCommand());
    }
}
