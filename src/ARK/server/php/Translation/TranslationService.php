<?php

/**
 * ARK Translation Service.
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

namespace ARK\Translation;

use ARK\Framework\Application;
use ARK\Service;
use Symfony\Component\Finder\Finder;

class TranslationService
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function dump() : void
    {
        Translation::dump(Service::siteDir().'/translations');
    }

    public function import(bool $replace = true, callable $chooser) : void
    {
        $finder = new Finder();
        $finder->in(Service::siteDir().'/translations')->name('*.xlf');
        Translation::importFiles($finder, $replace, $chooser);
    }

    public function translator() : Translator
    {
        return $this->app['translator'];
    }

    public function translate($id, $role = null, $parameters = [], $domain = null, $locale = null) : string
    {
        return $this->app['translator']->translate($id, $role, $parameters, $domain, $locale);
    }

    public function translateChoice($id, int $count, $role = null, $parameters = [], $domain = null, $locale = null) : string
    {
        return $this->app['translator']->translateChoice($id, $count, $role, $parameters, $domain, $locale);
    }
}
