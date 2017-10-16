<?php

/**
 * ARK Model Module.
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

namespace ARK\Model\Schema;

use ARK\Model\EnabledTrait;
use ARK\Model\Item;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use ARK\Service;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Module
{
    use EnabledTrait;
    use KeywordTrait;

    protected $module = '';
    protected $resource = '';
    protected $superclass = '';
    protected $project = '';
    protected $namespace = '';
    protected $entity = '';
    protected $classname = '';
    protected $table = '';
    protected $core = false;
    protected $schemas;

    public function __construct()
    {
        $this->schemas = new ArrayCollection();
    }

    public function id() : string
    {
        return $this->module;
    }

    public function superclass() : string
    {
        return $this->superclass;
    }

    public function resource() : string
    {
        return $this->resource;
    }

    public function project() : string
    {
        return $this->project;
    }

    public function table() : string
    {
        return $this->table;
    }

    public function isCore() : bool
    {
        return $this->core;
    }

    public function schemas() : Collection
    {
        return $this->schemas;
    }

    public function find(string $id) : ?Item
    {
        $item = Service::database()->getItem($this->table, $id);
        $classname = Service::database()->getSuperclassForSchema($item['schma']);
        return ORM::find($classname, $id);
    }

    public static function loadMetadata(ClassMetadata $metadata) : void
    {
        // Table
        $builder = new ClassMetadataBuilder($metadata, 'ark_model_module');
        $builder->setReadOnly();

        // Key
        $builder->addStringKey('module', 30);

        // Fields
        $builder->addStringField('resource', 30);
        $builder->addMappedStringField('tbl', 'table', 30);
        $builder->addField('core', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);

        // Associations
        $builder->addOneToManyField('schemas', Schema::class, 'module');
    }
}
