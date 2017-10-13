<?php

/**
 * ARK ORM Item Metadata Driver.
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
 * @php        >=5.6, >=7.0
 */

namespace ARK\ORM\Item;

use ARK\Model\VersionTrait;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class ItemMappingDriver implements MappingDriver
{
    private $namespace = '';
    private $classNames;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function loadMetadataForClass($className, ClassMetadata $metadata) : void
    {
        // Table
        $module = Service::database()->getModuleForClassName($className);
        if (!$module) {
            return;
        }
        $classNames[] = $module['classname'];
        $builder = new ClassMetadataBuilder($metadata, $module['tbl']);
        $builder->setCustomRepositoryClass(ItemRepository::class);

        // Key
        $builder->addStringKey('id', 30);
        $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_CUSTOM);
        $metadata->setCustomGeneratorDefinition(['class' => ItemIdGenerator::class]);

        // Fields
        $builder->addStringField('module', 30);
        $builder->addStringField('schma', 30);
        $subclasses = Service::database()->getSubclassEntities($module['module']);
        if ($subclasses) {
            $builder->setSingleTableInheritance()->setDiscriminatorColumn('class', 'string', 30);
            $metadata->addDiscriminatorMapClass('', $module['classname']);
            foreach ($subclasses as $subclass) {
                $metadata->addDiscriminatorMapClass($subclass['class'], $subclass['entity']);
                $classNames[] = $subclass['entity'];
            }
        } else {
            $builder->addStringField('class', 30);
        }
        $builder->addStringField('status', 30, false, ['default' => 'allocated']);
        $builder->addStringField('visibility', 30, false, ['default' => 'restricted']);
        $builder->addMappedStringField('parent_module', 'parentModule', 30, true);
        $builder->addMappedStringField('parent_id', 'parentId', 30, true);
        $builder->addStringField('idx', 30);
        $builder->addStringField('label', 30);
        VersionTrait::buildVersionMetadata($builder);
        $metadata->setItemEntity(true);
        if ($this->classNames === null) {
            $this->classNames = $classNames;
        }
    }

    public function getAllClassNames() : iterable
    {
        if ($this->classNames === null) {
            $this->classNames = Service::database()->getAllClassNames($this->namespace);
        }
        return $this->classNames;
    }

    public function isTransient($className) : bool
    {
        return Service::database()->getModuleForClassName($className) === null;
    }

    public function loadMetadataForGenerator($className, ClassMetadata $metadata) : void
    {
        // Table
        $module = Service::database()->getModuleForClassName($className);
        $builder = new ClassMetadataBuilder($metadata, $module['tbl']);
    }
}
