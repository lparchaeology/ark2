<?php

/**
 * ARK Error
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

namespace ARK\Error;

use ARK\Http\StatusCodeTrait;

class Error
{
    use StatusCodeTrait;

    protected $id = null;
    protected $code = null;
    protected $title = null;
    protected $detail = null;
    protected $source = null;
    protected $variables = [];

    public function __construct(string $code, string $title, string $detail, int $statusCode = null)
    {
        $this->setCode($code);
        $this->setTitle($title);
        $this->setDetail($detail);
        if ($statusCode) {
            $this->setStatusCode($statusCode);
        }
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }

    public function setCode(string $code)
    {
        $this->code = $code;
    }

    public function code()
    {
        return $this->code;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function title()
    {
        return $this->title;
    }

    public function setDetail(string $detail)
    {
        $this->detail = $detail;
    }

    public function detail()
    {
        return $this->detail;
    }

    public function setSource(ErrorSource $source)
    {
        $this->source = $source;
    }

    public function source()
    {
        return $this->source;
    }

    public function setVariable(string $key, $value)
    {
        $this->variables[$key] = $value;
    }

    public function variables()
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
