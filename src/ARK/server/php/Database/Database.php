<?php

/**
 * ARK Database
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
namespace ARK\Database;

use ARK\ARK;
use ARK\Error\ErrorException;
use ARK\Http\Error\InternalServerError;
use DateTime;
use Silex\Application;

class Database
{
    private $app = null;

    private $modules = [];

    private $types = [];

    private $fragmentTables = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function data()
    {
        return $this->app['dbs']['data'];
    }

    public function sequence()
    {
        return $this->app['dbs']['data'];
    }

    public function core()
    {
        return $this->app['dbs']['core'];
    }

    public function spatial()
    {
        return $this->app['dbs']['spatial'];
    }

    public function user()
    {
        return $this->app['dbs']['user'];
    }

    public function generateItemSequence(string $module, string $parent, string $sequence)
    {
        $this->data()->beginTransaction();
        // Check if there are any IDs to recycle first
        $sql = "
            SELECT *
            FROM ark_sequence_lock
            WHERE module = :module
            AND parent = :parent
            AND sequence = :sequence
            AND recycle = :recycle
        " . $this->data()
            ->platform()
            ->getWriteLockSQL();
        $params = [
            'module' => $module,
            'parent' => $parent,
            'sequence' => $sequence,
            'recycle' => true
        ];
        $recycle = $this->data()->fetchAssoc($sql, $params);
        if ($recycle && $recycle['recycle']) {
            try {
                // If there is one, try to recycle it
                $sql = "
                    UPDATE ark_sequence_lock
                    SET recycle = :recycle
                    WHERE id = :id
                ";
                $reparams = [
                    'recycle' => false,
                    'id' => $recycle['id']
                ];
                $this->data()->executeUpdate($sql, $reparams);
                $this->data()->commit();
                return $recycle['idx'];
            } catch (Exception $e) {
                // If recycle fails, just try issue the next one
                $this->data()->rollback();
                $this->data()->startTransaction();
            }
        }
        $sql = "
            SELECT *
            FROM ark_sequence
            WHERE module = :module
            AND parent = :parent
            AND sequence = :sequence
        " . $this->data()
            ->platform()
            ->getWriteLockSQL();
        unset($params['recycle']);
        $seq = $this->data()->fetchAssoc($sql, $params);
        if (! $seq) {
            // No sequence exists, so try create one
            try {
                $fields = [
                    'module',
                    'parent',
                    'sequence',
                    'idx'
                ];
                $rows = [
                    [
                        $module,
                        $parent,
                        $sequence,
                        1
                    ]
                ];
                $this->data()->insertRows('ark_sequence', $fields, $rows);
                $this->data()->insertRows('ark_sequence_lock', $fields, $rows);
                $this->data()->commit();
                return 1;
            } catch (Exception $e) {
                $this->data()->rollback();
                throw new ErrorException(new InternalServerError('DB_SEQUENCE_CREATE', 'Creating index sequence failed', "Creating the index sequence for Module $module Parent $parent Sequence $sequence failed"));
            }
        }
        if ($seq['max'] && $seq['idx'] >= $seq['max']) {
            throw new ErrorException(new InternalServerError('DB_SEQUENCE_EXHASTED', 'Index sequence exhausted', "The index sequence for Module $module Parent $parent Sequence $sequence has reached maximum"));
        }
        try {
            $sql = "
                UPDATE ark_sequence
                SET idx = idx + 1
                WHERE module = :module
                AND parent = :parent
                AND sequence = :sequence
            ";
            $this->data()->executeUpdate($sql, $params);
            $fields = [
                'module',
                'parent',
                'sequence',
                'idx'
            ];
            $rows = [
                [
                    $module,
                    $parent,
                    $sequence,
                    1
                ]
            ];
            $this->data()->insertRows('ark_sequence_lock', $fields, $rows);
            $this->data()->commit();
            return $seq['idx'] + 1;
        } catch (Exception $e) {
            $this->data()->rollback();
            throw new ErrorException(new InternalServerError('DB_SEQUENCE_INCREMENT', 'Increment index sequence failed', "Incrementing the index sequence failed for Module $module Parent $parent Sequence $sequence"));
        }
    }

    private function loadModules()
    {
        if ($this->modules) {
            return;
        }
        $sql = "
            SELECT *
            FROM ark_module
        ";
        $modules = $this->core()->fetchAll($sql, array());
        foreach ($modules as $module) {
            $this->modules[$module['module']] = $module;
        }
    }

    public function getModuleTable(string $module)
    {
        $this->loadModules();
        return $this->modules[$module]['tbl'];
    }

    public function getModule(string $module)
    {
        $this->loadModules();
        $module = strtolower($module);
        if (isset($this->modules[$module])) {
            return $this->modules[$module];
        }
        foreach ($this->modules as $mod) {
            if ($mod['resource'] == $module) {
                return $mod;
            }
        }
        return null;
    }

    public function getModuleForClassName(string $className)
    {
        $this->loadModules();
        foreach ($this->modules as $module) {
            if ($module['classname'] == $className) {
                return $module;
            }
        }
        return null;
    }

    public function getModuleForNamespace(string $namespace)
    {
        $this->loadModules();
        foreach ($this->modules as $module) {
            if ($module['namespace'] == $namespace) {
                return $module;
            }
        }
        return null;
    }

    public function getModules()
    {
        $this->loadModules();
        return $this->modules;
    }

    private function loadTypes()
    {
        if ($this->types) {
            return;
        }
        $sql = "
            SELECT *
            FROM ark_datatype_type
            WHERE enabled = true
        ";
        $types = $this->core()->fetchAll($sql, []);
        foreach ($types as $type) {
            $this->types[$type['type']] = $type;
            if ($type['data_table']) {
                $this->fragmentTables[] = $type['data_table'];
            }
        }
    }

    public function getTypes()
    {
        $this->loadTypes();
        return $this->types;
    }

    private function getFragmentTable(string $type)
    {
        $this->loadTypes();
        return $this->types[$type]['data_table'];
    }

    public function getFragmentType(string $class)
    {
        $this->loadTypes();
        foreach ($this->types as $type => $attributes) {
            if ($attributes['data_class'] === $class) {
                return $attributes;
            }
        }
        return [];
    }

    public function getFragmentTables()
    {
        $this->loadTypes();
        return $this->fragmentTables;
    }

    public function getTypeEntities(string $module)
    {
        $sql = "
            SELECT ark_vocabulary_parameter.term as type, ark_vocabulary_parameter.value as classname
            FROM ark_schema, ark_vocabulary_parameter
            WHERE ark_schema.module = :module
            AND ark_schema.enabled = true
            AND ark_schema.entities = true
            AND ark_vocabulary_parameter.concept = ark_schema.vocabulary
            AND ark_vocabulary_parameter.name = :parameter
        ";
        $params = array(
            ':module' => $module,
            ':parameter' => 'classname'
        );
        return $this->core()->fetchAll($sql, $params);
    }

    public function getViewTypes()
    {
        return $this->core()->fetchAllTable('ark_view_type');
    }

    public function getTranslationMessages(string $language, string $domain = null)
    {
        $sql = "
            SELECT *
            FROM ark_translation_message
            WHERE language = :language
        ";
        $params[':language'] = $language;
        if ($domain) {
            $sql .= "
                AND domain = :domain
            ";
            $params[':domain'] = $domain;
        }
        return $this->core()->fetchAll($sql, $params);
    }

    public function getActorNames()
    {
        $sql = "
            SELECT *
            FROM ark_item_actor, ark_fragment_string
            WHERE ark_fragment_string.module = :module
            AND ark_fragment_string.item = ark_item_actor.item
            AND ark_fragment_string.attribute = :attribute
        ";
        $params = array(
            ':module' => 'act',
            ':attribute' => 'name'
        );
        return $this->data()->fetchAll($sql, $params);
    }

    public function getFlashes(string $language)
    {
        $sql = "
            SELECT *
            FROM ark_config_flash
            WHERE language = :language
            AND active = :active
        ";
        $params = array(
            ':language' => $language,
            ':active' => true
        );
        return $this->core()->fetchAll($sql, $params);
    }

    // Spatial
    public function getSpatialTerms(string $concept, string $type = null)
    {
        $sql = "
            SELECT term, ST_AsText(geometry) as geometry, srid
            FROM ark_spatial_term
            WHERE concept = :concept
        ";
        $params[':concept'] = $concept;
        if ($type) {
            $sql .= "AND type = :type";
            $params[':type'] = $type;
        }
        return $this->spatial()->fetchAll($sql, $params);
    }

    public function getSpatialTermsContain(string $concept, string $wkt, string $srid)
    {
        $sql = "
            SELECT term
            FROM dime_ark_spatial.ark_spatial_term
            WHERE concept = :concept
            AND ST_Contains(geometry, ST_GeometryFromText(:point, :srid))
        ";
        $params = array(
            ':concept' => $concept,
            ':point' => $wkt,
            ':srid' => $srid
        );
        return $this->spatial()->fetchColumn($sql, $params);
    }

    public function getSpatialTermChoropleth(string $concept, string $module, string $attribute, bool $items = false)
    {
        $sql = "
            SELECT ark_spatial_term.term, count(*) as count
            FROM ark_spatial_fragment, ark_spatial_term
            WHERE ST_Contains(ark_spatial_term.geometry, ark_spatial_fragment.geometry)
            AND ark_spatial_term.concept = :concept
            AND ark_spatial_fragment.module = :module
            AND ark_spatial_fragment.attribute = :attribute";
        if (gettype($items) == 'array') {
            $sql .= " AND (";
            foreach ($items as $key => $item) {
                $sql .= "
                    ark_spatial_fragment.item = :item$key
                ";
                if ($key < count($items) - 1) {
                    $sql .= " OR ";
                } else {
                    $sql .= ") ";
                }
            }
        }

        $sql .= "
            GROUP BY ark_spatial_term.term
        ";
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

    public function getMunicipalityMuseum(string $municipality)
    {
        $sql = "
            SELECT item
            FROM ark_fragment_string
            WHERE module = :module
            AND parameter = :parameter
            AND value = :value
        ";
        $params = array(
            ':module' => 'actor',
            ':parameter' => 'dime.denmark.municipality',
            ':value' => $municipality
        );
        return $this->data()->fetchColumn($sql, $params);
    }

    public function getActorFinds(string $actor)
    {
        $sql = "
            SELECT item
            FROM ark_fragment_item
            WHERE module = 'find'
            AND (attribute = 'finder'
              OR attribute = 'owner'
              OR attribute = 'custodian')
            AND value = :actor
        ";
        $params = array(
            ':actor' => $actor
        );
        return $this->data()->fetchAllColumn($sql, 'item', $params);
    }

    public function getActorMessages(string $actor)
    {
        $sql = "
            SELECT item
            FROM ark_fragment_item
            WHERE module = :module
            AND attribute = :attribute
            AND value = :value
        ";
        $params = array(
            ':module' => 'message',
            ':attribute' => 'recipient',
            ':value' => $actor
        );
        return $this->data()->fetchAllColumn($sql, 'item', $params);
    }

    // TODO Optimise!!!
    public function getUnreadMessages(string $actor)
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
        $params = array(
            ':actor' => $actor
        );
        $all = $this->data()->fetchAllColumn($sql, 'item', $params);
        return $all;
    }

    public function markMessageAsRead(string $message, string $actor)
    {
        $sql = "
            SELECT *
            FROM ark_fragment_item
            WHERE module = 'message'
            AND item = :message
            AND attribute = 'recipient'
            AND value = :actor
        ";
        $params = array(
            ':message' => $message,
            ':actor' => $actor,
        );
        $recipient = $this->data()->fetchAssoc($sql, $params);
        if (!$recipient) {
            return null;
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
            return null;
        }
        $read = [];
        $read['module'] = 'message';
        $read['item'] = $message;
        $read['attribute'] = 'read';
        $read['object'] = $recipient['object'];
        $timestamp = ARK::timestamp()->format(DateTime::ATOM);
        $read['value'] = $timestamp;
        if ($result = $this->data()->insert('ark_fragment_datetime', $read)) {
            return $timestamp;
        }
        return null;
    }

    public function userSearch(string $query)
    {
        $sql = "
            SELECT item
            FROM ark_fragment_string
            WHERE module = 'actor'
            AND attribute = 'status'
            AND value = :status
        ";
        return $this->data()->fetchAllColumn($sql, 'item', $query);
    }

    public function findSearch(array $query)
    {
        $pre = "
            SELECT item
            FROM ark_fragment_string
            WHERE module = 'find'
        ";
        $types = [
            \Doctrine\DBAL\Connection::PARAM_STR_ARRAY
        ];
        $res = [];
        if (isset($query['municipality'])) {
            $sql = $pre . "AND attribute = 'municipality' AND value IN (?)";
            $params = [
                $query['municipality']
            ];
            $res = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
        }
        if (isset($query['type'])) {
            $sql = $pre . "AND attribute = 'type' AND value IN (?)";
            $params = [
                $query['type']
            ];
            $typ = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
            $res = ($res ? array_intersect($res, $typ) : $typ);
        }
        if (isset($query['period'])) {
            $sql = $pre . "AND attribute = 'period' AND value IN (?)";
            $params = [
                $query['period']
            ];
            $prd = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
            $res = ($res ? array_intersect($res, $prd) : $prd);
        }
        if (isset($query['material'])) {
            $sql = $pre . "AND attribute = 'material' AND value IN (?)";
            $params = [
                $query['material']
            ];
            $mat = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
            $res = ($res ? array_intersect($res, $mat) : $mat);
        }
        if (isset($query['status'])) {
            $sql = $pre . "AND attribute = 'process' AND value IN (?)";
            $params = [
                $query['status']
            ];
            $sta = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
            $res = ($res ? array_intersect($res, $sta) : $sta);
        }
        if (isset($query['treasure'])) {
            $sql = $pre . "AND attribute = 'treasure' AND value IN (?)";
            $params = [
                $query['treasure']
            ];
            $tre = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
            $res = ($res ? array_intersect($res, $tre) : $tre);
        }

        $pre = "
            SELECT item
            FROM ark_fragment_item
            WHERE module = 'find'
        ";
        if (isset($query['museum'])) {
            $sql = $pre . "AND attribute = 'museum' AND parameter = 'actor' AND value IN (?)";
            $params = [
                $query['museum']
            ];
            $mus = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
            $res = ($res ? array_intersect($res, $mus) : $mus);
        }
        if (isset($query['finder'])) {
            $sql = $pre . "AND attribute = 'finder' AND parameter = 'actor' AND value IN (?)";
            $params = [
                $query['finder']
            ];
            $fin = $this->data()->fetchAllColumn($sql, 'item', $params, $types);
            $res = ($res ? array_intersect($res, $fin) : $fin);
        }

        return $res;
    }
}
