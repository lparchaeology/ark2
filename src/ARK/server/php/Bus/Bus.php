<?php

/**
 * ARK Security
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
 * @php        >=5.6, >=7.0
 */

namespace ARK\Bus;

use ARK\Framework\Application;

class Bus
{
    protected $app = null;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public static function commandBus()
    {
        return $this->app['bus.command'];
    }

    public static function eventBus()
    {
        return $this->app['bus.event'];
    }

    public static function eventRecorder()
    {
        return $this->app['bus.event.recorder'];
    }

    public static function handleCommand($message)
    {
        return $this->commandBus()->handle($message);
    }

    public static function handleEvent($message)
    {
        return $this->eventBus()->handle($message);
    }

    public static function recordEvent($message)
    {
        return $this->eventRecorder()->record($message);
    }
}
