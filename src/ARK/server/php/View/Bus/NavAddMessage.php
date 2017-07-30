<?php

/**
 * ARK Translation Add Command.
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

namespace ARK\View\Bus;

class NavAddMessage
{
    protected $nav = '';
    protected $parent = '';
    protected $seq = 0;
    protected $seperator = false;
    protected $route = '';
    protected $uri = '';
    protected $icon = '';

    public function __construct(
        string $nav,
        string $parent = null,
        int $seq = 0,
        bool $separator = false,
        string $route = null,
        string $uri = null,
        string $icon = null
    ) {
        $this->nav = $nav;
        $this->parent = $parent;
        $this->seq = $seq;
        $this->separator = $separator;
        $this->route = $route;
        $this->uri = $uri;
        $this->icon = $icon;
    }

    public function nav() : string
    {
        return $this->nav;
    }

    public function parent() : string
    {
        return $this->parent;
    }

    public function sequence() : int
    {
        return $this->seq;
    }

    public function separator() : bool
    {
        return $this->separator;
    }

    public function route() : string
    {
        return $this->route;
    }

    public function uri() : string
    {
        return $this->uri;
    }

    public function icon() : string
    {
        return $this->icon;
    }
}
