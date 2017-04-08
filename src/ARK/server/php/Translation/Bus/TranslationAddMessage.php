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

namespace ARK\Translation\Bus;

class TranslationAddMessage
{
    protected $keyword = '';
    protected $domain = '';
    protected $role = '';
    protected $language = '';
    protected $text = '';
    protected $notes = '';
    protected $plural = false;
    protected $parameters = [];

    public function __construct($keyword, $domain, $role, $language, $text, $notes = '', $plural = false, array $parameters = [])
    {
        $this->keyword = $keyword;
        $this->domain = $domain;
        $this->role = $role;
        $this->language = $language;
        $this->text = $text;
        $this->notes = $notes;
        $this->plural = $plural;
        $this->parameters = $parameters;
    }

    public function keyword()
    {
        return $this->keyword;
    }

    public function domain()
    {
        return $this->domain;
    }

    public function role()
    {
        return $this->role;
    }

    public function language()
    {
        return $this->language;
    }

    public function text()
    {
        return $this->text;
    }

    public function notes()
    {
        return $this->notes;
    }

    public function plural()
    {
        return $this->plural;
    }

    public function parameters()
    {
        return $this->parameters;
    }
}
