<?php

/**
 * ARK Model Version Trait
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

use ARK\ORM\ClassMetadataBuilder;

trait VersionTrait
{
    protected $creator = null;
    protected $created = null;
    protected $modifier = null;
    protected $modified = null;
    protected $version = '';

    public function createdOn()
    {
        return $this->created;
    }

    public function createdBy()
    {
        return $this->creator;
    }

    public function lastModifiedOn()
    {
        return $this->modified;
    }

    public function lastModifiedBy()
    {
        return $this->modifier;
    }

    public function version()
    {
        return $this->version;
    }

    public function refreshVersion()
    {
        // TODO Auto-update behaviour
        //$user = Service::user();
        if (!$this->creator || !$this->created) {
            $this->creator = 0;//$user->id();
            $this->created = new \DateTime;
        }
        $this->modifier = 0;//$user->id();
        $this->modified = new \DateTime;
    }

    public static function buildVersionMetadata(ClassMetadataBuilder $builder)
    {
        $builder->addField('modifier', 'integer');
        $builder->addField('modified', 'datetime');
        $builder->addField('creator', 'integer');
        $builder->addField('created', 'datetime');
        $builder->addStringField('version', 128);
    }
}
