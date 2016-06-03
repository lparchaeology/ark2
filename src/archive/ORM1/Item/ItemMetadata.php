<?php

/**
 * ARK Item Metadata
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

namespace ARK\Model\Item;

use ARK\Model\Module\Module;
use ARK\Model\Module\ModuleSchema;
use ARK\ORM\ClassMetadataInterface;
use ARK\ORM\EntityManager;

class ItemMetadata implements ClassMetadataInterface
{
    protected $em = null;
    protected $module = null;
    protected $persister = null;
    protected $generator = null;
    protected $fieldNames = null;
    protected $associationNames = null;

    public function __construct(EntityManager $em, Module $module)
    {
        $this->em = $em;
        $this->module = $module;
        $this->persister = new ItemPersister($em, $this);
        $this->generator = new ItemAssignedGenerator($em, $this);

        // TODO Relationships
        $this->associationNames = [];
    }

    public function getModule()
    {
        return $this->module;
    }

    public function getPersister()
    {
        return $this->persister;
    }

    // reimp ClassMetadataInterface
    public function getIdGenerator()
    {
        return $this->generator;
    }

    // reimp ClassMetadata
    public function getName()
    {
        return $this->module->entityName();
    }

    // reimp ClassMetadata
    public function getIdentifier()
    {
        return $this->getIdentifierFieldNames();
    }

    // reimp ClassMetadata
    public function getReflectionClass()
    {
        // TODO ItemReflection
    }

    public function getRepositoryClass()
    {
        return Item::class.'Repository';
    }

    public function createRepository()
    {
        return new ItemRepository($this);
    }

    // reimp ClassMetadata
    public function getIdentifierFieldNames()
    {
        return ['id'];
    }

    // reimp ClassMetadata
    public function isIdentifier($fieldName)
    {
        return ($fieldName === 'id');
    }

    public function generateIdentifier($item)
    {
        if (!$this->generator->isPostInsertGenerator()) {
            $this->setIdentifierValues($item, $this->generator->generate($item));
            $setId = function ($parentId, $index) {
                $this->setIdentifier($parentId, $index);
            };
            $setId = $setId->bindTo($item, $item);
            $setId();
        }
        return $item;
    }

    public function setIdentifierValues($object, $id)
    {
    }

    // reimp ClassMetadata
    public function getIdentifierValues($object)
    {
        return [$object->id()];
    }

    public function getIdentifierHash($object)
    {
        return $object->id();
    }

    // reimp ClassMetadata
    public function hasField($fieldName, $object = null)
    {
        return in_array($fieldName, $this->fieldNames($object));
    }

    // reimp ClassMetadata
    public function hasAssociation($fieldName)
    {
        return in_array($fieldName, $this->associationNames);
    }

    // reimp ClassMetadata
    public function isSingleValuedAssociation($fieldName)
    {
    }

    // reimp ClassMetadata
    public function isCollectionValuedAssociation($fieldName)
    {
    }

    // reimp ClassMetadata
    public function getFieldNames($object = null)
    {
        return  array_merge(
            $this->getIdentifierFieldNames(),
            $object->propertyNames()
        );
    }

     // reimp ClassMetadata
    public function getAssociationNames()
    {
        return $this->associationNames;
    }

     // reimp ClassMetadata
    public function getTypeOfField($fieldName, $object = null)
    {
        return $object->property($fieldName)->type();
    }

    /**
     * Returns the target class name of the given association.
     * @param string $assocName
     * @return string
     */
     // reimp ClassMetadata
    public function getAssociationTargetClass($assocName)
    {
    }

    /**
     * Checks if the association is the inverse side of a bidirectional association.
     * @param string $assocName
     * @return boolean
     */
     // reimp ClassMetadata
    public function isAssociationInverseSide($assocName)
    {
    }

    /**
     * Returns the target field of the owning side of the association.
     * @param string $assocName
     * @return string
     */
     // reimp ClassMetadata
    public function getAssociationMappedByTargetField($assocName)
    {
    }
}
