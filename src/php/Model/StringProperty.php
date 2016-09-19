<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/StringProperty.php
*
* ARK Model StringProperty
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/StringProperty.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

class StringProperty extends Property
{
    private $pattern = '';
    private $minLength = 0;
    private $maxLength = 0;
    private $size = 0;
    private $spellcheck = false;

    protected function __construct(Database $db, string $id)
    {
        parent::__construct($db, $id);
    }

    protected function loadConfig(array $config)
    {
        parent::loadConfig($config);
        $this->pattern = $config['pattern'];
        $this->minLength = $config['min_length'];
        $this->maxLength = $config['max_length'];
        $this->size = $config['size'];
        $this->spellcheck = (bool)$config['spellcheck'];
    }

    public function pattern()
    {
        return $this->pattern;
    }

    public function minLength()
    {
        return $this->minLength;
    }

    public function maxLength()
    {
        return $this->maxLength;
    }

    public function size()
    {
        return $this->size;
    }

    public function spellcheck()
    {
        return $this->spellcheck;
    }

    public function definition(int $reference = Schema::ReferenceSchema)
    {
        $definition = parent::definition($reference);
        if (!$reference) {
            if ($this->minLength > 0) {
                $definition['min_length'] = $this->minLength;
            }
            if ($this->maxLength > 0) {
                $definition['max_length'] = $this->maxLength;
            }
            if ($this->pattern) {
                $definition['pattern'] = $this->pattern;
            }
            if ($this->format && $this->format != 'text') {
                $definition['format'] = $this->format;
            }
        }
        return $definition;
    }

}
