<?php

/**
 * ARK Database.
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

namespace ARK\Database;

use ARK\ARK;
use ARK\Service;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Type;

class Database
{
    private $entities;
    private $subclasses;
    private $classnames;
    private $datatypes;
    private $fragmentTables;

    public function data() : Connection
    {
        return Service::connection('data');
    }

    public function sequence() : Connection
    {
        return Service::connection('data');
    }

    public function config() : Connection
    {
        return Service::connection('config');
    }

    public function spatial() : Connection
    {
        return Service::connection('spatial');
    }

    public function user() : Connection
    {
        return Service::connection('user');
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
        return $this->config()->fetchAllTable('ark_view_type');
    }

    public function getTranslationMessages(string $language, string $domain = null) : ?iterable
    {
        $sql = '
            SELECT *
            FROM ark_translation, ark_translation_message
            WHERE ark_translation_message.language = :language
            AND ark_translation.keyword = ark_translation_message.keyword
        ';
        $params[':language'] = $language;
        if ($domain) {
            $sql .= '
                AND ark_translation.domain = :domain
            ';
            $params[':domain'] = $domain;
        }

        return $this->config()->fetchAll($sql, $params);
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

    // Spatial
    public function getSpatialTerms(string $concept, string $level = 'full', string $type = null) : ?iterable
    {
        $sql = '
            SELECT term, ST_AsText(geometry) as geometry, srid
            FROM ark_spatial_term
            WHERE concept = :concept
            AND level = :level
        ';
        $params[':concept'] = $concept;
        $params[':level'] = $level;
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
            FROM ark_spatial_term
            WHERE concept = :concept
            AND level = :level
            AND ST_Contains(geometry, ST_GeometryFromText(:point, :srid))
        ';
        $params = [
            ':concept' => $concept,
            ':level' => 'full',
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
            AND ark_spatial_term.level = :level
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
        $params[':level'] = 'full';
        $params[':module'] = $module;
        $params[':attribute'] = $attribute;
        if ($items) {
            foreach ($items as $key => $item) {
                $params[":item$key"] = $item;
            }
        }

        return $this->spatial()->fetchAll($sql, $params);
    }

    // Load the Global custom Types
    public static function setType(string $name, string $class) : void
    {
        if (Type::hasType($name)) {
            Type::overrideType($name, $class);
        } else {
            Type::addType($name, $class);
        }
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
            SELECT term.entity, term.namespace, term.term as class,
                vocabulary.entity as base_entity, vocabulary.namespace as base_namespace,
                schma.schma, schma.subclasses, schma.class_vocabulary, schma.generator, schma.sequence,
                module.module, module.tbl, module.core
            FROM ark_vocabulary_term AS term,
                ark_vocabulary as vocabulary,
                ark_model_schema AS schma,
                ark_model_module AS module
            WHERE vocabulary.concept = term.concept
            AND vocabulary.enabled = TRUE
            AND schma.class_vocabulary = vocabulary.concept
            AND schma.enabled = TRUE
            AND module.module = schma.module
            AND module.enabled = TRUE
        ';
        $entities = $this->config()->fetchAll($sql, []);
        //dump($entities);
        foreach ($entities as $entity) {
            if (!isset($entity['namespace']) || $entity['namespace'] === null) {
                $entity['namespace'] = $entity['base_namespace'];
                $entity['entity'] = $entity['base_entity'];
            }
            $entity['classname'] = $entity['namespace'].'\\'.$entity['entity'];
            $entity['superclass'] = ($entity['class'] === $entity['module']);
            if ($entity['superclass'] || $entity['subclasses']) {
                $this->entities['classname'][$entity['classname']] = $entity;
                $this->entities['namespace'][$entity['namespace']][] = $entity;
            }
            $this->entities['entity'][$entity['entity']][] = $entity;
            $this->entities['schema'][$entity['schma']][] = $entity;
            $this->entities['module'][$entity['module']][] = $entity;
            $this->classnames[$entity['namespace']][] = $entity['classname'];
            if ($entity['subclasses'] && !$entity['superclass']) {
                $this->subclasses[$entity['schma']][] = $entity;
            }
            if ($entity['superclass']) {
                $this->entities['resource'][$entity['classname']] = $entity;
            }
        }
        //dump($this->entities);
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
        $datatypes = $this->config()->fetchAll($sql, []);
        foreach ($datatypes as $datatype) {
            $this->datatypes[$datatype['datatype']] = $datatype;
            if ($datatype['data_table']) {
                $this->fragmentTables[] = $datatype['data_table'];
            }
        }
    }
}
