<?php

/**
 * ARK ORM Item Metadata Driver
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

use ARK\Service;
use ARK\Model\VersionTrait;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\Item\ItemRepository;
use ARK\ORM\Item\ItemIdGenerator;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class ItemMappingDriver implements MappingDriver
{
    private $namespace = '';
    private $classNames = null;

    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    public function loadMetadataForClass($className, ClassMetadata $metadata)
    {
        // Table
        $module = Service::database()->getModuleForClassName($className);
        if (!$module) {
            return;
        }
        $builder = new ClassMetadataBuilder($metadata, $module['tbl']);
        $builder->setCustomRepositoryClass(ItemRepository::class);

        // Key
        $builder->addStringKey('item', 30);
        $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_CUSTOM);
        $metadata->setCustomGeneratorDefinition(['class' => ItemIdGenerator::class]);

        // Fields
        $builder->addStringField('module', 30);
        $builder->addStringField('schma', 30);
        $typeEntities = Service::database()->getTypeEntities($module['module']);
        if ($typeEntities) {
            $builder->setSingleTableInheritance()->setDiscriminatorColumn('type', 'string', 30);
            $metadata->addDiscriminatorMapClass('', $module['classname']);
            foreach ($typeEntities as $type) {
                $metadata->addDiscriminatorMapClass($type['type'], $type['classname']);
            }
        } else {
            $builder->addStringField('type', 30);
        }
        $builder->addStringField('status', 30, 'status', false, ['default' => 'registered']);
        $builder->addStringField('parentModule', 30, 'parent_module', true);
        $builder->addStringField('parentItem', 30, 'parent_item', true);
        $builder->addStringField('idx', 30);
        $builder->addStringField('label', 30);
        VersionTrait::buildVersionMetadata($builder);
        $metadata->setItemEntity(true);
    }

    public function getAllClassNames()
    {
        if ($this->classNames === null) {
            $this->classNames = [];
            $modules = Service::database()->getModules();
            foreach ($modules as $module) {
                if ($module['namespace'] == $this->namespace) {
                    $this->classNames[] = $module['classname'];
                }
            }
        }
        return $this->classNames;
    }

    public function isTransient($className)
    {
        return Service::database()->getModuleForClassName($className) === null;
    }

    public function loadMetadataForGenerator($className, ClassMetadata $metadata)
    {
        // Table
        $module = Service::database()->getModuleForClassName($className);
        $builder = new ClassMetadataBuilder($metadata, $module['tbl']);
    }
}
