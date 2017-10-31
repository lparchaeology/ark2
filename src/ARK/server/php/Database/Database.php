<?php

/**
 * ARK Database.
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

namespace ARK\Database;

use ARK\ARK;
use Doctrine\DBAL\Connection;
use Silex\Application;

class Database
{
    private $app;
    private $entities;
    private $subclasses;
    private $classnames;
    private $modules;
    private $datatypes;
    private $fragmentTables;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function data() : Connection
    {
        return $this->app['dbs']['data'];
    }

    public function sequence() : Connection
    {
        return $this->app['dbs']['data'];
    }

    public function core() : Connection
    {
        return $this->app['dbs']['core'];
    }

    public function spatial() : Connection
    {
        return $this->app['dbs']['spatial'];
    }

    public function user() : Connection
    {
        return $this->app['dbs']['user'];
    }

    public function getEntityForClassName(string $classname) : ?iterable
    {
        $this->loadEntities();
        return $this->entities['classname'][$classname] ?? [];
    }

    public function getSubclassEntities(string $schema) : ?iterable
    {
        $this->loadEntities();
        return $this->subclasses[$schema] ?? [];
    }

    public function getAllClassNames($namespace) : ?iterable
    {
        $this->loadEntities();
        return $this->classnames[$namespace] ?? [];
    }

    public function getAllResources() : ?iterable
    {
        $this->loadEntities();
        return $this->entities['resource'] ?? [];
    }

    public function getEntitiesForSchema($schema) : ?iterable
    {
        $this->loadEntities();
        return $this->entities['schema'][$schema] ?? [];
    }

    public function getSuperclassForSchema($schema) : ?string
    {
        $this->loadEntities();
        foreach ($this->entities['schema'][$schema] as $entity) {
            if ($entity['superclass']) {
                return $entity['classname'];
            }
        }
        return null;
    }

    public function getDatatypes() : ?iterable
    {
        $this->loadDatatypes();
        return $this->datatypes;
    }

    public function getFragmentDatatype(string $class) : ?iterable
    {
        $this->loadDatatypes();
        foreach ($this->datatypes as $datatype => $attributes) {
            if ($attributes['data_entity'] === $class) {
                return $attributes;
            }
        }
        return null;
    }

    public function getFragmentTables() : ?iterable
    {
        $this->loadDatatypes();
        return $this->fragmentTables;
    }

    public function getViewTypes() : ?iterable
    {
        return $this->core()->fetchAllTable('ark_view_type');
    }

    public function getTranslationMessages(string $language, string $domain = null) : ?iterable
    {
        $sql = '
            SELECT *
            FROM ark_translation_message
            WHERE language = :language
        ';
        $params[':language'] = $language;
        if ($domain) {
            $sql .= '
                AND domain = :domain
            ';
            $params[':domain'] = $domain;
        }

        return $this->core()->fetchAll($sql, $params);
    }

    public function getActorNames() : ?iterable
    {
        $sql = '
            SELECT *
            FROM ark_item_actor, ark_fragment_string
            WHERE ark_fragment_string.module = :module
            AND ark_fragment_string.item = ark_item_actor.id
            AND ark_fragment_string.attribute = :attribute
        ';
        $params = [
            ':module' => 'act',
            ':attribute' => 'name',
        ];

        return $this->data()->fetchAll($sql, $params);
    }

    public function getFlashes(string $language) : ?iterable
    {
        $sql = '
            SELECT *
            FROM ark_config_flash
            WHERE language = :language
            AND active = :active
        ';
        $params = [
            ':language' => $language,
            ':active' => true,
        ];

        return $this->core()->fetchAll($sql, $params);
    }

    // Spatial
    public function getSpatialTerms(string $concept, string $type = null) : ?iterable
    {
        $sql = '
            SELECT term, ST_AsText(geometry) as geometry, srid
            FROM ark_spatial_term
            WHERE concept = :concept
        ';
        $params[':concept'] = $concept;
        if ($type) {
            $sql .= 'AND type = :type';
            $params[':type'] = $type;
        }

        return $this->spatial()->fetchAll($sql, $params);
    }

    public function getSpatialTermsContain(string $concept, string $wkt, string $srid) : ?iterable
    {
        $sql = '
            SELECT term
            FROM dime_ark_spatial.ark_spatial_term
            WHERE concept = :concept
            AND ST_Contains(geometry, ST_GeometryFromText(:point, :srid))
        ';
        $params = [
            ':concept' => $concept,
            ':point' => $wkt,
            ':srid' => $srid,
        ];

        return $this->spatial()->fetchAll($sql, $params);
    }

    public function getSpatialTermChoropleth(
        string $concept,
        string $module,
        string $attribute,
        iterable $items = []
    ) : ?iterable {
        $sql = '
            SELECT ark_spatial_term.term, count(*) as count
            FROM ark_spatial_fragment, ark_spatial_term
            WHERE ST_Contains(ark_spatial_term.geometry, ark_spatial_fragment.geometry)
            AND ark_spatial_term.concept = :concept
            AND ark_spatial_fragment.module = :module
            AND ark_spatial_fragment.attribute = :attribute';

        if ($items) {
            $sql .= ' AND (';
            foreach ($items as $key => $item) {
                $sql .= "
                    ark_spatial_fragment.item = :item$key
                ";
                if ($key < count($items) - 1) {
                    $sql .= ' OR ';
                } else {
                    $sql .= ') ';
                }
            }
        }

        $sql .= '
            GROUP BY ark_spatial_term.term
        ';
        $params[':concept'] = $concept;
        $params[':module'] = $module;
        $params[':attribute'] = $attribute;
        if ($items) {
            foreach ($items as $key => $item) {
                $params[":item$key"] = $item;
            }
        }

        return $this->spatial()->fetchAll($sql, $params);
    }

    public function getMunicipalityMuseum(string $municipality) : ?iterable
    {
        $sql = '
            SELECT item
            FROM ark_fragment_string
            WHERE module = :module
            AND parameter = :parameter
            AND value = :value
        ';
        $params = [
            ':module' => 'actor',
            ':parameter' => 'dime.denmark.municipality',
            ':value' => $municipality,
        ];

        return $this->data()->fetchAll($sql, $params);
    }

    public function getActorFinds(string $actor) : ?iterable
    {
        $sql = "
            SELECT DISTINCT item
            FROM ark_fragment_item
            WHERE module = 'find'
            AND attribute = 'finder'
            AND value = :actor
        ";
        $params = [
            ':actor' => $actor,
        ];

        return $this->data()->fetchAllColumn($sql, 'item', $params);
    }

    public function getFinders() : ?iterable
    {
        $sql = "
            SELECT DISTINCT value
            FROM ark_fragment_item
            WHERE module = 'find'
            AND attribute = 'finder'
        ";
        return $this->data()->fetchAllColumn($sql, 'value');
    }

    public function getActorMessages(string $actor) : ?iterable
    {
        $sql = '
            SELECT item
            FROM ark_fragment_item
            WHERE module = :module
            AND attribute = :attribute
            AND value = :value
        ';
        $params = [
            ':module' => 'message',
            ':attribute' => 'recipient',
            ':value' => $actor,
        ];

        return $this->data()->fetchAllColumn($sql, 'item', $params);
    }

    public function getRoleMessages(string $role) : ?iterable
    {
        $sql = '
            SELECT item
            FROM ark_fragment_string
            WHERE module = :module
            AND attribute = :attribute
            AND value = :value
        ';
        $params = [
            ':module' => 'message',
            ':attribute' => 'role',
            ':value' => $role,
        ];

        return $this->data()->fetchAllColumn($sql, 'item', $params);
    }

    // TODO Optimise!!!
    public function getUnreadMessages(string $actor) : ?iterable
    {
        $sql = "
            SELECT ark_fragment_item.item
            FROM ark_fragment_item, ark_fragment_datetime
            WHERE ark_fragment_item.module = 'message'
            AND   ark_fragment_item.attribute = 'recipient'
            AND   ark_fragment_item.value = :actor
            AND   ark_fragment_item.module = ark_fragment_datetime.module
            AND   ark_fragment_item.item = ark_fragment_datetime.item
            AND   ark_fragment_item.object = ark_fragment_datetime.object
            AND   ark_fragment_datetime.attribute = 'status'
            AND   ark_fragment_datetime.value = 'unread'
        ";
        $params = [
            ':actor' => $actor,
        ];
        $all = $this->data()->fetchAllColumn($sql, 'item', $params);

        return $all;
    }

    public function markMessageAsRead(string $message, string $actor) : void
    {
        $sql = "
            SELECT *
            FROM ark_fragment_item
            WHERE module = 'message'
            AND item = :message
            AND attribute = 'recipient'
            AND value = :actor
        ";
        $params = [
            ':message' => $message,
            ':actor' => $actor,
        ];
        $recipient = $this->data()->fetchAssoc($sql, $params);
        if (!$recipient) {
            return;
        }
        $sql = "
            SELECT item
            FROM ark_fragment_datetime
            WHERE module = 'message'
            AND item = :message
            AND attribute = 'read'
            AND value = :actor
            AND object = :object
        ";
        $params['object'] = $recipient['object'];
        $read = $this->data()->fetchAssoc($sql, $params);
        if ($read) {
            return;
        }
        $read = [];
        $read['module'] = 'message';
        $read['item'] = $message;
        $read['attribute'] = 'read';
        $read['object'] = $recipient['object'];
        $timestamp = ARK::timestamp()->format('Y-m-d H:i:s');
        $read['value'] = $timestamp;
        $read['creator'] = $actor;
        $read['created'] = $timestamp;
        $read['modifier'] = $actor;
        $read['modified'] = $timestamp;
        $this->data()->insert('ark_fragment_datetime', $read);
    }

    public function getItem(string $table, string $id) : ?iterable
    {
        $sql = "
            SELECT *
            FROM $table
            WHERE id = :id
        ";
        $params = [
            ':id' => $id,
        ];

        return $this->data()->fetchAssoc($sql, $params);
    }

    public function findSearch(iterable $query) : ?iterable
    {
        $pre = "
            SELECT item
            FROM ark_fragment_string
            WHERE module = 'find'
        ";
        $types = [
            Connection::PARAM_STR_ARRAY,
        ];
        $results = [];
        if (isset($query['municipality'])) {
            $sql = $pre."AND attribute = 'municipality' AND value IN (?)";
            $params = [
                $query['municipality'],
            ];
            $results['municipality'] = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['class'])) {
            $sql = $pre."AND attribute = 'class' AND value IN (?)";
            $params = [
                $query['class'],
            ];
            $results['class'] = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['period'])) {
            $sql = $pre."AND attribute = 'period' AND value IN (?)";
            $params = [
                $query['period'],
            ];
            $results['period'] = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['material'])) {
            $sql = $pre."AND attribute = 'material' AND value IN (?)";
            $params = [
                $query['material'],
            ];
            $results['material'] = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['status'])) {
            $sql = $pre."AND attribute = 'process' AND value IN (?)";
            $params = [
                $query['status'],
            ];
            $results['status'] = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['treasure'])) {
            $sql = $pre."AND attribute = 'treasure' AND value IN (?)";
            $params = [
                $query['treasure'],
            ];
            $results['treasure'] = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
        }

        $pre = "
            SELECT item
            FROM ark_fragment_item
            WHERE module = 'find'
        ";
        if (isset($query['museum'])) {
            $sql = $pre."AND attribute = 'museum' AND parameter = 'actor' AND value IN (?)";
            $params = [
                $query['museum'],
            ];
            $results['museum'] = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['finder'])) {
            $sql = $pre."AND attribute = 'finder' AND parameter = 'actor' AND value IN (?)";
            $params = [
                $query['finder'],
            ];
            $results['finder'] = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
        }
        $all = [];
        foreach ($results as $key => $items) {
            $all = array_merge($all, $items);
        }
        $all = array_unique($all);
        sort($all);
        $result = call_user_func_array('array_intersect', array_merge([$all], array_values($results)));
        return $result;
    }

    private function loadEntities() : void
    {
        if ($this->entities !== null) {
            return;
        }
        $this->entities['classname'] = [];
        $this->entities['namespace'] = [];
        $this->entities['entity'] = [];
        $this->entities['schema'] = [];
        $this->entities['module'] = [];
        $this->entities['resource'] = [];
        $sql = '
            SELECT class.classname, class.entity, class.namespace, class.class, class.superclass, class.instantiable,
                schma.schma, schma.subclasses, schma.entities, schma.vocabulary, schma.generator, schma.sequence,
                module.module, module.tbl, module.core
            FROM ark_model_class AS class, ark_model_schema AS schma, ark_model_module AS module
            WHERE class.enabled = TRUE
            AND schma.schma = class.schma
            AND schma.enabled = TRUE
            AND module.module = schma.module
            AND module.enabled = TRUE
        ';
        $entities = $this->core()->fetchAll($sql, []);
        foreach ($entities as $entity) {
            if ($entity['superclass'] || $entity['entities']) {
                $this->entities['classname'][$entity['classname']] = $entity;
                $this->entities['namespace'][$entity['namespace']][] = $entity;
            }
            $this->entities['entity'][$entity['entity']][] = $entity;
            $this->entities['schema'][$entity['schma']][] = $entity;
            $this->entities['module'][$entity['module']][] = $entity;
            $this->classnames[$entity['namespace']][] = $entity['classname'];
            if ($entity['entities'] && !$entity['superclass']) {
                $this->subclasses[$entity['schma']][] = $entity;
            }
            if ($entity['superclass']) {
                $this->entities['resource'][$entity['classname']] = $entity;
            }
        }
    }

    private function loadDatatypes() : void
    {
        if ($this->datatypes) {
            return;
        }
        $sql = '
            SELECT *
            FROM ark_dataclass_type
            WHERE enabled = true
        ';
        $datatypes = $this->core()->fetchAll($sql, []);
        foreach ($datatypes as $datatype) {
            $this->datatypes[$datatype['datatype']] = $datatype;
            if ($datatype['data_table']) {
                $this->fragmentTables[] = $datatype['data_table'];
            }
        }
    }

    private function getFragmentTable(string $datatype) : ?iterable
    {
        $this->loadDatatypes();
        return $this->datatypes[$datatype]['data_table'];
    }
}
