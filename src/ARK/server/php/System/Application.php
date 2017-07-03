<?php

/**
 * ARK System Application
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

namespace ARK\System;

use ARK\ARK;
use ARK\Framework\Provider\BusServiceProvider;
use ARK\Framework\Provider\LoggerServiceProvider;
use ARK\Framework\Provider\MailerServiceProvider;
use Psr\Log\LogLevel;
use Silex\Application as SilexApplication;
use Silex\Application\MonologTrait;
use Silex\Application\SwiftmailerTrait;
use Silex\Provider\VarDumperServiceProvider;
use Symfony\Component\Debug\Debug;

class Application extends SilexApplication
{
    use MonologTrait;
    use SwiftmailerTrait;

    public function __construct()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        Debug::enable();

        parent::__construct();

        $this['debug'] = true;

        date_default_timezone_set('UTC');

        $this->register(new LoggerServiceProvider('console'));

        $this->register(new BusServiceProvider);

        $this->register(new MailerServiceProvider());

        $this->register(new VarDumperServiceProvider());
    }
}
