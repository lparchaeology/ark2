<?php

/**
 * ARK ORM Entity Manager.
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
 */

namespace ARK\ORM;

use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;

class EntityManager extends EntityManagerDecorator
{
    protected $name = '';

    public function __construct(EntityManagerInterface $em, string $name)
    {
        parent::__construct($em);
        $refl = new ReflectionClass($em);
        $uow = $refl->getProperty('unitOfWork');
        $uow->setAccessible(true);
        $uow->setValue($em, new UnitOfWork($em));
        $this->name = $name;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function classNames() : iterable
    {
        return $this->getMetadataFactory()->classNames();
    }

    public function manages($class) : bool
    {
        return $this->getMetadataFactory()->hasClass($class);
    }
}
