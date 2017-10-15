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
    private $namespace;
    private $classnames;

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function loadMetadataForClass($classname, ClassMetadata $metadata) : void
    {
        // Table
        $entity = Service::database()->getEntityForClassName($classname);
        if (!$entity) {
            return;
        }
        $classnames[] = $entity['classname'];

        $builder = new ClassMetadataBuilder($metadata, $entity['tbl']);
        $builder->setCustomRepositoryClass(ItemRepository::class);

        // Key
        $builder->addStringKey('id', 30);
        $metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_CUSTOM);
        // TODO Get from $entity?
        $metadata->setCustomGeneratorDefinition(['class' => ItemIdGenerator::class]);

        // Fields
        $builder->addStringField('module', 30);
        $builder->addStringField('schma', 30);
        if ($entity['entities']) {
            $subclasses = Service::database()->getSubclassEntities($entity['schma']);
            $builder->setSingleTableInheritance()->setDiscriminatorColumn('class', 'string', 30);
            $metadata->addDiscriminatorMapClass('', $entity['classname']);
            foreach ($subclasses as $subclass) {
                $metadata->addDiscriminatorMapClass($subclass['class'], $subclass['classname']);
                $classnames[] = $subclass['classname'];
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
        if ($this->classnames === null) {
            $this->classnames = $classnames;
        }
    }

    public function getAllClassNames() : iterable
    {
        if ($this->classnames === null) {
            $this->classnames = Service::database()->getAllClassNames($this->namespace);
        }
        return $this->classnames;
    }

    public function isTransient($classname) : bool
    {
        return !in_array($classname, $this->getAllClassNames(), true);
    }

    public function loadMetadataForGenerator($classname, ClassMetadata $metadata) : void
    {
        // Table
        $entity = Service::database()->getEntityForClassName($classname);
        $builder = new ClassMetadataBuilder($metadata, $entity['tbl']);
    }
}
