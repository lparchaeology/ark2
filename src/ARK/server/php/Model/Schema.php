<?php

/**
 * ARK Model Schema
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

namespace ARK\Model;

use ARK\Error\Error;
use ARK\Error\ErrorException;
use ARK\Model\EnabledTrait;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class Schema
{
    use EnabledTrait;
    use KeywordTrait;

    protected $schma = '';
    protected $module = null;
    protected $generator = '';
    protected $sequence = '';
    protected $type = false;
    protected $model = null;
    protected $types = null;
    protected $attributes = null;
    protected $associations = null;

    public function __construct()
    {
        $this->types = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->associations = new ArrayCollection();
    }

    private function init()
    {
        if ($this->model === null) {
            $this->model['']['attributes'] = [];
            $this->model['']['allattributes'] = [];
            $this->model['']['associations'] = [];
            $this->model['']['allassociations'] = [];
            foreach ($this->types as $type) {
                $this->model[$type->name()]['type'] = $type;
                $this->model[$type->name()]['attributes'] = [];
                $this->model[$type->name()]['associations'] = [];
            }
            foreach ($this->attributes as $attribute) {
                $this->model['']['allattributes'][$attribute->name()] = $attribute;
                $this->model[$attribute->typeName()]['attributes'][$attribute->name()] = $attribute;
            }
            foreach ($this->associations as $association) {
                $this->model['']['allassociations'][$association->name()] = $association;
                $this->model[$association->typeName()]['associations'][$association->name()] = $association;
            }
        }
    }

    public function checkType($type)
    {
        if (is_object($type)) {
            if (!$type instanceof SchemaType) {
                throw new ErrorException(new Error('SUBTYPE_EXPECTED', 'Type expected', 'Expected an instance of SchemaType or a Type name.'));
            }
            $type = $type->name();
        }
        if ($type) {
            if (!$this->useTypes()) {
                throw new ErrorException(new Error('SURPLUS_SUBTYPE', 'Type not required', "The Schema '$this->schma' does not require a Type."));
            }
            if (!in_array($type, $this->typeNames())) {
                throw new ErrorException(new Error('INVALID_SUBTYPE', 'Invalid Type', "The Type '$type' is invalid."));
            }
        } elseif ($this->useTypes()) {
            throw new ErrorException(new Error('MISSING_SUBTYPE', 'Missing Type', "The Type for Schema '$this->schma' is required."));
        }
        return $type;
    }

    public function name()
    {
        return $this->schma;
    }

    public function module()
    {
        return $this->module;
    }

    public function generator()
    {
        return $this->generator;
    }

    public function sequence()
    {
        return $this->sequence;
    }

    public function useTypes()
    {
        return (bool) $this->type;
    }

    public function typeName()
    {
        return $this->type;
    }

    public function types()
    {
        return $this->types;
    }

    public function typeNames()
    {
        $this->init();
        if ($this->useTypes()) {
            return array_keys($this->model);
        }
        return [];
    }

    public function type($name)
    {
        $this->init();
        return ($name && isset($this->model[$name]) ? $this->model[$name]['type'] : null);
    }

    public function attributes($type = null, $all = true)
    {
        $this->init();
        $this->checkType($type);
        $attributes = array_values($this->model[$type]['attributes']);
        if ($type && $all) {
            return array_merge(array_values($this->model['']['attributes']), $attributes);
        }
        return $attributes;
    }

    public function attributeNames($type = '', $all = true)
    {
        $this->init();
        $type = $this->checkType($type);
        $names = array_keys($this->model[$type]['attributes']);
        if ($type && $all) {
            return array_merge(array_keys($this->model['']['attributes']), $names);
        }
        return $names;
    }

    public function attribute($attribute)
    {
        $this->init();
        return (isset($this->model['']['allattributes'][$attribute]) ? $this->model['']['allattributes'][$attribute] : null);
    }

    public function associations($type = '', $all = true)
    {
        $this->init();
        $type = $this->checkType($type);
        $associations = array_values($this->model[$type]['associations']);
        if ($type && $all) {
            return array_merge(array_values($this->model['']['associations']), $associations);
        }
        return $associations;
    }

    public function associationNames($type = '', $all = true)
    {
        $this->init();
        $type = $this->checkType($type);
        $names = array_keys($this->model[$type]['associations']);
        if ($type && $all) {
            return array_merge(array_keys($this->model['']['associations']), $names);
        }
        return $names;
    }

    public function association($association)
    {
        return (
            isset($this->model[$type]['allassociations'][$association])
            ? $this->model[$type]['allassociations'][$association]
            : null
        );
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_schema');
        $builder->addStringKey('schma', 30);
        $builder->addManyToOneField('module', 'ARK\Model\Module', null, null, false);
        $builder->addStringField('generator', 100);
        $builder->addStringField('sequence', 30);
        $builder->addStringField('type', 30);
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addOneToMany('types', 'ARK\Model\Schema\SchemaType', 'schma');
        $builder->addOneToMany('attributes', 'ARK\Model\Schema\SchemaAttribute', 'schma');
        $builder->addOneToMany('associations', 'ARK\Model\Schema\SchemaAssociation', 'schma');
        $builder->setReadOnly();
    }
}