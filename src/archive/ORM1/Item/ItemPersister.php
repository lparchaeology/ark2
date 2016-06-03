<?php

/**
 * ARK Item Persister
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

use ARK\Database\Database;
use ARK\Model\Property\Property;
use ARK\Model\Item\ItemMetadata;
use ARK\ORM\EntityManager;
use ARK\ORM\EntityPersisterInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\PersistentCollection;

class ItemPersister implements EntityPersisterInterface
{
    protected $em = null;
    protected $db = null;
    protected $meta = null;
    protected $module = null;
    protected $moduleId = null;

    public function __construct(EntityManager $em, ItemMetadata $meta)
    {
        $this->em = $em;
        $this->db = $em->getConnection();
        $this->meta = $meta;
        $this->module = $meta->getModule();
        $this->moduleId = $this->module->id();
    }

    // reimp EntityPersisterInterface
    public function getClassMetadata()
    {
        return $this->meta;
    }

    // reimp EntityPersisterInterface
    public function expandParameters($criteria)
    {
    }

    // reimp EntityPersisterInterface
    public function expandCriteriaParameters(Criteria $criteria)
    {
    }

    // reimp EntityPersisterInterface
    public function insert(array $entities)
    {
        $items = [];
        $fragments = [];
        foreach ($entities as $entity) {
            $item = [
                'id' => $entity->id(),
                'parent_id' => $entity->parentId(),
                'parent_module' => $entity->parentId(),
                'idx' => $entity->item(),
                'name' => $entity->name(),
                'modtype' => $entity->modtype(),
                'schema_id' => $entity->schemaId(),
            ];
            $items[] = $item;
            // TODO Chains
            foreach ($entity->attributes() as $property => $attribute) {
                if (is_array($attribute)) {
                    $parameter = $attribute[0];
                    $value = $attribute[1];
                } else {
                    $parameter = null;
                    $value = $attribute;
                }
                $fragment = [
                    'module' => $this->moduleId,
                    'item' => $entity->id(),
                    'property' => $property,
                    'parameter' => $parameter,
                    'value' => $value,
                ];
            }
        }
        $this->addItems($this->moduleId, $items);
        $this->addItemFragments($fragments);
    }

    // reimp EntityPersisterInterface
    public function update($entity)
    {
    }

    // reimp EntityPersisterInterface
    public function delete($item)
    {
        $this->deleteItem($item->module(), $item->id());
    }

    // reimp EntityPersisterInterface
    public function count($criteria = [])
    {
        $this->countItems($this->meta->schema()->module());
    }

    // reimp EntityPersisterInterface
    private function itemFromConfig($config)
    {
        $item = new Item($this->em);
        // TODO That hydrate protected trick...
        $item->hydrate(
            $this->moduleId,
            $config['schema_id'],
            $config['idx'],
            $config['parent_module'],
            $config['parent_id'],
            $config['id'],
            $config['name'],
            $config['modtype'],
            null, // $version
            $config['mod_by'],
            $config['mod_on'],
            $config['cre_by'],
            $config['cre_on']
        );
        return $item;
    }

    // reimp EntityPersisterInterface
    public function load($id, $entity = null, $lockMode = null, $lockVersion = null)
    {
        // TODO $entity, $lock
        $config = $this->getItem($this->moduleId, $id);
        if ($config) {
            return $this->itemFromConfig($config);
        }
        return null;
    }

    // reimp EntityPersisterInterface
    public function loadOneBy(array $criteria, $entity = null, $lockMode = null, array $orderBy = null)
    {
    }

    // reimp EntityPersisterInterface
    public function loadAll(array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        $items = [];
        $parentModule = null;
        $parentId = null;
        if (isset($criteria['parent_module']) && isset($criteria['parent_id'])) {
            $parentModule = $criteria['parent_module'];
            $parentId = $criteria['parent_id'];
        }
        unset($criteria['parent_module']);
        unset($criteria['parent_id']);
        if ($criteria) {
            $configs = $this->getItemsByCriteria($this->moduleId, $criteria, $parentModule, $parentId);
        } else {
            $configs = $this->getItems($this->moduleId, $parentModule, $parentId);
        }
        foreach ($configs as $config) {
            $items[] = $this->itemFromConfig($config);
        }
        return $items;
    }

    // reimp EntityPersisterInterface
    public function loadOneToOneEntity(array $assoc, $sourceEntity, array $identifier = [])
    {
    }

    // reimp EntityPersisterInterface
    public function getManyToManyCollection(array $assoc, $sourceEntity, $offset = null, $limit = null)
    {
    }

    // reimp EntityPersisterInterface
    public function loadManyToManyCollection(array $assoc, $sourceEntity, PersistentCollection $collection)
    {
    }

    // reimp EntityPersisterInterface
    public function loadOneToManyCollection(array $assoc, $sourceEntity, PersistentCollection $collection)
    {
    }

    // reimp EntityPersisterInterface
    public function lock(array $criteria, $lockMode)
    {
    }

    // reimp EntityPersisterInterface
    public function getOneToManyCollection(array $assoc, $sourceEntity, $offset = null, $limit = null)
    {
    }

    // reimp EntityPersisterInterface
    public function exists($entity, Criteria $extraConditions = null)
    {
    }

    // reimp EntityPersisterInterface
    public function loadCriteria(Criteria $criteria)
    {
    }

    // TODO Old code taken from Item class

    private function create(array $config)
    {
        if (isset($config['modtype_class'])) {
            $item = new $config['modtype_class'];
        } elseif (isset($config['class'])) {
            $item = new $config['class'];
        } else {
            $item = new Item();
        }
        $parent = null;
        if (!empty($config['parent'])) {
            $parent = $this->em->getRepository($this->module->parent()->type())->get($config['parent']);
        }
        $item->init($this->em, $this->module, $parent, $config);
        return $item;
    }

    public function loadChildrenBy($parentModule, $parentId, array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $items = [];
        $configs = $this->getItemsByCriteria($this->moduleId, $parentModule, $parentId, $criteria);
        foreach ($configs as $config) {
            $items[] = $this->itemFromConfig($config);
        }
        return $items;
    }
    public function loadAllChildren($parentModule, $parentId)
    {
        $items = [];
        $configs = $this->getItems($this->moduleId, $parentModule, $parentId);
        foreach ($configs as $config) {
            $items[] = $this->itemFromConfig($config);
        }
        return $items;
    }

    public function loadByIndex($parent, $index)
    {
        $item = new Item();
        $config = $this->getItemFromIndex($parent, $index);
        if ($config) {
            if ($parent) {
                $parent = $this->em->getRepository($this->module->parent()->type(), $parent);
            }
            $item->init($this->em, $this->module, $parent, $config);
        }
        return $item;
    }

    public function loadRecent(/*int*/ $limit, $parent = null)
    {
        $items = [];
        $configs = $this->getRecentItems($this->module->id(), $parent, $limit);
        if ($parent) {
            $parent = $this->em->getRepository($this->module->parent()->type(), $parent);
        }
        foreach ($configs as $config) {
            $item = new Item();
            $item->init($this->em, $this->module, $parent, $config);
            $items[] = $item;
        }
        return $items;
    }

    public function loadLast($parent = null)
    {
        $config = $this->getLastItem($this->module->id(), $parent);
        $item = new Item();
        $item->init($this->em, $this->module, $parent, $config);
        return $item;
    }

    public function loadRelated($module, $id)
    {
        $items = [];
        $configs = $this->getXmiItems($module, $id, $item->module()->id());
        foreach ($configs as $config) {
            $parent = null;
            if ($config['parent']) {
                $parent = $this->em->getRepository($this->module->parent()->type(), $parent);
            }
            $item = new Item();
            $item->init($this->em, $this->module, $parent, $config);
            $items[] = $item;
        }
        return $items;
    }

    public function loadRoot($root)
    {
        return Item::get($db, Module::getRoot($db, $root), null, $root);
    }

    public function loadAttributes($id, array $properties)
    {
        foreach ($properties as $prop) {
            $attributes[$prop->id()] = null;
            $props[$prop->id()] = $prop;
        }
        $frags = $this->getItemFragments($this->module->id(), $id);
        $members = [];
        foreach ($frags as $key => $frag) {
            if ($frag['object_fid'] !== null) {
                $members[$frag['object_fid']][] = $frag;
                unset($frags[$key]);
            }
        }
        $attributes = [];
        foreach ($frags as $frag) {
            $propertyId = $frag['property'];
            $property = $props[$frag['property']];
            $value = $this->buildAttributeValue($property, $frag, $members);
            if ($property->hasMultipleOccurrences()) {
                $attributes[$propertyId][] = $value;
            } else {
                $attributes[$propertyId] = $value;
            }
        }
        return $attributes;
    }

    private function buildAttributeValue($property, $frag, array $members)
    {
        if ($property->formatType() == 'object') {
            foreach ($property->properties() as $prop) {
                $attributes[$prop->id()] = null;
                $properties[$prop->id()] = $prop;
            }
            foreach ($members[$frag['fid']] as $member) {
                if (isset($member['object_fid']) && $member['object_fid'] === $frag['fid']) {
                    $propertyId = $member['property'];
                    $prop = $properties[$propertyId];
                    $value = $this->buildAttributeValue($prop, $member, $members);
                    if ($prop->hasMultipleOccurrences()) {
                        $attributes[$propertyId][] = $value;
                    } else {
                        $attributes[$propertyId] = $value;
                    }
                }
            }
            return $attributes;
        } else {
            return $this->buildFrag($frag);
        }
    }

    private function buildFrag($frag)
    {
        if (!empty($frag['parameter'])) {
            return [$frag['parameter'], $frag['value']];
        }
        return $frag['value'];
    }

    // Database stuff
    protected function addItems($module, array $items)
    {
        $this->db->insertRows($this->data(), $this->em->database()->getModuleTable($module), array_keys($items[0]), $items);
    }

    protected function addFragments(array $fragments)
    {
        $this->em->database()->loadPropertyFragmentTypes();
        foreach ($fragments as $fragment) {
            $fragType = $this->propertyFragTypes[$fragment['property']];
            $fragsByType[$fragType][] = $fragment;
        }
        foreach ($fragsByType as $fragType => $frags) {
            $this->db->insertRows($this->data(), $this->getFragmentTable($fragType), array_keys($items[0]), $frags);
        }
    }

    protected function addItem($module, $parentModuleId, $parentId, $index, $name, $modtype, $schemaId)
    {
        $table = $this->em->database()->getModuleTable($module);
        $sql = "
            INSERT INTO $table
            (id, parent_module, parent_id, idx, name, modtype, schema_id)
            VALUES (:id, :parent_module, :parent_id, :idx, :name, :modtype, :schema_id)
        ";
        $params = [
            ':parent_module' => $parentModuleId,
            ':parent_id' => $parentId,
            ':idx' => $index,
            ':name' => $name,
            ':modtype' => $modtype,
            ':schema_id' => $schemaId,
        ];
        $params[':id'] = ($parentId ? $parentId.'.'.$index : $index);
        return $this->db->executeUpdate($sql, $params);
    }

    protected function addItemFragments($module, $item, $fragType, array $fragments)
    {
        $table = $this->em->database()->getFragmentTable($fragType);
        $fields = array_merge(['module', 'item'], array_keys($fragments[0]));
        foreach ($fragments as $fragment) {
            $rows[] = array_merge([$module, $item], array_values($fragment));
        }
        $this->db->insertRows($this->data(), $table, $fields, $rows);
    }

    protected function addPropertyFragments($module, $item, $property, $fragType, array $fragments)
    {
        $table = $this->em->database()->getFragmentTable($fragType);
        $fields = array_merge(['module', 'item', 'property'], array_keys($fragments[0]));
        foreach ($fragments as $fragment) {
            $rows[] = array_merge([$module, $item, $property], array_values($fragment));
        }
        $this->db->insertRows($this->data(), $table, $fields, $rows);
    }

    protected function deleteItem($module, $item)
    {
        $frags = $this->deleteItemFragments($module, $item);
        $table = $this->em->database()->getModuleTable($module);
        $sql = "
            DELETE
            FROM $table
            WHERE id = :item
        ";
        $params = array(
            ':item' => $item,
        );
        return $this->db->executeUpdate($sql, $params) + $frags;
    }

    protected function deleteItemFragments($module, $item)
    {
        $tables = $this->em->database()->getFragmentTables();
        $using = '';
        $where = '';
        foreach ($tables as $table) {
            if ($using) {
                $using .= "
                    INNER JOIN $table
                ";
            } else {
                $using = "
                    USING $table
                ";
            }
            if ($where) {
                $where .= "
                    AND ($table.module = $prev.module AND $table.item = $prev.item)
                ";
            } else {
                $where = "
                    WHERE ($table.module = :module AND $table.item = :item)
                ";
            }
            if ($table == 'ark_relation_xmi') {
                $where .= "
                    AND ($table.xmi_module = $prev.module AND $table.xmi_item = $prev.item)
                ";
            }
            $prev = $table;
        }
        $list = implode(', ', $tables);
        $sql = "
            DELETE
            FROM $list
            $using
            $where
        ";
        $params = array(
            ':module' => $module,
            ':item' => $item,
        );
        return $this->db->executeUpdate($sql, $params);
    }

    protected function deletePropertyFragments($module, $item, $property, $fragType)
    {
        $table = $this->em->database()->getFragmentTable($fragType);
        $sql = "
            DELETE
            FROM $table
            WHERE module = :module
            AND item = :item
            AND property = :property
        ";
        $params = array(
            ':module' => $module,
            ':item' => $item,
            ':property' => $property,
        );
        return $this->db->executeUpdate($sql, $params);
    }

    protected function getItemFragments($module, $item)
    {
        $sql = '';
        $tables = $this->em->database()->getFragmentTables();
        foreach ($tables as $table) {
            if ($sql) {
                $sql .= "
                    UNION ALL
                ";
            }
            $sql .= "
                SELECT *
                FROM $table
                WHERE module = :module
                AND item = :item
            ";
        }
        $params = array(
            ':module' => $module,
            ':item' => $item,
        );
        return $this->db->fetchAll($sql, $params);
    }

    protected function getPropertyFragments($module, $item, $property, $fragType)
    {
        $table = $this->em->database()->getFragmentTable($fragType);
        if ($table) {
            $sql = "
                SELECT *
                FROM $table
                WHERE module = :module
                AND item = :item
                AND property = :property
            ";
            $params = array(
                ':module' => $module,
                ':item' => $item,
                ':property' => $property,
            );
            return $this->db->fetchAll($sql, $params);
        }
        return array();
    }

    protected function findFragmentsByCriteria($module, array $criteria)
    {
        $this->em->database()->loadPropertyFragmentTypes();
        foreach ($criteria as $property => $value) {
            $fragCriteria[$this->propertyFragTypes[$property]][$property] = $value;
        }
        $sql = '';
        $params = [];
        foreach ($fragCriteria as $fragType => $clauses) {
            $table = $this->em->database()->getFragmentTable($fragType);
            foreach ($clauses as $property => $value) {
                if ($sql) {
                    $sql .= "
                        UNION
                    ";
                }
                $sql .= "
                    SELECT item
                    FROM $table
                    WHERE module = ? AND property = ? AND value = ?
                ";
                $params[] = $module;
                $params[] = $property;
                $params[] = $value;
            }
        }
        return $this->db->fetchAll($sql, $params);
    }

    protected function getXmiItems($module, $item, $xmiModule, $xmiTable = null)
    {
        if (empty($xmiTable)) {
            $xmiTable = $this->em->database()->getModuleTable($xmiModule);
        }
        $sql = "
            SELECT $xmiTable.*
            FROM ark_relation_xmi, $xmiTable
            WHERE (ark_relation_xmi.module = :module
                   AND ark_relation_xmi.item = :item
                   AND ark_relation_xmi.xmi_module = :xmi_module
                   AND $xmiTable.id = ark_relation_xmi.xmi_item)
            OR (ark_relation_xmi.xmi_module = :module
                AND ark_relation_xmi.xmi_item = :item
                AND ark_relation_xmi.module = :xmi_module
                AND $xmiTable.id = ark_relation_xmi.item)
        ";
        $params = array(
            ':module' => $module,
            ':item' => $item,
            ':xmi_module' => $xmiModule,
        );
        return $this->db->fetchAll($sql, $params);
    }

    protected function getXmiItem($module, $item, $xmiModule, $xmiItem)
    {
        $sql = "
            SELECT *
            FROM ark_relation_xmi
            WHERE (module = :module AND item = :item AND xmi_module = :xmi_module AND xmi_item = :xmi_item)
            OR (module = :xmi_module AND item = :xmi_item AND xmi_module = :module AND xmi_item = :item)
        ";
        $params = array(
            ':module' => $module,
            ':item' => $item,
            ':xmi_module' => $xmiModule,
            ':xmi_item' => $xmiItem,
        );
        $row =$this->db->fetchAssoc($sql, $params);
        $this->switchXmi($row);
        return $row;
    }

    protected function switchXmi(array &$row, $module, $item)
    {
        if ($row && $row['xmi_module'] == $module && $row['xmi_item'] == $item) {
            $row['xmi_module'] = $row['module'];
            $row['xmi_item'] = $row['item'];
            $row['module'] = $module;
            $row['item'] = $item;
        }
    }

    protected function getActors($moduleTable = null)
    {
        if (empty($moduleTable)) {
            $moduleTable = $this->em->database()->getModuleTable('act');
        }
        $sql = "
            SELECT *
            FROM $moduleTable
        ";
        $params = array();
        return $this->db->fetchAll($sql, $params);
    }

    protected function getItem($module, $id)
    {
        $table = $this->em->database()->getModuleTable($module);
        $sql = "
            SELECT *
            FROM $table
            WHERE id = :id
        ";
        $params = array(
            ':id' => $id,
        );
        return $this->db->fetchAssoc($sql, $params);
    }

    protected function getItemFromIndex($module, $index, $parentModule = null, $parentId = null)
    {
        $table = $this->em->database()->getModuleTable($module);
        $sql = "
            SELECT *
            FROM $table
            WHERE parent_module = :parent_module
            AND parent_id = :parent_id
            AND idx = :idx
        ";
        $params = array(
            ':parent_module' => $parentModuleId,
            ':parent_id' => $parentId,
            ':idx' => $index,
        );
        return $this->db->fetchAssoc($sql, $params);
    }

    protected function getItems($module, $parentModule = null, $parentId = null)
    {
        $table = $this->em->database()->getModuleTable($module);
        $sql = "
            SELECT *
            FROM $table
        ";
        $params = array();
        if ($parentModule && $parentId) {
            $sql .= "
                WHERE parent_module = :parent_module
                AND parent_id = :parent_id
            ";
            $params[':parent_module'] = $parentModule;
            $params[':parent_id'] = $parentId;
        }
        $sql .= "
            ORDER BY LENGTH(id), id
        ";
        return $this->db->fetchAll($sql, $params);
    }

    protected function getItemsByCriteria($module, $criteria, $parentModule = null, $parentId = null)
    {
        $matches = $this->em->database()->findFragmentsByCriteria($module, $criteria);
        foreach ($matches as $match) {
            $items[] = $match['item'];
        }
        $table = $this->em->database()->getModuleTable($module);
        $sql = "
            SELECT *
            FROM $table
            WHERE id IN (?)
        ";
        $params[] = $items;
        $types[] = Connection::PARAM_STR_ARRAY;
        if ($parentModule && $parentId) {
            $sql .= "
                AND parent_module = ?
                AND parent_id = ?
            ";
            $params[] = $parent_module;
            $types[] = \PDO::PARAM_STR;
            $params[] = $parent_id;
            $types[] = \PDO::PARAM_STR;
        }
        $sql .= "
            ORDER BY LENGTH(id), id
        ";
        // TODO Check binding safety!!!
        return $this->db->executeQuery($sql, $params, $types);
    }

    protected function countItems($moduleId, $parentModule = null, $parentId = null)
    {
        $table = $this->em->database()->getModuleTable($moduleId);
        $sql = "
            SELECT COUNT(*) as 'count'
            FROM $table
        ";
        $params = [];
        if ($parentModule && $parentId) {
            $sql .= "
                WHERE parent_module = :parent_module
                AND parent_id = :parent_id
            ";
            $params[':parent_module'] = $parent_module;
            $params[':parent_id'] = $parent_id;
        }
        return $this->db->fetchAssoc($sql, $params)['count'];
    }

    protected function getRecentItems($moduleId, $rows, $parentModule = null, $parentId = null)
    {
        $table = $this->em->database()->getModuleTable($moduleId);
        $count = $this->countItems($moduleId, $parentModule, $parentId);
        $start = ($count > $rows) ? $count - $rows : 0;
        $params = [];
        $sql = "
            SELECT *
            FROM $table
        ";
        if ($parentModule && $parentId) {
            $sql .= "
                WHERE parent_module = :parent_module
                AND parent_id = :parent_id
            ";
            $params[':parent_module'] = $parent_module;
            $params[':parent_id'] = $parent_id;
        }
        $sql .= "
            ORDER BY cre_on, LENGTH(item), item
            LIMIT $start, $rows
        ";
        return $this->db->fetchAll($sql, $params);
    }

    protected function getLastItem($moduleId, $parentModule = null, $parentId = null)
    {
        $table = $this->em->database()->getModuleTable($moduleId);
        $params = array();
        $sql = "
            SELECT *
            FROM $table
        ";
        if ($parentModule && $parentId) {
            $sql .= "
                WHERE parent_module = :parent_module
                AND parent_id = :parent_id
            ";
            $params[':parent_module'] = $parent_module;
            $params[':parent_id'] = $parent_id;
        }
        $sql .= "
            ORDER BY LENGTH(idx) DESC, idx DESC
        ";
        return $this->db->fetchAssoc($sql, $params);
    }
}
