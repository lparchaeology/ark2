<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/AbstractResource.php
*
* ARK Model AbstractResource
*
* PHP version 5 and 7
*
* LICENSE:
*    ARK - The Archaeological Recording Kit.
*    An open-source framework for displaying and working with archaeological data
*    Copyright (C) 2016  L - P : Heritage LLP.
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/AbstractResource.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

abstract class AbstractResource
{
    protected $db = null;
    protected $id = '';
    protected $type = '';
    protected $typeCode = '';
    protected $schemaId = '';
    protected $keyword = '';
    protected $enabled = true;
    protected $deprecated = false;
    protected $valid = false;

    protected function __construct(Database $db, $id)
    {
        $this->db = $db;
        $this->id = $id;
    }

    protected function loadConfig($config)
    {
        if (isset($config['type'])) {
            $this->type = $config['type'];
        }
        if (isset($config['schema_id'])) {
            $this->schemaId = $config['schema_id'];
        }
        if (isset($config['keyword'])) {
            $this->keyword = $config['keyword'];
        }
        if (isset($config['enabled'])) {
            $this->enabled = $config['enabled'];
        }
        if (isset($config['deprecated'])) {
            $this->deprecated = $config['deprecated'];
        }
    }

    public function id()
    {
        return $this->id;
    }

    public function type()
    {
        return $this->type;
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function isDeprecated()
    {
        return $this->deprecated;
    }

    public function keyword()
    {
        return $this->keyword;
    }

    public function data(Item $item, $lang)
    {
        return null;
    }

}
