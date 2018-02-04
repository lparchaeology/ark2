<?php

/**
 * ARK ORM Entity Manager.
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

namespace ARK\Utility;

use ReflectionClass;

trait ReflectionTrait
{
    private $reflectClass;
    private $reflectProperty = [];

    public function reflectClass() : ReflectionClass
    {
        if ($this->reflectClass === null) {
            $this->reflectClass = new ReflectionClass(get_parent_class($this));
        }
        return $this->reflectClass;
    }

    public function reflectProperty(string $property)
    {
        if (!isset($this->reflectProperty[$property])) {
            $this->reflectProperty[$property] = $this->reflectClass()->getProperty($property);
            $this->reflectProperty[$property]->setAccessible(true);
        }
        return $this->reflectProperty[$property];
    }

    public function reflectGetValue(string $property)
    {
        return $this->reflectProperty($property)->getValue($this);
    }

    public function reflectSetValue(string $property, $value) : void
    {
        $this->reflectProperty($property)->setValue($this, $value);
    }
}
