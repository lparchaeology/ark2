<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
* src/php/Model/NumberProperty.php
*
* ARK Model NumberProperty
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
* @see        http://ark.lparchaeology.com/code/src/php/Model/NumberProperty.php
* @since      2.0
*
*/

namespace ARK\Model;

use ARK\Database\Database;

class NumberProperty extends Property
{
    private $minimum = null;
    private $exclusiveMinimum = false;
    private $maximum = null;
    private $exclusiveMaximum = false;
    private $multipleOf = null;

    protected function __construct(Database $db, string $id)
    {
        parent::__construct($db, $id);
    }

    protected function init(array $config)
    {
        parent::init($config);
        $this->minimum = $config['minimum'];
        $this->exclusiveMinimum = $config['exclusive_minimum'];
        $this->maximum = $config['maximum'];
        $this->exclusiveMaximum = $config['exclusive_maximum'];
        $this->multipleOf = $config['multiple_of'];
    }

    public function minimum()
    {
        return $this->minimum;
    }

    public function exclusiveMinimum()
    {
        return $this->exclusiveMinimum;
    }

    public function maximum()
    {
        return $this->maximum;
    }

    public function exclusiveMaximum()
    {
        return $this->exclusiveMaximum;
    }

    public function multipleOf()
    {
        return $this->multipleOf;
    }

    public function definition(int $reference = Schema::ReferenceSchema)
    {
        $definition = parent::definition();
        if (!$reference) {
            if ($this->minimum) {
                $definition['minimum'] = $this->minimum;
                $definition['exclusive_minimum'] = $this->exclusiveMinimum;
            }
            if ($this->maximum) {
                $definition['maximum'] = $this->maximum;
                $definition['exclusive_maximum'] = $this->exclusiveMaximum;
            }
            if ($this->multipleOf) {
                $definition['multiple_of'] = $this->multipleOf;
            }
        }
    }

}
