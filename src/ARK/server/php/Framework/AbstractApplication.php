<?php

/**
 * ARK System Application.
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
 * @copyright  2016 L - P : Heritage LLP.
 * @license    GPL-3.0+
 * @see        http://ark.lparchaeology.com/
 * @since      2.0
 */

namespace ARK\Framework;

use ARK\ARK;
use ARK\Framework\Console\Command\CacheClearCommand;
use Silex\Application;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;

abstract class AbstractApplication extends Application
{
    protected static $dbg = false;

    public function __construct()
    {
        mb_internal_encoding('UTF-8');
        parent::__construct();
        $this['console.commands'] = [
            CacheClearCommand::class,
        ];
        $this['console.helpers'] = [];
    }

    abstract public function cacheDir() : string;

    abstract public function logDir() : string;

    public function addCommand(string $command) : void
    {
        $this->extendArray('console.commands', '', $command);
    }

    public function addHelper(string $helper) : void
    {
        $this->extendArray('console.helpers', '', $helper);
    }

    public function addCommands(iterable $commands) : void
    {
        $this['console.commands'] = array_merge($this['console.commands'], $commands);
    }

    public function extendArray(string $id, string $key, $value) : void
    {
        $array = $this[$id] ?? [];
        if ($key) {
            $array[$key] = $value;
        } else {
            $array[] = $value;
        }
        $this[$id] = $array;
    }

    public function setDebugMode(bool $debug) : void
    {
        // Enable the debug mode
        static::$dbg = $this['debug'] = $debug;

        if ($debug) {
            Debug::enable(E_ALL, true);
        } else {
            // TODO Check is production safe, also need a custom Exception Handler to log?
            ErrorHandler::register();
        }
    }

    public static function debug() : bool
    {
        return static::$dbg;
    }
}
