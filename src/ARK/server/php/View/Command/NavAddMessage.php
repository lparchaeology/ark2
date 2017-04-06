<?php

/**
 * ARK Translation Add Command
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

namespace ARK\View\Command;

class NavAddMessage
{
    protected $nav = null;
    protected $parent = null;
    protected $seq = 0;
    protected $seperator = false;
    protected $route = null;
    protected $uri = null;
    protected $icon = null;

    public function __construct($nav, $parent = null, $seq = 0, $separator = false, $route = null, $uri = null, $icon = null)
    {
        $this->nav = $nav;
        $this->parent = $parent;
        $this->seq = $seq;
        $this->separator = $separator;
        $this->route = $route;
        $this->uri = $uri;
        $this->icon = $icon;
    }

    public function nav()
    {
        return $this->nav;
    }

    public function parent()
    {
        return $this->parent;
    }

    public function sequence()
    {
        return $this->seq;
    }

    public function separator()
    {
        return $this->separator;
    }

    public function route()
    {
        return $this->route;
    }

    public function uri()
    {
        return $this->uri;
    }

    public function icon()
    {
        return $this->icon;
    }
}
