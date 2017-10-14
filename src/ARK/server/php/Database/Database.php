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
    private $modules = [];
    private $datatypes = [];
    private $fragmentTables = [];

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

    public function getModule(string $module) : ?iterable
    {
        $this->loadModules();
        $module = strtolower($module);
        if (isset($this->modules[$module])) {
            return $this->modules[$module];
        }
        foreach ($this->modules as $mod) {
            if ($mod['resource'] === $module) {
                return $mod;
            }
        }
        return null;
    }

    public function getModuleForClassName(string $className) : ?iterable
    {
        $this->loadModules();
        foreach ($this->modules as $module) {
            if ($module['classname'] === $className) {
                return $module;
            }
        }
        return null;
    }

    public function getModuleForNamespace(string $namespace) : ?iterable
    {
        $this->loadModules();
        foreach ($this->modules as $module) {
            if ($module['namespace'] === $namespace) {
                return $module;
            }
        }
        return null;
    }

    public function getModules() : ?iterable
    {
        $this->loadModules();
        return $this->modules;
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

    public function getAllClassNames($namespace, $recurse = true) : ?iterable
    {
        if ($recurse) {
            $sql = '
                SELECT DISTINCT classname
                FROM ark_model_class
                WHERE namespace LIKE :namespace
                AND enabled = true
            ';
            $params = [
                ':namespace' => $namespace.'\\%',
            ];
        } else {
            $sql = '
                SELECT DISTINCT classname
                FROM ark_model_class
                WHERE namespace = :namespace
                AND enabled = true
            ';
            $params = [
                ':namespace' => $namespace,
            ];
        }
        return $this->core()->fetchAllColumn($sql, 'classname', $params);
    }

    public function getSubclassEntities(string $schema) : ?iterable
    {
        $sql = '
            SELECT DISTINCT namespace, classname, entity
            FROM ark_model_class
            WHERE schma LIKE :schema
            AND enabled = true
        ';
        $sql = '
            SELECT ark_vocabulary_parameter.term as class, ark_vocabulary_parameter.value as entity
            FROM ark_model_schema, ark_vocabulary_parameter
            WHERE ark_model_schema.module = :module
            AND ark_model_schema.enabled = true
            AND ark_model_schema.entities = true
            AND ark_vocabulary_parameter.concept = ark_model_schema.vocabulary
            AND ark_vocabulary_parameter.name = :parameter
        ';
        $params = [
            ':module' => $module,
            ':parameter' => 'entity',
        ];

        return $this->core()->fetchAll($sql, $params);
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

    private function loadModules() : void
    {
        if ($this->modules) {
            return;
        }
        $sql = '
            SELECT *
            FROM ark_model_module
        ';
        $modules = $this->core()->fetchAll($sql, []);
        foreach ($modules as $module) {
            $this->modules[$module['module']] = $module;
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
