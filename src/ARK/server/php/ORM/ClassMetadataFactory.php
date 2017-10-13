<?php

/**
 * ARK ORM Class Metadat Factory.
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

namespace ARK\ORM;

use Doctrine\ORM\Mapping\ClassMetadataFactory as DoctrineClassMetadataFactory;
use ReflectionClass;

class ClassMetadataFactory extends DoctrineClassMetadataFactory
{
    private $refl;
    private $emRefl;

    public function __construct()
    {
        $this->refl = new ReflectionClass('Doctrine\ORM\Mapping\ClassMetadataFactory');
        $this->emRefl = $this->refl->getProperty('em');
        $this->emRefl->setAccessible(true);
    }

    public function classNames() : iterable
    {
        if (!$this->initialized) {
            $this->initialize();
        }
        return $this->getDriver()->getAllClassNames();
    }

    public function hasClass($class) : bool
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        return in_array($class, $this->classNames(), true);
    }

    protected function newClassMetadataInstance($className) : ClassMetadata
    {
        $em = $this->emRefl->getValue($this);
        return new ClassMetadata($className, $em->getConfiguration()->getNamingStrategy());
    }
}
