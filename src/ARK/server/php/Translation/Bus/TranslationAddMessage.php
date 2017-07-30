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

    public function __construct(
        string $keyword,
        string $domain,
        string $role,
        string $language,
        string $text,
        string $notes = '',
        bool $plural = false,
        iterable $parameters = []
    ) {
        $this->keyword = $keyword;
        $this->domain = $domain;
        $this->role = $role;
        $this->language = $language;
        $this->text = $text;
        $this->notes = $notes;
        $this->plural = $plural;
        $this->parameters = $parameters;
    }

    public function keyword() : string
    {
        return $this->keyword;
    }

    public function domain() : string
    {
        return $this->domain;
    }

    public function role() : string
    {
        return $this->role;
    }

    public function language() : string
    {
        return $this->language;
    }

    public function text() : string
    {
        return $this->text;
    }

    public function notes() : string
    {
        return $this->notes;
    }

    public function plural() : bool
    {
        return $this->plural;
    }

    public function parameters() : iterable
    {
        return $this->parameters;
    }
}
