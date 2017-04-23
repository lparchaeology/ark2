<?php

/**
 * ARK Console
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

namespace ARK\Console;

use ARK\ARK;
use ARK\Console\ProcessTrait;
use Symfony\Component\Console\Application as SymfonyConsole;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractConsole extends SymfonyConsole
{
    use ProcessTrait;

    protected $app = null;

    public function __construct($name, $app)
    {
        parent::__construct($name, ARK::version());
        $this->app = $app;
    }

    public function app($key = null)
    {
        if ($key) {
            return $this->app[$key];
        }
        return $this->app;
    }

    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->app->boot();
        parent::run($input, $output);
    }
}