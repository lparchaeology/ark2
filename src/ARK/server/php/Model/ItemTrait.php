<?php

/**
 * ARK Model Item Trait
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

use ARK\Model\Schema;
use ARK\Model\VersionTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\ORM\ORM;
use ARK\Service;

trait ItemTrait
{
    use VersionTrait;

    protected $id = '';
    protected $parentModule = null;
    protected $parentId = null;
    protected $parent = null;
    protected $idx = null;
    protected $type = '';
    protected $label = null;
    protected $schma = null;
    protected $schema = null;
    protected $properties = null;
    protected $meta = null;

    protected function makeIdentifier($parentId, $sep, $index)
    {
        return ($parentId && $index ? $parentId.$sep.$index : $index);
    }

    public function id()
    {
        return $this->id;
    }

    public function parent()
    {
        if ($this->parentId && !$this->parent) {
            $this->parent = ORM::find($this->schema()->parent()->entity(), $this->parentId);
        }
        return $this->parent;
    }

    public function index()
    {
        return $this->idx;
    }

    public function setIndex($index)
    {
        // TODO Do parent correctly!!!
        $this->idx = $index;
        $this->label = $this->makeIdentifier($this->parentId, '_', $index);
    }

    public function label()
    {
        return $this->label;
    }

    private function typeName()
    {
        if (!$this->meta) {
            $this->meta = ORM::repository(get_class())->metadata();
            if ($this->meta->discriminatorValue) {
                $this->type = $this->meta->discriminatorValue;
            }
        }
        return $this->type;
    }

    public function type()
    {
        return $this->schema()->type($this->typeName());
    }

    public function setType($type)
    {
        // TODO Danger, Will Robinson!!!
        $this->type = $type;
    }

    public function schema()
    {
        if (!$this->schema) {
            $this->schema = ORM::find(Schema::class, $this->schma);
        }
        return $this->schema;
    }

    public function attributes()
    {
        return $this->schema()->attributes($this->typeName());
    }

    public function path()
    {
        if ($this->parent()) {
            return $this->parent()->path().'/'.$this->index();
        }
        return '/'.$this->index();
    }

    public function properties()
    {
        foreach ($this->attributes() as $attribute) {
            if (!isset($this->properties[$attribute->name()])) {
                $this->properties[$attribute->name()] = new Property($this, $attribute);
            }
        }
        return array_values($this->properties);
    }

    public function propertyArray()
    {
        foreach ($this->attributes() as $attribute) {
            if (!isset($this->properties[$attribute->name()])) {
                $this->properties[$attribute->name()] = new Property($this, $attribute);
            }
        }
        return $this->properties;
    }

    public function property($attribute)
    {
        if (!isset($this->properties[$attribute])) {
            $this->properties[$attribute] = new Property($this, $this->schema()->attribute($attribute, $this->typeName()));
        }
        return $this->properties[$attribute];
    }

    private function loadRelated()
    {
        if ($this->related) {
            return;
        }
        foreach ($this->relationships() as $module) {
            $this->related[$module->id()] = $this->em->repository($module->id())->getRelated($this->module(), $this->id());
        }
    }

    public function related($module = null)
    {
        $this->loadRelated();
        if ($module) {
            if (isset($this->related[$module])) {
                return $this->related[$module];
            }
            return [];
        }
        return $this->related;
    }

    public function relationships()
    {
        if ($this->parent) {
            return $this->parent->schema->xmis($this->parent->schemaId(), $this->module());
        }
        return [];
    }

    public static function buildItemMetadata($metadata, $module)
    {
        // Table
        $mod = Service::database()->getModule($module);
        $builder = new ClassMetadataBuilder($metadata, $mod['tbl']);
        $builder->setCustomRepositoryClass('ARK\ORM\ItemEntityRepository');

        // Key
        $builder->addStringKey('id', 30);

        // Fields
        $builder->addStringField('schma', 30);
        $typeEntities = Service::database()->getTypeEntities($module);
        if ($typeEntities) {
            $builder->setSingleTableInheritance()->setDiscriminatorColumn('type', 'string', 30);
            $metadata->addDiscriminatorMapClass('', $mod['entity']);
            foreach ($typeEntities as $type) {
                $metadata->addDiscriminatorMapClass($type['type'], $type['entity']);
            }
        } else {
            $builder->addStringField('type', 30);
        }
        $builder->addStringField('parentModule', 30, 'parent_module');
        $builder->addStringField('parentId', 30, 'parent_id');
        $builder->addStringField('idx', 30);
        $builder->addStringField('label', 30);
        VersionTrait::buildVersionMetadata($builder);
        $metadata->setItemEntity(true);

        // Set ID Generator TODO Move elsewhere, say ClassMetadata? Table driven?
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_CUSTOM);
        $metadata->setCustomGeneratorDefinition(['class' => 'ARK\ORM\ItemSequenceGenerator']);
    }
}
