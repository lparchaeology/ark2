<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Schema/StringProperty.php
*
* ARK Schema StringProperty
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
* @see        http://ark.lparchaeology.com/code/src/php/Schema/StringProperty.php
* @since      2.0
*
*/

namespace ARK\Schema;

use ARK\Database\Database;

class StringProperty extends Property
{
    private $_pattern = '';
    private $_minLength = 0;
    private $_maxLength = 0;
    private $_size = 0;
    private $_spellcheck = false;

    protected function _loadConfig(Database $db, $config)
    {
        parent::_loadConfig($db, $config);
        $this->_pattern = $config['pattern'];
        $this->_minLength = $config['min_length'];
        $this->_maxLength = $config['max_length'];
        $this->_size = $config['size'];
        $this->_spellcheck = (bool)$config['spellcheck'];
    }

    public function pattern()
    {
        return $this->_pattern;
    }

    public function minLength()
    {
        return $this->_minLength;
    }

    public function maxLength()
    {
        return $this->_maxLength;
    }

    public function size()
    {
        return $this->_size;
    }

    public function spellcheck()
    {
        return $this->_spellcheck;
    }

    public function toSchema()
    {
        return parent::toSchema();
    }

}
