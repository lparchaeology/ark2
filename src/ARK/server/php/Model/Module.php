<?php

/**
 * ARK Model Module
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

use ARK\Model\EnabledTrait;
use ARK\Model\KeywordTrait;
use ARK\ORM\ClassMetadata;
use ARK\ORM\ClassMetadataBuilder;
use Doctrine\Common\Collections\ArrayCollection;

class Module
{
    use EnabledTrait;
    use KeywordTrait;

    protected $module = '';
    protected $resource = '';
    protected $entity = '';
    protected $table = null;
    protected $core = false;
    protected $schemas = null;

    public function __construct()
    {
        $this->schemas = new ArrayCollection();
    }

    public function name()
    {
        return $this->module;
    }

    public function resource()
    {
        return $this->resource;
    }

    public function entity()
    {
        return $this->entity;
    }

    public function table()
    {
        return $this->table;
    }

    public function isCore()
    {
        return $this->core;
    }

    public function schemas()
    {
        return $this->schemas;
    }

    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata, 'ark_module');
        $builder->addStringKey('module', 30);
        $builder->addStringField('resource', 30);
        $builder->addStringField('entity', 100);
        $builder->addStringField('table', 30, 'tbl');
        $builder->addField('core', 'boolean');
        EnabledTrait::buildEnabledMetadata($builder);
        KeywordTrait::buildKeywordMetadata($builder);
        $builder->addOneToMany('schemas', 'ARK\Model\Schema', 'module');
        $builder->setReadOnly();
    }
}
