<?php

/**
 * ARK Item Repository
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

namespace ARK\ORM;

use ARK\Model\Item\Item;
use ARK\Model\Item\ItemMetadata;
use ARK\Model\Item\ItemRepository;
use ARK\Model\Module\Module;
use ARK\Model\Module\ModuleSchema;
use ARK\ORM\EntityManager;

class ClassMetadataFactory
{
    protected $em = null;
    protected $metadata = [];

    public function __construct(EntityManager $em)
    {
        // TODO build from em service provider mapping of class/metaClass/connection
        $this->em = $em;
        $modules = $em->database()->getModules();

        foreach ($modules as $moduleId => $module) {
            $this->modules[$module['entity']] = new Module($em->database(), $moduleId);
        }
    }

    public function getMetadataFor($class)
    {
        $className = $this->getEntityName($class);
        if (!isset($this->metadata[$className])) {
            $this->setMetadataFor($className, $this->createMetadataClass($class));
        }
        return $this->metadata[$className];
    }

    public function hasMetadataFor($class)
    {
        return isset($this->metadata[$this->getClassName($class)]);
    }

    public function setMetadataFor($className, $class)
    {
        $this->metadata[$className] = $class;
    }

    public function getClassName($class)
    {
        if (is_object($class)) {
            if ($class instanceof ModuleSchema) {
                return $class->className();
            }
            if ($class instanceof Module) {
                return $class->className();
            }
            if ($class instanceof Item) {
                return $class->schema()->className();
            }
            return get_class($class);
        }
        return $class;
    }

    public function getEntityName($class)
    {
        if (is_object($class)) {
            if ($class instanceof ModuleSchema) {
                return $class->entityName();
            }
            if ($class instanceof Module) {
                return $class->entityName();
            }
            if ($class instanceof Item) {
                return $class->schema()->entityName();
            }
            return get_class($class);
        }
        return $class;
    }

    public function createRepository($entityName)
    {
        $meta = $this->getMetadataFor($entityName);
        if (isset($this->modules[$entityName])) {
            return new ItemRepository($meta);
        }
        return new EntityRepository($meta);
    }

    private function createMetadataClass($class)
    {
        if (is_object($class)) {
            if ($class instanceof ModuleSchema) {
                $module = $this->modules[$class->entityName()];
                return new ItemMetadata($this->em, $module);
            }
            if ($class instanceof Module) {
                return new ItemMetadata($this->em, $class);
            }
            if ($class instanceof Item) {
                $module = $this->modules[$class->schema()->entityName()];
                return new ItemMetadata($this->em, $module);
            }
            $class = get_class($class);
        }
        if (isset($this->modules[$class])) {
            return new ItemMetadata($this->em, $this->modules[$class]);
        }
        $class = $class.'Metadata';
        return new $class($this->em);
    }
}
