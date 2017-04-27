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
use ARK\Model\Attribute;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class Schema
{
    use EnabledTrait;
    use KeywordTrait;

    protected $schma = '';
    protected $module = null;
    protected $generator = '';
    protected $sequence = '';
    protected $type = null;
    protected $vocabulary = null;
    protected $entities = false;
    protected $model = null;
    protected $types = [];
    protected $attributes = null;
    protected $associations = null;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
        $this->associations = new ArrayCollection();
    }

    private function init()
    {
        if ($this->model === null) {
            $module = $this->module->name();
            $this->model[$module]['attributes'] = [];
            $this->model[$module]['allattributes'] = [];
            $this->model[$module]['associations'] = [];
            $this->model[$module]['allassociations'] = [];
            if ($this->vocabulary) {
                foreach ($this->vocabulary->terms() as $term) {
                    $type = $term->name();
                    $this->types[] = $type;
                    $this->model[$type]['type'] = $type;
                    $this->model[$type]['attributes'] = [];
                    $this->model[$type]['associations'] = [];
                }
            }
            foreach ($this->attributes as $attribute) {
                $this->model[$module]['allattributes'][$attribute->name()] = $attribute;
                $this->model[$attribute->type()]['attributes'][$attribute->name()] = $attribute;
            }
            foreach ($this->associations as $association) {
                $this->model[$module]['allassociations'][$association->name()] = $association;
                $this->model[$association->type()]['associations'][$association->name()] = $association;
            }
        }
    }

    protected function checkType($type)
    {
        $this->init();
        if ($type) {
            if (!$this->useTypes()) {
                throw new ErrorException(new Error('SURPLUS_TYPE', 'Type not required', "The Schema '$this->schma' does not require a Type."));
            }
            if (!in_array($type, $this->types)) {
                throw new ErrorException(new Error('INVALID_TYPE', 'Invalid Type', "The Type '$type' is invalid."));
            }
        } elseif ($this->useTypes()) {
            throw new ErrorException(new Error('MISSING_TYPE', 'Missing Type', "The Type for Schema '$this->schma' is required."));
        }
        return ($type ?: $this->module->name());
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

    public function useTypeEntities()
    {
        return $this->entities;
    }

    public function typeName()
    {
        return $this->type;
    }

    public function typeNames()
    {
        $this->init();
        return $this->types;
    }

    public function attributes($type = null, $all = true)
    {
        $this->init();
        $type = $this->checkType($type);
        $attributes = array_values($this->model[$type]['attributes']);
        if ($type != $this->module->name() && $all) {
            return array_merge(array_values($this->model[$this->module->name()]['attributes']), $attributes);
        }
        return $attributes;
    }

    public function hasAttribute($attribute, $type = null)
    {
        return in_array($attribute, $this->attributeNames($type));
    }

    public function attributeNames($type = null, $all = true)
    {
        $this->init();
        $type = $this->checkType($type);
        $names = array_keys($this->model[$type]['attributes']);
        if ($type != $this->module->name() && $all) {
            return array_merge(array_keys($this->model[$this->module->name()]['attributes']), $names);
        }
        return $names;
    }

    public function attribute($attribute)
    {
        $this->init();
        return (
            isset($this->model[$this->module->name()]['allattributes'][$attribute])
            ? $this->model[$this->module->name()]['allattributes'][$attribute]
            : null
        );
    }

    public function associations($type = null, $all = true)
    {
        $this->init();
        $type = $this->checkType($type);
        $associations = array_values($this->model[$type]['associations']);
        if ($type != $this->module->name() && $all) {
            return array_merge(array_values($this->model[$this->module->name()]['associations']), $associations);
        }
        return $associations;
    }

    public function hasAssociation($association, $type = null)
    {
        return in_array($association, $this->associationNames($type));
    }

    public function associationNames($type = null, $all = true)
    {
        $this->init();
        $type = $this->checkType($type);
        $names = array_keys($this->model[$type]['associations']);
        if ($type != $this->module->name() && $all) {
            return array_merge(array_keys($this->model[$this->module->name()]['associations']), $names);
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
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_schema');

        // Key
        $builder->addStringKey('schma', 30);

        // Fields
        $builder->addManyToOneField('module', 'ARK\Model\Module', null, null, false);
        $builder->addStringField('generator', 30);
        $builder->addStringField('sequence', 30);
        $builder->addStringField('type', 30);
        $builder->addField('entities', 'boolean', [], 'entities');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addManyToOneField('vocabulary', 'ARK\Vocabulary\Vocabulary', 'vocabulary', 'concept');
        $builder->addOneToMany('attributes', 'ARK\Model\Schema\SchemaAttribute', 'schma');
        $builder->addOneToMany('associations', 'ARK\Model\Schema\SchemaAssociation', 'schma');
        $builder->setReadOnly();
    }
}
