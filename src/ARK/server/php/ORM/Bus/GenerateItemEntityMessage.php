<?php

/**
 * ARK Command Message.
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

namespace ARK\ORM\Bus;

class GenerateItemEntityMessage
{
    protected $project = '';
    protected $namespace = '';
    protected $entity = '';
    protected $classname = '';
    protected $schema = '';

    public function __construct(string $project, string $namespace, string $entity, string $classname, string $schema)
    {
        $this->project = $project;
        $this->namespace = $namespace;
        $this->entity = $entity;
        $this->classname = $classname;
        $this->schema = $schema;
    }

    public function project() : string
    {
        return $this->project;
    }

    public function namespace() : string
    {
        return $this->namespace;
    }

    public function entity() : string
    {
        return $this->entity;
    }

    public function classname() : string
    {
        return $this->classname;
    }

    public function schema() : string
    {
        return $this->schema;
    }
}
