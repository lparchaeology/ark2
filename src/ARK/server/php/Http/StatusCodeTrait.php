<?php

/**
 * ARK HTTP Status Code Trait.
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
 * @php        >=5.6, >=7.0
 */

namespace ARK\Http;

use Symfony\Component\HttpFoundation\Response;

trait StatusCodeTrait
{
    protected $statusCode;

    public function setStatusCode($statusCode) : void
    {
        $this->statusCode = $statusCode;
    }

    public function statusCode()
    {
        return $this->statusCode;
    }

    public function hasValidStatusCode()
    {
        return array_key_exists($this->statusCode, Response::statusTexts);
    }

    public function statusPhrase()
    {
        return array_key_exists($this->statusCode, Response::statusTexts) ? Response::statusTexts[$this->statusCode] : '';
    }
}
