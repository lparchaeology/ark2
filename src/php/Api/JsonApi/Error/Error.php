<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Api/JsonApi/Error/Error.php
*
* JSON:API Error
*
* PHP versions 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Partnership Ltd.
*    This program is free software: you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation, either version 3 of the License, or
*    (at your option) any later version.
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*    You should have received a copy of the GNU General Public License
*    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*
* @package    ark
* @author     John Layt <j.layt@lparchaeology.com>
* @copyright  2016 L - P : Heritage LLP.
* @license    GPL-3.0+
* @see        http://ark.lparchaeology.com/code/src/php/Api/JsonApi/Error/Error.php
* @since      2.0
*/

namespace ARK\Api\JsonApi\Error;

use ARK\Http\StatusCodeTrait;
use JsonSerializable;
use Tobscure\JsonApi\MetaTrait;
use Tobscure\JsonApi\LinksTrait;

class Error implements JsonSerializable
{
    use StatusCodeTrait;
    use MetaTrait;
    use LinksTrait;

    protected $id;
    protected $code;
    protected $title;
    protected $detail;
    protected $source;

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

    public function toArray()
    {
        return array_filter([
            'id' => $this->id(),
            'links' => $this->getLinks(),
            'status' => (string)$this->statusCode(),
            'code' => $this->code(),
            'title' => $this->title(),
            'detail' => $this->detail(),
            'source' => $this->source(),
            'meta' => $this->getMeta(),
        ]);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
