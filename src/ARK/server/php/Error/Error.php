<?php

/**
 * ARK Error.
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

namespace ARK\Error;

use ARK\Http\StatusCodeTrait;

class Error
{
    use StatusCodeTrait;

    protected $id = '';
    protected $code = '';
    protected $title = '';
    protected $detail = '';
    protected $source;
    protected $variables = [];

    public function __construct(string $code, string $title, string $detail, int $statusCode = null)
    {
        $this->setCode($code);
        $this->setTitle($title);
        $this->setDetail($detail);
        if ($statusCode !== null) {
            $this->setStatusCode($statusCode);
        }
    }

    public function setId(string $id) : void
    {
        $this->id = $id;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function setCode(string $code) : void
    {
        $this->code = $code;
    }

    public function code() : string
    {
        return $this->code;
    }

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function setDetail(string $detail) : void
    {
        $this->detail = $detail;
    }

    public function detail() : string
    {
        return $this->detail;
    }

    public function setSource(ErrorSource $source) : void
    {
        $this->source = $source;
    }

    public function source() : ErrorSource
    {
        return $this->source;
    }

    public function setVariable(string $key, $value) : void
    {
        $this->variables[$key] = $value;
    }

    public function variables() : iterable
    {
        return $this->variables;
    }

    public function variable(string $key)
    {
        if (isset($this->variables[$key])) {
            return $this->variables[$key];
        }
        return null;
    }
}
