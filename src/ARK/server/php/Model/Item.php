<?php

/**
 * ARK Item Entity
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

namespace ARK\Model;

use ARK\Error\ErrorException;
use ARK\Model\EntityTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Schema\Schema;
use ARK\Schema\SchemaSubtype;
use ARK\Service;
use Doctrine\Common\Collections\Collection;

abstract class Item
{
    use EntityTrait;

    protected $id = '';
    protected $parentModule = null;
    protected $parentId = null;
    protected $parent = null;
    protected $idx = null;
    protected $name = null;
    protected $subtype = '';
    protected $schma = null;
    protected $schema = null;
    protected $properties = null;
    protected $valid = false;

    protected function makeIdentifier($parentId, $sep, $index)
    {
        return ($parentId && $index ? $parentId.$sep.$index : $index);
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function id()
    {
        return $this->id;
    }

    public function parent()
    {
        if ($this->parentId && !$this->parent) {
            $this->parent = Service::repository($this->schema()->parent()->entity(), $this->parentId);
        }
        return $this->parent;
    }

    public function index()
    {
        return $this->idx;
    }

    public function name()
    {
        return $this->name;
    }

    public function subtype()
    {
        return $this->schema()->subtype($this->subtype);
    }

    public function schema()
    {
        if (!$this->schema) {
            $this->schema = Service::repository(Schema::class)->find($this->schma);
        }
        return $this->schema;
    }

    public function path()
    {
        if ($this->parent()) {
            return $this->parent()->path().'/'.$this->index();
        }
        return '/'.$this->index();
    }

    private function loadProperties()
    {
        if ($this->properties) {
            return;
        }
        $repo = Service::repository($this->schema()->entity());
        $this->properties = $repo->findProperties($this->id(), $this->schema(), $this->subtype);
    }

    public function properties()
    {
        $this->loadProperties();
        return $this->properties;
    }

    public function property(/*string*/ $key)
    {
        $this->loadProperties();
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }
        return null;
    }

    public function setAttribute(/*string*/ $key, $value, $parameter = null)
    {
        // TODO validate is valid property
        $this->loadProperties();
        $oldValue = (isset($this->properties[$key]) ? $this->properties[$key] : null);
        $newValue = ($parameter ? [$parameter, $value] : $value);
        $this->registerModified($key, $oldValue, $newValue);
        $this->properties[$key] = $newValue;
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

    public function related(/*string*/ $module = null)
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

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setMappedSuperClass();
        $builder->setCustomRepositoryClass('ARK\\ORM\\ItemEntityRepository');
        $builder->addStringKey('id', 30);
        $builder->addStringField('parentModule', 30, 'parent_module');
        $builder->addStringField('parentId', 30, 'parent_id');
        $builder->addStringField('idx', 30);
        $builder->addStringField('name', 30);
        //$builder->addStringField('subtype', 30);
        $builder->addStringField('schma', 30);
        $builder->addField('lastModifiedBy', 'integer', [], 'mod_by');
        $builder->addField('lastModifiedOn', 'datetime', [], 'mod_on');
        $builder->addField('createdBy', 'integer', [], 'cre_by');
        $builder->addField('createdOn', 'datetime', [], 'cre_on');
    }
}
