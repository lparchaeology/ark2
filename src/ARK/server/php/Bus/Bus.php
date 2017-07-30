<?php

/**
 * ARK Security.
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
 */

namespace ARK\Bus;

use ARK\Framework\Application;
use SimpleBus\Message\Bus\MessageBus;
use SimpleBus\Message\Recorder\RecordsMessages;

class Bus
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public static function commandBus() : MessageBus
    {
        return $this->app['bus.command'];
    }

    public static function eventBus() : MessageBus
    {
        return $this->app['bus.event'];
    }

    public static function eventRecorder() : RecordsMessages
    {
        return $this->app['bus.event.recorder'];
    }

    public static function handleCommand(object $message) : void
    {
        $this->commandBus()->handle($message);
    }

    public static function handleEvent(object $message) : void
    {
        $this->eventBus()->handle($message);
    }

    public static function recordEvent(object $message) : void
    {
        $this->eventRecorder()->record($message);
    }
}
