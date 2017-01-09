<?php

/**
 * ARK Schema
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

namespace ARK\Schema;

use ARK\EnabledTrait;
use ARK\Error\Error;
use ARK\Error\ErrorException;
use ARK\KeywordTrait;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Schema\SchemaSubtype;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\ClassMetadata;

class Schema
{
    use EnabledTrait;
    use KeywordTrait;

    protected $schma = '';
    protected $module = null;
    protected $entity = '';
    protected $generator = '';
    protected $sequence = '';
    protected $useSubtypes = false;
    protected $model = null;
    protected $subtypes = null;
    protected $properties = null;
    protected $associations = null;

    public function __construct()
    {
        $this->subtypes = new Collection();
        $this->properties = new Collection();
        $this->associations = new Collection();
    }

    private function init()
    {
        if ($this->model === null) {
            $this->model['']['properties'] = [];
            $this->model['']['associations'] = [];
            foreach ($this->subtypes as $subtype) {
                $this->model[$subtype->name()]['subtype'] = $subtype;
                $this->model[$subtype->name()]['properties'] = [];
                $this->model[$subtype->name()]['associations'] = [];
            }
            foreach ($this->properties as $property) {
                $this->model[$property->subtypeName()]['properties'][$property->name()] = $property;
            }
            foreach ($this->associations as $association) {
                $this->model[$association->subtypeName()]['associations'][$association->name()] = $association;
            }
        }
    }

    public function checkSubtype($subtype)
    {
        if (is_object($subtype)) {
            if (!$subtype instanceof SchemaSubtype) {
                throw new ErrorException(new Error('SUBTYPE_EXPECTED', 'Subtype expected', 'Expected an instance of SchemaSubtype or a Subtype name.'));
            }
            $subtype = $subtype->name();
        }
        if ($subtype) {
            if (!$this->useSubtypes) {
                throw new ErrorException(new Error('SURPLUS_SUBTYPE', 'Subtype not required', "The Schema '$this->schma' does not require a Subtype."));
            }
            if (!in_array($subtype, $this->subtypeNames())) {
                throw new ErrorException(new Error('INVALID_SUBTYPE', 'Invalid Subtype', "The Subtype '$subtype' is invalid."));
            }
        } elseif ($this->useSubtypes) {
            throw new ErrorException(new Error('MISSING_SUBTYPE', 'Missing Subtype', "The Subtype for Schema '$this->schma' is required."));
        }
        return $subtype;
    }

    public function name()
    {
        return $this->schma;
    }

    public function module()
    {
        return $this->module;
    }

    public function entity()
    {
        return $this->entity;
    }

    public function generator()
    {
        return $this->generator;
    }

    public function sequence()
    {
        return $this->sequence;
    }

    public function useSubtypes()
    {
        return $this->useSubtypes;
    }

    public function subtypes()
    {
        return $this->subtypes;
    }

    public function subtypeNames()
    {
        $this->init();
        if ($this->useSubtypes()) {
            return array_keys($this->model);
        }
        return [];
    }

    public function subtype($subtype)
    {
        $this->init();
        return (isset($this->model[$subtype]) ? $this->model[$subtype]['subtype'] : null);
    }

    public function properties($subtype = null, $all = true)
    {
        $this->init();
        $this->checkSubtype($subtype);
        $properties = array_values($this->model[$subtype]['properties']);
        if ($subtype && $all) {
            return array_merge(array_values($this->model['']['properties']), $properties);
        }
        return $properties;
    }

    public function propertyNames($subtype = '', $all = true)
    {
        $this->init();
        $subtype = $this->checkSubtype($subtype);
        $names = array_keys($this->model[$subtype]['properties']);
        if ($subtype && $all) {
            return array_merge(array_keys($this->model['']['properties']), $names);
        }
        return $names;
    }

    public function property($property, $subtype = null)
    {
        $this->init();
        return (isset($this->model[$subtype]['properties'][$property]) ? $this->model[$subtype]['properties'][$property] : null);
    }

    public function associations($subtype = '', $all = true)
    {
        $this->init();
        $subtype = $this->checkSubtype($subtype);
        $associations = array_values($this->model[$subtype]['associations']);
        if ($subtype && $all) {
            return array_merge(array_values($this->model['']['associations']), $associations);
        }
        return $associations;
    }

    public function associationNames($subtype = '', $all = true)
    {
        $this->init();
        $subtype = $this->checkSubtype($subtype);
        $names = array_keys($this->model[$subtype]['associations']);
        if ($subtype && $all) {
            return array_merge(array_keys($this->model['']['associations']), $names);
        }
        return $names;
    }

    public function association($association, $subtype = null)
    {
        return (
            isset($this->model[$subtype]['associations'][$association])
            ? $this->model[$subtype]['associations'][$association]
            : null
        );
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_schema');
        $builder->addStringKey('schma', 30);
        $builder->addManyToOneField('module', 'Module', null, null, false);
        $builder->addStringField('entity', 100);
        $builder->addStringField('generator', 100);
        $builder->addStringField('sequence', 30);
        $builder->addField('useSubtypes', 'boolean', [], 'use_subtypes');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addOneToMany('subtypes', 'SchemaSubtype', 'schma');
        $builder->addOneToMany('properties', 'SchemaProperty', 'schma');
        $builder->addOneToMany('associations', 'SchemaAssociation', 'schma');
        $builder->setReadOnly();
    }
}
